<?php

namespace App\Http\Controllers;

use App\Domains\Styles\Actions\CreateStyle;
use App\Domains\Styles\Actions\UpdateCustomStyle;
use App\Domains\Styles\Actions\UpdateStyle;
use App\Domains\Styles\Dto\CustomizedStyle as StyleDto;
use App\Http\Requests\Styles\StyleStoreRequest;
use App\Http\Requests\Styles\StyleUpdateRequest;
use App\Models\Colour;
use App\Models\EmbellishmentStyle;
use App\Models\EmbellishmentType;
use App\Models\Factory;
use App\Models\Style;
use App\Models\StylePanel;
use App\Models\StylePanelFabric;
use App\Repositories\CategoryRepository;
use App\Repositories\CustomerRepositoryInterface as CustomerRepository;
use App\Repositories\ItemTypeRepository;
use App\Repositories\MaterialRepository;
use App\Repositories\SizeRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class CustomizedStylesController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->get('q');

        /** @var Collection $internalStyles */
        $internalStyles = Style::query()
            ->internal()
            ->with('itemType')
            ->where('styles_type', "Customized")
            ->when($q, function ($query, $q) {
                return $query
                    ->where('code', 'like', "%{$q}%")
                    ->orWhere('name', 'like', "%{$q}%");
            })
            ->paginate()
            ->withQueryString();

        return Inertia::render('Styles/CustomizedStyles/Index', [
            'internal-styles' => $internalStyles
        ]);
    }

    public function create(
        CustomerRepository $customerRepository,
        CategoryRepository $categoryRepository,
        ItemTypeRepository $itemTypeRepository,
        SizeRepository $sizeRepository,
        MaterialRepository $materialRepository,
        Request $request,
    ) {
        $factories = Factory::all();
        $customers = $customerRepository->getAll();
        $categories = $categoryRepository->getAll();
        $itemTypes = $itemTypeRepository->getAll();
        $sizes = $sizeRepository->getAll();
        $materials = $materialRepository->getAll();
        $styles = Style::where('styles_type','LIKE', "General")->get()->toArray();
        $colours = Colour::query()->get();
        /*
        foreach ($styles as $style) {
            print($style['id']."-".$style['code']."<BR/>");
        }
        */
        $parentStyleCode = null;

        if ($request->has('parent_id')) {
            $parent_id = $request->get('parent_id');
            $parentStyleCode = Style::find($parent_id);
            $parentStyleCode->load(['itemType', 'categories', 'sizes', 'factories', 'panels.consumption']);
            $categories = $parentStyleCode->categories;
            $sizes = $parentStyleCode->sizes;


            $parentStyleCode->load(['panels.fabrics.variations.colour']);

            // Following code might not be needed
            $material_ids = [];

            foreach($parentStyleCode->panels as $panel){
                $material_ids[] = $panel->fabrics[0]->id;
            }

            $avail_materials_colours = DB::table('material_variations')
                ->join('material_inventories', function ($join) use ($material_ids) {
                    $join->on('material_variations.id', '=', 'material_inventories.material_variation_id')
                        ->whereIn('material_variations.material_id', $material_ids);
                })
                ->join('colours', 'material_variations.colour_id', '=', 'colours.id')
                ->groupBy('colours.id')
                ->select('colours.*')
                ->get();

            $colours = $avail_materials_colours;
            $parentStyleCode->embellishments_form = [];
        }

        $style = new StyleDto([
            'sizes' => [],
            'panels' => [],
            'embellishments_form' => [],
            'belongs_to' => 'internal'
        ]);

        return Inertia::render('Styles/CustomizedStyles/Create', [
            'styleData' => $style,
            'customers' => $customers,
            'categories' => $categories,
            'itemTypes' => $itemTypes,
            'sizes' => $sizes,
            'embellishments' => EmbellishmentType::all(),
            'factories' => $factories,
            'materials' => $materials,
            'styles' => $styles,
            'parentStyleCode' => $parentStyleCode,
            'styleType' => 'Customized',
            'customer' => $request->get('customer'),
            'colours' => $colours
        ]);
    }

    public function store(StyleStoreRequest $request)
    {
        try {
            $image_path = '';

            if ($request->hasFile('image')) {
                $image_path = $request->file('image')->store('style_images', 'public');
            }
            $request->merge(['style_image' => $image_path]);
            $style = resolve(CreateStyle::class)->execute($request->toDto());
            return Redirect::route('style.customized.index')
                ->with(['message' => 'successfully updated']);
        } catch (\Exception $ex) {
            return back()->withInput()->withErrors(['message' => $ex->getMessage()]);
        }
    }

    public function edit(
        CustomerRepository $customerRepository,
        CategoryRepository $categoryRepository,
        ItemTypeRepository $itemTypeRepository,
        SizeRepository $sizeRepository,
        MaterialRepository $materialRepository,
        Style $style,
        Request $request
    ) {
        $factories = Factory::all();
        $customers = $customerRepository->getAll();
        $categories = $categoryRepository->getAll();
        $itemTypes = $itemTypeRepository->getAll();
        $sizes = $sizeRepository->getAll();
        $materials = $materialRepository->getAll();
        $colours = Colour::query()->get();


        $style->load(['itemType', 'categories', 'sizes', 'factories', 'panels.consumption', 'customer', 'parentStyle','panels.color', 'embellishments.embellishmentType']);
        $style->load(['panels.fabrics.variations.colour']);
//        dd($style->customer);

        $styleDto = new StyleDto($style->toArray());
        $styleDto->embellishments_form = $style->embellishments->toArray();

        $parent_style_code = Style::find($style->parent_style_id);
        $parent_style_code->load(['itemType', 'categories', 'sizes', 'factories', 'panels.consumption', 'customer']);

        $parent_style_code->load(['panels.fabrics.variations.colour']);

        $material_ids = [];
        foreach($parent_style_code->panels as $panel){
            $material_ids[] = $panel->fabrics[0]->id;
        }

        $avail_materials_colours = DB::table('material_variations')
            ->join('material_inventories', function ($join) use ($material_ids) {
                $join->on('material_variations.id', '=', 'material_inventories.material_variation_id')
                    ->whereIn('material_variations.material_id', $material_ids);
            })
            ->join('colours', 'material_variations.colour_id', '=', 'colours.id')
            ->groupBy('colours.id')
            ->select('colours.*')
            ->get();

        $colours = $avail_materials_colours;
        $selectedPanels = [];
        foreach ($style->panels as $panel) {
            $selectedPanels[$panel->id] = array(
                'colourId' => $panel->color_id,
                'fabricId' => $panel->default_fabric_id,
                'id' => $panel->id
            );
        }

//        $parentStyleCode->embellishments_form = [];

        return Inertia::render('Styles/CustomizedStyles/Edit', [
            'styleData' => $styleDto,
            'factories' => $parent_style_code->factories,
            'materials' => $materials,
            'colours' => $colours,
            'parentStyle' => $parent_style_code,
            'thisStyle' => $style,
            'selectedPanels' => $selectedPanels,
            'embellishments' => EmbellishmentType::all(),
            'assetUrl' => Storage::url('')
        ]);
    }

    public function update(Style $style, Request $request)
    {
        try {
            $request->validate([
                'customized_panels' => 'sometimes|array',
                'customized_panels.*.colourId' => 'integer',
                'customized_panels.*.fabricId' => 'integer',
                'customized_panels.*.id' => 'integer',
                'embellishments_form' => 'sometimes',
            ]);

            foreach($request->customized_panels as $panel){

               $stylePanel = StylePanel::query()->find($panel['id']);

               $stylePanel->update([
                   'default_fabric_id' => $panel['fabricId'],
                   'color_id' => $panel['colourId']
               ]);
            }

            if ($request->embellishments_form){
                foreach($request->embellishments_form as $embellishment) {
                    if(!$embellishment['already_uploaded'] && array_key_exists('id',$embellishment)){
                        $dbRecord = $style->embellishments()->where('id', $embellishment['id'])->first();
                        $image_path = $embellishment['image']->store('style_images', 'public');

                        $dbRecord->update(['image_path' => $image_path]);
                    }

                    if ($embellishment['already_uploaded'] && array_key_exists('id',$embellishment)){
                        $dbRecord = $style->embellishments()->where('id', $embellishment['id'])->first();

                        $dbRecord->update([
                            'embellishment_id' => $embellishment['type']['id'],
                            'position' => $embellishment['position']
                        ]);
                    }

                    if (!array_key_exists('id',$embellishment)) {
                        $embellishmentStyle = new EmbellishmentStyle();
                        $image_path = $embellishment['image']->store('style_images', 'public');
                        $embellishmentStyle->image_path = $image_path;
                        $embellishmentStyle->embellishment_id = $embellishment['type']['id'];
                        $embellishmentStyle->position = $embellishment['position']['value'];

                        $style->embellishments()->save($embellishmentStyle);
                    }
                }
            }

            if (!$request->embellishments_form) {
                $style->embellishments()->delete();
            }

            return Redirect::route('style.customized.index')
                ->with(['message' => 'successfully updated']);

        } catch (\Exception $ex) {
            return back()->withInput()->withErrors(['message' => $ex->getMessage()]);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmbellishmentRequest;
use App\Models\EmbellishmentType;
use App\Models\ItemType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class SettingsEmbellishmentsController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->get('q');

        $embellishmentType = EmbellishmentType::query()
            ->when($q, function ($query, $q) {
                return $query
                    ->where('type', 'like', "%{$q}%");
            })
            ->paginate()
            ->withQueryString();

        return Inertia::render(
            'Settings/Embellishments/Index',
            [
                'embellishments' => $embellishmentType
            ]
        );
    }

    public function create()
    {
        return Inertia::render('Settings/Embellishments/Create');
    }

    public function store(StoreEmbellishmentRequest $request)
    {
        try {
            collect($request->validated())->map(function ($embellishmentType){
                EmbellishmentType::create(
                    ['type' => $embellishmentType['type']]
                );
            });

            return Redirect::route('settings.embellishments.index')
                ->with(['message' => 'successfully saved']);

        } catch (\Exception $ex) {
            return back()->withInput()->withErrors(['message' => $ex->getMessage()]);
        }
    }
}

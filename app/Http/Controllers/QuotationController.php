<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Domains\FactoryOrder\AggregateRoots\QuotationAggregateRoot;
use App\Domains\FactoryOrder\Data\QuotationCreateData;
use App\Domains\FactoryOrder\Data\QuotationCreateEmbellishmentData;
use App\Domains\FactoryOrder\Data\QuotationFreightData;
use App\Domains\FactoryOrder\Data\QuotationItemData;
use App\Http\Resources\QuotationResource;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Embellishment;
use App\Models\FreightCharge;
use App\Models\Quotation;
use App\Models\Style;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class QuotationController extends Controller
{
    public function index(Request $request)
    {
        $quotationsQuery = Quotation::query();
        if (isset($request->get('filter')['my'])) {
            $quotationsQuery->where(function ($whereQuery) {
                $whereQuery->where('sales_agent_id', '=', auth()->user()->id)
                    ->orWhere('customer_agent_id', '=', auth()->user()->id);
            });
        }

        $quotations = $quotationsQuery->paginate();

        return Inertia::render('Quotations/Index', [
            'quotations' => QuotationResource::collection($quotations),
            'propFilters' => $request->get('filter')
        ]);
    }

    public function create(Request $request)
    {
        $customers = Customer::query()->with(['csAgent', 'salesAgent'])->get();
        $salesAgents = User::query()->role(User::ROLE_SALES_AGENT)->get();
        $csAgents = User::query()->role(User::ROLE_CUSTOMER_SERVICE_AGENT)->get();
        $freightCharges = FreightCharge::all();
        $categories = Category::all();
        $styleCodes = [];
        $embellishments = Embellishment::all();

        if ($request->get('category_id')) {
            $styleCodes = Style::query()
                ->whereHas('categories', function ($query) use ($request) {
                    $query->where('category_id', '=', $request->get('category_id'));
                })->get();
        }

        return Inertia::render('Quotations/Create', [
            'customerOptions' => $customers,
            'propSalesAgents' => $salesAgents,
            'propCustomerSupportAgents' => $csAgents,
            'propCategories' => $categories,
            'propStyleCodes' => $styleCodes,
            'propEmbellishments' => $embellishments,
            'propFreightCharges' => $freightCharges,
        ]);
    }

    public function store(Request $request)
    {
        $aggregateId = Str::uuid()->toString();

        $items = [];
        foreach ($request->input('items') as $item) {
            $item = (object) $item;
            $embellishments = [];
            foreach ($item->embellishments as $embellishment) {
                $embellishment = (object) $embellishment;
                $embellishments[] = new QuotationCreateEmbellishmentData(
                    embellishmentId: $embellishment->id,
                    position: $embellishment->position,
                    quantity: (int)$embellishment->quantity,
                    cost: (float)$embellishment->cost,
                    totalEmbellishmentCost:(float) $embellishment->total_cost,
                    setupQuantity: (int) $embellishment->setup_quantity,
                    setupCost: (float) $embellishment->setup_cost,
                    totalSetupCost: (float)$embellishment->total_setup_cost,
                    totalCost: (float) $embellishment->total,
                );
            }

            $items[] = new QuotationItemData(
                styleCodeId: $item->style_code['id'],
                categoryId: $item->category_id,
                quantity: (int) $item->quantity,
                priceType: $item->price_type,
                unitPrice: (float) $item->unit_price,
                totalUnitPrice: (float) $item->unit_price_total,
                embellishmentType: $item->type,
                embellishments: $embellishments,
                note: $item->notes,
                embellishmentCostTotal: (float) $item->embellishment_total,
            );
        }

        $data = new QuotationCreateData(
            aggregateId: $aggregateId,
            createdById: auth()->id(),
            customerId: $request->input('customer_id'),
            salesAgentId: $request->input('sales_agent_id'),
            customerSalesAgentId: $request->input('customer_service_agent_id'),
            type:  $request->input('type'),
            club:  $request->input('club'),
            attentionPerson:  $request->input('attention_person'),
            deliveryAddress:  $request->input('delivery_address'),
            items: $items,
            freight: new QuotationFreightData(
                freightId: $request->input('freight.id'),
                unitAmount: (float) $request->input('freight.amount'),
                boxCount:$request->input('freightBoxesCount'),
                surgePercentage: (float) $request->input('freightSurgePercentageAmount'),
                surgeAdded: $request->input('freightSurgeAdded'),
                totalAmount: (float) $request->input('totalFreightCost'),
            ),
            paymentTerm20: $request->input('payment_term_20'),
            itemsNetPrice: (float) $request->input('items_net_price'),
            grossAmount: (float) $request->input('gross_price'),
        );


        QuotationAggregateRoot::retrieve($aggregateId)
            ->createQuotation($data)
            ->persist();

        return response()->redirectToRoute('quotations.index')->with(['success' => 'Successfully created']);
    }

    public function show(Quotation $quotation)
    {
        $quotation->load(['customer.addresses', 'items', 'freight.defaultFreightCost']);

        return Inertia::render('Quotations/Show', [
            'propQuotation' => (new QuotationResource($quotation)),
        ]);
    }

    public function salesAction(Quotation $quotation, Request $request)
    {
        $aggregateRoot = QuotationAggregateRoot::retrieve($quotation->aggregate_id);
        if ($request->input('action') == 'approved') {
            $aggregateRoot->salesApprovedQuotation(auth()->user()->id);
        } else {
            $aggregateRoot->salesRejectedQuotation(auth()->user()->id, $request->input('reason'));
        }

        $aggregateRoot->persist();
    }
}

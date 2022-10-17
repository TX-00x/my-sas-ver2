<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Embellishment;
use App\Models\FreightCharge;
use App\Models\Style;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class QuotationController extends Controller
{
    public function index()
    {
        return Inertia::render('Quotations/Index');
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

    public function view()
    {
        return Inertia::render('Quotations/Show', []);
    }
}

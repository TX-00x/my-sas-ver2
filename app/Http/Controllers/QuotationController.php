<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Customer;
use App\Models\CustomerType;
use App\Models\Embellishment;
use App\Models\EmbellishmentType;
use App\Models\GarmentPrice;
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
        $customers = Customer::query()->select('id', 'name')->get();
//        $csAgents = Customer::query()
//            ->with('csAgent')
//            ->has('csAgent')->get()
//            ->pluck('csAgent');
        $users = User::query()->select('id', 'name')->get();
        $customerTypes = CustomerType::all();
        $garmentPrices = GarmentPrice::all();
        $embellishments = Embellishment::all();
        $categories = Category::all();
        $embellishmentTypes = EmbellishmentType::all();


        return Inertia::render('Quotations/Create',[
            'customers' => $customers,
            'customerTypes' => $customerTypes,
            'csAgents' => $users,
            'garmentPrices' => $garmentPrices,
            'embellishments' => $embellishments,
            'categories' => $categories,
            'embellishmentTypes' => $embellishmentTypes
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Customer;
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

        return Inertia::render('Quotations/Create', [
            'customerOptions' => $customers
        ]);
    }
}

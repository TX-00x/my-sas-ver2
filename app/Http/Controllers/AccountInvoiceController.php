<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AccountInvoiceController extends Controller
{
    public function index()
    {
        return Inertia::render('Accounts/Invoices/Index');
    }

    public function create()
    {
        $customers = Customer::query()->with(['csAgent', 'salesAgent'])->get();

        return Inertia::render('Accounts/Invoices/Create',[
            'customerOptions' => $customers,
        ]);
    }
}

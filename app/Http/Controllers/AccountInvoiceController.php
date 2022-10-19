<?php

namespace App\Http\Controllers;

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
        return Inertia::render('Accounts/Invoices/Create');
    }
}

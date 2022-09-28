<?php

namespace App\Http\Controllers;

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
        return Inertia::render('Quotations/Create');
    }
}

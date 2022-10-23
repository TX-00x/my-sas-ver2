<?php

namespace App\Http\Controllers;

use App\Domains\FactoryOrder\AggregateRoots\QuotationAggregateRoot;
use App\Http\Resources\QuotationResource;
use App\Models\Quotation;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CustomerQuotationController extends Controller
{
    public function show(Quotation $quotation, Request $request)
    {
        if ($request->hasValidSignature() == false) {
            return "URL Manipulation detected";
        }


        QuotationAggregateRoot::retrieve($quotation->aggregate_id)
            ->customerOpenedTheQuotation($request->get('email'))
            ->persist()
        ;

        return Inertia::render('Quotations/CustomerShow', [
            'propQuotation' => new QuotationResource($quotation)
        ]);
    }

    public function store(Quotation $quotation, Request $request)
    {
        $aggregateRoot = QuotationAggregateRoot::retrieve($quotation->aggregate_id);
        if ($request->input('action') == 'approved') {
            $aggregateRoot->customerApprovedQuotation();
        } else {
            $aggregateRoot->customerRejectedQuotation($request->input('reason'));
        }

        $aggregateRoot->persist();
    }
}

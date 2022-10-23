<?php

namespace App\Domains\FactoryOrder\Reactors;

use App\Domains\FactoryOrder\AggregateRoots\QuotationAggregateRoot;
use App\Domains\FactoryOrder\Events\Internal\QuotationCreated;
use App\Domains\FactoryOrder\Events\Internal\SalesApprovedQuotation;
use App\Domains\FactoryOrder\Events\Internal\SalesRejectedQuotation;
use App\Models\Quotation;
use App\Notifications\InformCustomerWhenQuotationIsReady;
use App\Notifications\InformSalesWhenQuotationIsCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;
use Spatie\EventSourcing\EventHandlers\Reactors\Reactor;

class QuotationReactor extends Reactor implements ShouldQueue
{
    public function onQuotationCreated(QuotationCreated $quotationCreated)
    {
        // send mail to sales if needed
        $quotation = Quotation::query()
            ->where('aggregate_id', '=', $quotationCreated->aggregateRootUuid())
            ->get()
            ->first();

        if ($quotation->requires_sales_approval) {
            $quotation->sales_agent->notify(new InformSalesWhenQuotationIsCreated($quotation));
            return;
        }

        Notification::route('mail', [$quotation->customer->email])
            ->notify(new InformCustomerWhenQuotationIsReady($quotation, $quotation->customer));
    }

    public function onSalesApprovedQuotation(SalesApprovedQuotation $approvedQuotation)
    {
        $quotation = Quotation::query()
            ->where('aggregate_id', '=', $approvedQuotation->aggregateRootUuid())
            ->get()
            ->first();

        Notification::route('mail', [$quotation->customer->email])
            ->notify(new InformCustomerWhenQuotationIsReady($quotation, $quotation->customer));
    }

    public function onSalesRejectedQuotation(SalesRejectedQuotation $rejectedQuotation)
    {
        $quotation = Quotation::query()
            ->where('aggregate_id', '=', $rejectedQuotation->aggregateRootUuid())
            ->get()
            ->first();
        // inform customer service
    }
}

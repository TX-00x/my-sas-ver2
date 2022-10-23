<?php

namespace App\Domains\FactoryOrder\Projectors;

use App\Domains\FactoryOrder\Actions\CreateQuotation;
use App\Domains\FactoryOrder\AggregateRoots\QuotationAggregateRoot;
use App\Domains\FactoryOrder\Events\Internal\CustomerApprovedQuotation;
use App\Domains\FactoryOrder\Events\Internal\SalesApprovedQuotation;
use App\Domains\FactoryOrder\Events\Internal\SalesRejectedQuotation;
use App\Domains\FactoryOrder\Events\Internal\CustomerRejectedQuotation;
use App\Domains\FactoryOrder\Events\Internal\QuotationCreated;
use App\Models\Quotation;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;
use Spatie\EventSourcing\Facades\Projectionist;

class QuotationProjector extends Projector
{
    public function onQuotationCreated(QuotationCreated $quotationCreated)
    {
        /** @var CreateQuotation $createQuotationAction */
        $createQuotationAction = resolve(CreateQuotation::class);
        $createQuotationAction->execute($quotationCreated->createData);
    }

    public function onSalesApprovedQuotation(SalesApprovedQuotation $approvedQuotation)
    {
        $quotation = Quotation::query()
            ->where('aggregate_id', '=', $approvedQuotation->aggregateRootUuid())
            ->get()
            ->first();
        $quotation->sales_action_taken_by_id = $approvedQuotation->approvedBy;
        $quotation->sales_action = 'approved';
        $quotation->save();
    }

    public function onSalesRejectedQuotation(SalesRejectedQuotation $rejectedQuotation)
    {
        $quotation = Quotation::query()
            ->where('aggregate_id', '=', $rejectedQuotation->aggregateRootUuid())
            ->get()
            ->first();
        $quotation->sales_action_taken_by_id = $rejectedQuotation->rejectedBy;
        $quotation->sales_action = 'rejected';
        $quotation->sales_rejected_reason = $rejectedQuotation->reason;
        $quotation->save();
    }

    public function onCustomerApprovedQuotation(CustomerApprovedQuotation $customerApprovedQuotation)
    {
        $quotation = Quotation::query()
            ->where('aggregate_id', '=', $customerApprovedQuotation->aggregateRootUuid())
            ->get()
            ->first();
        $quotation->customer_action = 'approved';
        $quotation->customer_action_taken_at = now();
        $quotation->save();
    }

    public function onCustomerRejectedQuotation(CustomerRejectedQuotation $customerRejectedQuotation)
    {
        $quotation = Quotation::query()
            ->where('aggregate_id', '=', $customerRejectedQuotation->aggregateRootUuid())
            ->get()
            ->first();

        $quotation->customer_action = 'rejected';
        $quotation->customer_rejected_reason = $customerRejectedQuotation->reason;
        $quotation->customer_action_taken_at = now();
        $quotation->save();
    }
}

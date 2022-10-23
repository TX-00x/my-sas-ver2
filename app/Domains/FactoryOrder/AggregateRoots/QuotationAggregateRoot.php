<?php

namespace App\Domains\FactoryOrder\AggregateRoots;

use App\Domains\FactoryOrder\Data\QuotationCreateData;
use App\Domains\FactoryOrder\Events\Internal\CustomerApprovedQuotation;
use App\Domains\FactoryOrder\Events\Internal\SalesApprovedQuotation;
use App\Domains\FactoryOrder\Events\Internal\SalesRejectedQuotation;
use App\Domains\FactoryOrder\Events\Internal\CustomerRejectedQuotation;
use App\Domains\FactoryOrder\Events\Internal\CustomerViewedQuotation;
use App\Domains\FactoryOrder\Events\Internal\QuotationCreated;
use App\Models\Customer;
use Carbon\Carbon;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class QuotationAggregateRoot extends AggregateRoot
{
    public function createQuotation(QuotationCreateData $createData): self
    {
        $this->recordThat(new QuotationCreated($createData));

        return $this;
    }

    public function salesApprovedQuotation(int $approvedBy)
    {
        $this->recordThat(new SalesApprovedQuotation($approvedBy));
    }

    public function salesRejectedQuotation(int $rejectedBy, string $reason)
    {
        $this->recordThat(new SalesRejectedQuotation($rejectedBy, $reason));
    }

    public function customerOpenedTheQuotation(string $openedByEmail)
    {
        $this->recordThat(new CustomerViewedQuotation(Carbon::now(), $openedByEmail));

        return $this;
    }

    public function customerApprovedQuotation(): self
    {
        $this->recordThat(new CustomerApprovedQuotation());

        return $this;
    }

    public function customerRejectedQuotation(string $reason): self
    {
        $this->recordThat(new CustomerRejectedQuotation($reason));

        return $this;
    }
}

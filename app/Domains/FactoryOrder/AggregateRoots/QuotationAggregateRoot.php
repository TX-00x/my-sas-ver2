<?php

namespace App\Domains\FactoryOrder\AggregateRoots;

use App\Domains\FactoryOrder\Data\QuotationCreateData;
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

    public function customerOpenedTheQuotation(string $openedByEmail)
    {
        $this->recordThat(new CustomerViewedQuotation(Carbon::now(), $openedByEmail));
    }
}

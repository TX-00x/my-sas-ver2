<?php

namespace App\Domains\FactoryOrder\AggregateRoots;

use App\Domains\FactoryOrder\Data\QuotationCreateData;
use App\Domains\FactoryOrder\Events\Internal\QuotationCreated;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class QuotationAggregateRoot extends AggregateRoot
{
    public function createQuotation(QuotationCreateData $createData): self
    {
        $this->recordThat(new QuotationCreated($createData));

        return $this;
    }
}

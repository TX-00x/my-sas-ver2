<?php

namespace App\Domains\FactoryOrder\Events\Internal;

use App\Domains\FactoryOrder\Data\QuotationCreateData;
use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class QuotationCreated extends ShouldBeStored
{
    public QuotationCreateData $createData;

    public function __construct(QuotationCreateData $createData)
    {
        $this->createData = $createData;
    }
}

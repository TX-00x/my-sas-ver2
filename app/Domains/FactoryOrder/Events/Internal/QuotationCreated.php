<?php

namespace App\Domains\FactoryOrder\Events\Internal;

use App\Domains\FactoryOrder\Data\QuotationCreateData;

class QuotationCreated extends \Spatie\EventSourcing\StoredEvents\ShouldBeStored
{
    public QuotationCreateData $createData;

    public function __construct(QuotationCreateData $createData)
    {
        $this->createData = $createData;
    }
}

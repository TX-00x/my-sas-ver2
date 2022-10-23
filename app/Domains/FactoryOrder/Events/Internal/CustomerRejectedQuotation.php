<?php

namespace App\Domains\FactoryOrder\Events\Internal;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class CustomerRejectedQuotation extends ShouldBeStored
{
    public function __construct(public string $reason)
    {}
}

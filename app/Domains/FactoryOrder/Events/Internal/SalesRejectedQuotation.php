<?php

namespace App\Domains\FactoryOrder\Events\Internal;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class SalesRejectedQuotation extends ShouldBeStored
{
    public function __construct(public int $rejectedBy, public string $reason)
    {

    }
}

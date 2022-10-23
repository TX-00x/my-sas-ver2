<?php

namespace App\Domains\FactoryOrder\Events\Internal;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class SalesApprovedQuotation extends ShouldBeStored
{
    public function __construct(public int $approvedBy)
    {

    }
}

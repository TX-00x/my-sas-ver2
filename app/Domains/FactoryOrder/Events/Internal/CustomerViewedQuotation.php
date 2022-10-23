<?php

namespace App\Domains\FactoryOrder\Events\Internal;

use Carbon\Carbon;
use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class CustomerViewedQuotation extends ShouldBeStored
{
    public function __construct(
        public Carbon $viewedAt,
        public string $opendByEmail,
    ){}
}

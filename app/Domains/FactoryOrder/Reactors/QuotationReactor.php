<?php

namespace App\Domains\FactoryOrder\Reactors;

use App\Domains\FactoryOrder\Events\Internal\QuotationCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Spatie\EventSourcing\EventHandlers\Reactors\Reactor;

class QuotationReactor extends Reactor implements ShouldQueue
{
    public function onQuotationCreated(QuotationCreated $quotationCreated)
    {
        // send mail to sales if needed
    }
}

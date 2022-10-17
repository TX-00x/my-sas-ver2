<?php

namespace App\Domains\FactoryOrder\Projectors;

use App\Domains\FactoryOrder\Actions\CreateQuotation;
use App\Domains\FactoryOrder\Events\Internal\QuotationCreated;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class QuotationProjector extends Projector
{
    public function onQuotationCreated(QuotationCreated $quotationCreated)
    {
        /** @var CreateQuotation $createQuotationAction */
        $createQuotationAction = resolve(CreateQuotation::class);
        $createQuotationAction->execute($quotationCreated->createData);
    }
}

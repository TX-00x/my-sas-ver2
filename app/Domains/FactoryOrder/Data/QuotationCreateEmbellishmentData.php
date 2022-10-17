<?php

namespace App\Domains\FactoryOrder\Data;

class QuotationCreateEmbellishmentData
{
    public function __construct(
        public int $embellishmentId,
        public string $position,
        public int    $quantity,
        public float  $cost,
        public float  $totalEmbellishmentCost,
        public int $setupQuantity,
        public float $setupCost,
        public float $totalSetupCost,
        public float $totalCost,
    ){}
}

<?php
declare(strict_types=1);

namespace App\Domains\FactoryOrder\Data;

class QuotationFreightData
{
    public function __construct(
        public int $freightId,
        public float $unitAmount,
        public float $boxCount,
        public float $surgePercentage,
        public bool $surgeAdded,
        public float $totalAmount,
    ){}
}

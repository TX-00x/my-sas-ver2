<?php

namespace App\Domains\FactoryOrder\Data;

class QuotationItemData
{
    /**
     * @param QuotationCreateEmbellishmentData[] $embellishments
     */
    public function __construct(
        public int    $styleCodeId,
        public int $categoryId,
        public int    $quantity,
        public string $priceType,
        public float  $unitPrice,
        public ?float  $totalUnitPrice,
        public string $embellishmentType,
        public array  $embellishments,
        public ?string $note,
        public float  $embellishmentCostTotal,
    ){}
}

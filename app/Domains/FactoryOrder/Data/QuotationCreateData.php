<?php
declare(strict_types=1);

namespace App\Domains\FactoryOrder\Data;

class QuotationCreateData
{
    /**
     * @param $items QuotationItemData[]
     */
    public function __construct(
        public int $createdById,
        public int $customerId,
        public int $salesAgentI,
        public int $customerSalesAgentId,
        public string $type,
        public string $club,
        public string $attentionPerson,
        public string $deliveryAddress,
        public array $items,
        public QuotationFreightData $freight,
        public float $itemsNetPrice,
        public float $grossAmount,
    ) {}
}

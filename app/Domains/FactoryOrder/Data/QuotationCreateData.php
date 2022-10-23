<?php
declare(strict_types=1);

namespace App\Domains\FactoryOrder\Data;

class QuotationCreateData
{
    /**
     * @param $items QuotationItemData[]
     */
    public function __construct(
        public string $aggregateId,
        public int                  $createdById,
        public int                  $customerId,
        public int                  $salesAgentId,
        public int                  $customerSalesAgentId,
        public string               $type,
        public string               $club,
        public string               $attentionPerson,
        public string               $deliveryAddress,
        public array                $items,
        public QuotationFreightData $freight,
        public ?bool $paymentTerm20,
        public float                $itemsNetPrice,
        public float                $grossAmount,
    ) {
        $this->fixItemsCastingWhenReplaying();
    }

    private function fixItemsCastingWhenReplaying()
    {
//        if (sizeof($this->items) > 0) {
//            $itemNotCastedToItemObject = !$this->items[0] instanceof QuotationItemData;
//            if ($itemNotCastedToItemObject) {
//                $items = [];
//                foreach ($this->items as $item) {
//                    $items[] = (QuotationItemData) $item;
//                };
//            }
//        }
    }
}

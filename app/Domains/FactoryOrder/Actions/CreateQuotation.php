<?php

namespace App\Domains\FactoryOrder\Actions;

use App\Domains\FactoryOrder\Data\QuotationCreateData;
use App\Domains\FactoryOrder\Data\QuotationCreateEmbellishmentData;
use App\Domains\FactoryOrder\Data\QuotationItemData;
use App\Models\Embellishment;
use App\Models\Quotation;
use App\Models\QuotationFreight;
use App\Models\QuotationItemEmbellishment;
use Dflydev\DotAccessData\Data;

class CreateQuotation
{
    public function execute(QuotationCreateData $data)
    {
        $quotation = Quotation::create([
            'customer_id' => $data->customerId,
            'sales_agent_id' => $data->salesAgentId,
            'customer_agent_id' => $data->customerSalesAgentId,
//            'quotation_freight_id' => $freight->id,
            'type' => $data->type,
            'club' => $data->club,
            'attention_person' => $data->attentionPerson,
            'items_net_amount' => 0, // to be overridden
            'quotation_gross_amount' => 0, //to be overridden
            'created_by_id' => $data->createdById,
        ]);

        $itemsGrossTotal = 0;
        collect($data->items)->each(function ($itemData) use (&$itemsGrossTotal, $quotation) {
            /** @var QuotationItemData $itemData */
            if (is_array($itemData)) {
                $itemData = (object) $itemData; // this casting is due to event sourcing replay issue
            }

            $item = $quotation->items()->create([
                'style_id' => $itemData->styleCodeId,
                'category_id' => $itemData->categoryId,
                'quantity' => $itemData->quantity,
                'price_type' => $itemData->priceType,
                'unit_price' => $itemData->unitPrice,
                'unit_price_total' => $itemData->totalUnitPrice,
                'production_type' => $itemData->embellishmentType,
                'note' => $itemData->note,
                'embellishment_total' => 0, // to be override below
                'item_gross_total' => 0, // to be override below,
            ]);
            $embellishmentsTotal = 0;
            collect($itemData->embellishments)->each(function ($embellishmentData) use (&$embellishmentsTotal, $item) {
                /** @var QuotationCreateEmbellishmentData $embellishmentData */
                if (is_array($embellishmentData)) {
                    $embellishmentData = (object) $embellishmentData; // this casting is due to event sourcing replay issue
                }
                $embellishment = Embellishment::find($embellishmentData->embellishmentId);

                $totalEmbellishmentCost = $embellishmentData->quantity * $embellishment->cost;
                $totalSetupCost = $embellishmentData->setupQuantity * $embellishment->setup_cost;
                $totalCost = $totalEmbellishmentCost + $totalSetupCost;

                $itemEmbellishment = $item->embellishments()->create([
                    'embellishment_id' => $embellishmentData->embellishmentId,
                    'position' => $embellishmentData->position,
                    'quantity' => $embellishmentData->quantity,
                    'cost' => $embellishment->cost,
                    'total_embellishment_cost' => $totalEmbellishmentCost,
                    'setup_cost' => $embellishment->setup_cost,
                    'setup_quantity' => $embellishmentData->setupQuantity,
                    'total_setup_cost' => $totalSetupCost,
                    'total_cost' => $totalCost
                ]);
                $embellishmentsTotal = $embellishmentsTotal + $totalCost;
            });

            $item->embellishment_total = $embellishmentsTotal;
            $item->item_gross_total = $embellishmentsTotal + $item->unit_price_total;
            $item->save();

            $itemsGrossTotal = $itemsGrossTotal + $item->item_gross_total;
        });

        $quotation->items_net_amount = $itemsGrossTotal;
        $quotation->save();

        // Freight Charges
        $freightCost = ($data->freight->unitAmount * $data->freight->boxCount);
        $surchargePercentageValue = $data->freight->surgeAdded ? $data->freight->surgePercentage : 0;
        $surcharge = 0;
        if ($surchargePercentageValue > 0) {
            $surcharge = $freightCost * ($surchargePercentageValue/100);
        }
        $totalFreightCost = $surcharge + $freightCost;
        $freight = QuotationFreight::create([
            'quotation_id' => $quotation->id,
            'freight_charge_id' => $data->freight->freightId,
            'freight_cost' => $data->freight->unitAmount,
            'boxes_count' => $data->freight->boxCount,
            'surcharge_percentage' => $surchargePercentageValue,
            'total_freight_cost' => $totalFreightCost,
        ]);

        $quotation->quotation_gross_amount = $freight->total_freight_cost + $quotation->items_net_amount;
        $quotation->save();
    }
}

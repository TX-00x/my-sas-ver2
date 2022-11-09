<?php
declare(strict_types=1);

namespace App\Domains\Inventory\Actions;

use App\Domains\Inventory\AggregateRoots\InventoryAggregateRoot;
use App\Models\MaterialInventory;
use App\Models\MaterialInvoice;

class AdjustStock
{
    public function execute(
        MaterialInventory $inventory,
        ?MaterialInvoice $invoice,
        array $invoicesUsages,
        bool $adjustByAddingStock,
        $userId,
        $reason
    )
    {
        $totalUsage = 0;
        foreach ($invoicesUsages as $invoice) {
            $totalUsage = $totalUsage + $invoice['usage'];
        }

        $aggregateRoot = InventoryAggregateRoot::retrieve($inventory->aggregate_id);

        if ($adjustByAddingStock) {
            $aggregateRoot->addStockViaStockAdjust(
                $inventory->unit,
                $totalUsage,
                $userId,
                $invoicesUsages,
                $reason
            );

            $aggregateRoot->persist();
        }

        if (!$adjustByAddingStock) {
            $aggregateRoot->removeStockViaStockAdjust(
                $inventory->unit,
                $totalUsage,
                $userId,
                $invoicesUsages,
                $reason
            );

            $aggregateRoot->persist();
        }

    }
}

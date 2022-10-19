<?php
declare(strict_types=1);

namespace App\Domains\Inventory\Actions;

use App\Domains\Inventory\AggregateRoots\InventoryAggregateRoot;
use App\Models\MaterialInventory;
use App\Models\MaterialInvoice;

class CreateInventoryStockIn
{
    public function execute(MaterialInventory $inventory, ?MaterialInvoice $invoice, array $invoicesUsages, $userId, $reason)
    {
        $totalUsage = 0;
        foreach ($invoicesUsages as $invoice) {
            $totalUsage = $totalUsage + $invoice['usage'];
        }

        $aggregateRoot = InventoryAggregateRoot::retrieve($inventory->aggregate_id);

        if ($totalUsage > 0) {
            $aggregateRoot->addStockViaStockAdjust(
                $inventory->unit,
                $totalUsage,
                $userId,
                $invoicesUsages,
                $reason
            );

            $aggregateRoot->persist();
        }

        if ($totalUsage < 0) {
            $quantity = abs($totalUsage);
            $aggregateRoot->removeStockViaStockAdjust(
                $inventory->unit,
                $quantity,
                $userId,
                $invoicesUsages,
                $reason
            );

            $aggregateRoot->persist();
        }

    }
}

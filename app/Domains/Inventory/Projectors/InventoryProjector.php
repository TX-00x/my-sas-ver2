<?php

namespace App\Domains\Inventory\Projectors;

use App\Domains\Inventory\Events\Internal\InventoryMaterialAdded;
use App\Domains\Inventory\Events\Internal\StockAdded;
use App\Domains\Inventory\Events\Internal\StockAddedManually;
use App\Domains\Inventory\Events\Internal\StockAddedViaStockAdjust;
use App\Domains\Inventory\Events\Internal\StockRemoved;
use App\Domains\Inventory\Events\Internal\StockRemovedManually;
use App\Domains\Inventory\Events\Internal\StockRemovedViaStockAdjust;
use App\Models\InventoryLog;
use App\Models\InventorySummary;
use App\Models\MaterialInventory;
use App\Models\MaterialInvoiceItem;
use Illuminate\Database\Eloquent\Builder;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;
use Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEvent;

class InventoryProjector extends Projector
{
    public function onInventoryMaterialAdded(InventoryMaterialAdded $inventoryMaterialAdded)
    {
        MaterialInventory::create([
            'aggregate_id' => $inventoryMaterialAdded->aggregateRootUuid(),
            'material_variation_id' => $inventoryMaterialAdded->variationId,
            'factory_id' => $inventoryMaterialAdded->factoryId,
            'supplier_id' => $inventoryMaterialAdded->supplierId,
            'unit' => 'm',
            'available_quantity' => 0,
            'allocated_quantity' => 0,
            'usable_quantity' => 0,
            'action_taken_by' => $inventoryMaterialAdded->userId,
            'created_at' => $inventoryMaterialAdded->createdAt(),
            'updated_at' => $inventoryMaterialAdded->createdAt(),
        ]);
    }

    public function onStockAdded(StockAdded $stockAdded)
    {
        $materialInventory = $this->getMaterialFromInventory($stockAdded->aggregateRootUuid());

        $materialInventory->update([
            'available_quantity' => $materialInventory->available_quantity + $stockAdded->quantity
        ]);

        $balance = 0;
        $latestInventoryLog = $this->lastInventoryLog($stockAdded->aggregateRootUuid());
        if ($latestInventoryLog) {
            $balance += $latestInventoryLog->balance;
        }
        $balance += $stockAdded->quantity;

        InventoryLog::create([
            'material_inventories_aggregate_id' => $stockAdded->aggregateRootUuid(),
            'unit' => $stockAdded->unit,
            'in' => $stockAdded->quantity,
            'balance' => $balance,
            'in_invoice_item_id' => $stockAdded->invoiceItemId,
            'in_unit_price' => $stockAdded->unitPrice,
            'in_unit_currency' => $stockAdded->currency,
            'action_taken_by' => $stockAdded->userId,
            'created_at' => $stockAdded->createdAt(),
            'updated_at' => $stockAdded->createdAt(),
        ]);

        // Create Summery Record
        // This is only created once because, inventory will only get one
        // stock add per invoice. others will be adjustment
        $materialInvoiceItem = MaterialInvoiceItem::find($stockAdded->invoiceItemId);
        InventorySummary::firstOrCreate(
            [
                'material_inventory_id' => $materialInventory->id,
                'material_invoice_id' => $materialInvoiceItem->material_invoice_id,
            ],
            [
                'in' => $stockAdded->quantity,
                'out' => 0,
                'unit_price' => $materialInvoiceItem->unit_price,
                'total_price' => $materialInvoiceItem->sub_total,
            ]
        );
    }

    public function onStockAddedViaStockAdjust(StockAddedViaStockAdjust $stockAddedViaStockAdjust)
    {
        $materialInventory = $this->getMaterialFromInventory($stockAddedViaStockAdjust->aggregateRootUuid());

        $materialInventory->update([
            'available_quantity' => $materialInventory->available_quantity + $stockAddedViaStockAdjust->quantity
        ]);

        $balance = $stockAddedViaStockAdjust->quantity;
        $latestInventoryLog = $this->lastInventoryLog($stockAddedViaStockAdjust->aggregateRootUuid());
        if ($latestInventoryLog) {
            $balance += $latestInventoryLog->balance;
        }

        InventoryLog::create([
            'material_inventories_aggregate_id' => $stockAddedViaStockAdjust->aggregateRootUuid(),
            'unit' => $stockAddedViaStockAdjust->unit,
            'in' => $stockAddedViaStockAdjust->quantity,
            'balance' => $balance,
            'reason' => $stockAddedViaStockAdjust->reason,
            'action_taken_by' => $stockAddedViaStockAdjust->userId,
            'created_at' => $stockAddedViaStockAdjust->createdAt(),
            'updated_at' => $stockAddedViaStockAdjust->createdAt(),
        ]);

        foreach ($stockAddedViaStockAdjust->invoices as $invoice) {
            $materialInvoiceItem = MaterialInvoiceItem::find($invoice["invoice"]["id"]);

            $summery = InventorySummary::query()
                ->where('material_inventory_id', '=', $materialInventory->id)
                ->where('material_invoice_id', '=', $materialInvoiceItem->id)
                ->get()
                ->first();

            $summery->in = $summery->in + $invoice["usage"];
            $totalValueAdded = $invoice["usage"] * $summery->unit_price;
            $summery->total_price = $summery->total_price + $totalValueAdded;
            $summery->save();
        }
    }

    public function onStockRemoved(StockRemoved $stockRemoved)
    {
        $materialInventory = $this->getMaterialFromInventory($stockRemoved->aggregateRootUuid());

        $materialInventory->update([
            'available_quantity' => ($materialInventory->available_quantity - $stockRemoved->quantity),
        ]);

        $balance = 0;
        $latestInventoryLog = $this->lastInventoryLog($stockRemoved->aggregateRootUuid());
        if ($latestInventoryLog) {
            $balance = $latestInventoryLog->balance;
        }
        $balance = $balance - $stockRemoved->quantity;

        InventoryLog::create([
            'material_inventories_aggregate_id' => $stockRemoved->aggregateRootUuid(),
            'unit' => $stockRemoved->unit,
            'out' => $stockRemoved->quantity,
            'balance' => $balance,
            'out_order_id' => $stockRemoved->outOrderId,
            'out_style_panel_id' => $stockRemoved->stylePanelId,
            'action_taken_by' => $stockRemoved->userId,
            'created_at' => $stockRemoved->createdAt(),
            'updated_at' => $stockRemoved->createdAt(),
        ]);

        //Add record to summery
        foreach ($stockRemoved->invoices as $invoice) {
            $summery = InventorySummary::query()
                ->where('material_inventory_id', '=', $materialInventory->id)
                ->where('material_invoice_id', '=', $invoice->id)
                ->get()
                ->first();

            $summery->out = $summery->out + $invoice->usage;
            $totalValueReduced = $invoice->usage * $summery->unit_price;
            $summery->total_price = $summery->total_price - $totalValueReduced;
            $summery->save();
        }
    }

    public function onStockRemovedViaStockAdjust(StockRemovedViaStockAdjust $stockRemovedViaStockAdjust)
    {
        $materialInventory = $this->getMaterialFromInventory($stockRemovedViaStockAdjust->aggregateRootUuid());

        $materialInventory->update([
            'available_quantity' => ($materialInventory->available_quantity - $stockRemovedViaStockAdjust->quantity),
        ]);

        $balance = 0;
        $latestInventoryLog = $this->lastInventoryLog($stockRemovedViaStockAdjust->aggregateRootUuid());
        if ($latestInventoryLog) {
            $balance = $latestInventoryLog->balance;
        }
        $balance = $balance - $stockRemovedViaStockAdjust->quantity;

        InventoryLog::create([
            'material_inventories_aggregate_id' => $stockRemovedViaStockAdjust->aggregateRootUuid(),
            'unit' => $stockRemovedViaStockAdjust->unit,
            'out' => $stockRemovedViaStockAdjust->quantity,
            'balance' => $balance,
            'action_taken_by' => $stockRemovedViaStockAdjust->userId,
            'reason' => $stockRemovedViaStockAdjust->reason,
            'created_at' => $stockRemovedViaStockAdjust->createdAt(),
            'updated_at' => $stockRemovedViaStockAdjust->createdAt(),
        ]);

        foreach ($stockRemovedViaStockAdjust->invoices as $invoice) {
            $materialInvoiceItem = MaterialInvoiceItem::find($invoice["invoice"]["id"]);

            $summery = InventorySummary::query()
                ->where('material_inventory_id', '=', $materialInventory->id)
                ->where('material_invoice_id', '=', $materialInvoiceItem->id)
                ->get()
                ->first();

            $summery->out = $summery->out + $invoice["usage"];
            $totalValueReduced = $invoice["usage"] * $summery->unit_price;
            $summery->total_price = $summery->total_price - abs($totalValueReduced);
            $summery->save();
        }
    }

    private function getMaterialFromInventory(string $aggregateRootId)
    {
        return MaterialInventory::query()->where('aggregate_id', $aggregateRootId)->first();
    }

    private function lastInventoryLog(string $aggregateRootId): ?InventoryLog
    {
        return InventoryLog::query()
            ->where('material_inventories_aggregate_id', $aggregateRootId)
            ->latest()
            ->limit(1)
            ->first();
    }

    public function onStartingEventReplay()
    {
        MaterialInventory::truncate();
        InventoryLog::truncate();
    }
}

<?php


namespace App\Domains\Stock\Actions;


use App\Domains\Inventory\AggregateRoots\InventoryAggregateRoot;
use App\Domains\Stock\Dtos\StockOutData;
use App\Domains\Stock\Models\StockOut;
use App\Domains\Stock\Models\StockOutItem;
use App\Models\MaterialInventory;
use App\Models\MaterialVariation;
use App\Models\StockOutItemsInvoice;

class CreateStockOutAction
{
    public function execute(StockOutData $stockOutData): StockOut
    {
        $stockOut = StockOut::create(
            [
                'order_id' => $stockOutData->orderId,
                'factory_id' => $stockOutData->factory->id,
                'customer_id' => $stockOutData->customer->id,
                'created_by_id' => $stockOutData->createdBy->id,
            ]
        );

        $this->createStockOutItem($stockOutData->items, $stockOut->id, $stockOutData->factory->id, $stockOutData->orderId);

        return $stockOut;
    }

    private function createStockOutItem(array $items, int $stockOutId, int $factoryId, string $orderId)
    {
        // refactor this
        foreach ($items as $item) {
            $totalUsage = 0;
            foreach ($item->invoices as $invoice) {
                $totalUsage = $totalUsage + $invoice->usage;
            }

            $stockOutItem = StockOutItem::create([
                'stock_out_id' => $stockOutId,
                'supplier_id' => $item->supplier->id,
                'style_id' => $item->style->id,
                'style_panel_id' => $item->stylePanel->id,
                'material_id' => $item->material->id,
                'colour_id' => $item->colour->id,
                'pieces' => $item->pieces,
                'usage' => $totalUsage,
            ]);

            foreach ($item->invoices as $invoice) {
                $this->saveItemInvoiceDetails($stockOutItem->id, $invoice->id, $invoice->usage);
            }

            $materialVariation = $this->findMaterialVariation($item);
            $materialInventory = MaterialInventory::query()
                ->where('material_variation_id', $materialVariation->id)
                ->where('factory_id', $factoryId)
                ->where('supplier_id', $item->supplier->id)
                ->first();

            $aggregateRoot = InventoryAggregateRoot::retrieve($materialInventory->aggregate_id);
            $aggregateRoot->removeStock(
                $item->material->unit,
                $totalUsage,
                $item->stylePanel->id,
                $orderId,
                $item->invoices, // the format of the invoice should be different
                auth()->user()->id
            );
            $aggregateRoot->persist();
        }
    }

    private function saveItemInvoiceDetails($itemId, $invoiceId, $usage)
    {
        StockOutItemsInvoice::create([
            'stock_out_item_id' => $itemId,
            'material_invoice_id' => $invoiceId,
            'quantity' => $usage,
            'unit' => 'm'
        ]);
    }

    private function findMaterialVariation(mixed $item): MaterialVariation
    {
        return MaterialVariation::query()
            ->where('material_id', $item->material->id)
            ->where('colour_id', $item->colour->id)
            ->get()
            ->first();
    }
}

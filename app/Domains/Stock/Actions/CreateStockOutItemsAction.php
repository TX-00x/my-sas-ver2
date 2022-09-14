<?php


namespace App\Domains\Stock\Actions;


use App\Domains\Inventory\AggregateRoots\InventoryAggregateRoot;
use App\Domains\Stock\Models\StockOut;
use App\Domains\Stock\Models\StockOutItem;
use App\Models\MaterialInventory;
use App\Models\MaterialVariation;
use App\Models\StockOutItemInvoice;
use Illuminate\Support\Str;

class CreateStockOutItemsAction
{
    public function execute(array $stockOutItemsData, StockOut $stockOut): void
    {
        foreach ($stockOutItemsData as $stockOutItemData) {

            $totalUsage = null;
            foreach ($stockOutItemsData->invoice_usages as $invoiceUsage) {
                $totalUsage = $totalUsage + $invoiceUsage->usage;
            }

            $stockOutItem = StockOutItem::create([
                'stock_out_id' => $stockOut->id,
                'supplier_id' => $stockOutItemData->supplier->id,
                'style_id' => $stockOutItemData->style->id,
                'style_panel_id' => $stockOutItemData->stylePanel->id,
                'material_id' => $stockOutItemData->material->id,
                'colour_id' => $stockOutItemData->colour->id,
                'pieces' => $stockOutItemData->pieces,
                'usage' => $totalUsage,
            ]);

            foreach ($stockOutItemsData->invoice_usages as $invoiceUsage) {
                (new CreateStockOutItemInvoiceAction())->create($invoiceUsage, $stockOutItem);
            }

            // the following code should be refactored
            $materialVariation = MaterialVariation::where('material_id', $stockOutItemData->material->id)
                ->where('colour_id', $stockOutItemData->colour->id)->first();


            if ($materialVariation) {
                $materialInventory = MaterialInventory::where('material_variation_id', $materialVariation->id)
                    ->where('factory_id', $stockOut->factory_id)
                    ->where('supplier_id', $stockOutItemData->supplier->id)
                    ->first();
                if ($materialInventory) {
                    $aggregateRoot = InventoryAggregateRoot::retrieve($materialInventory->aggregate_id);
                    $aggregateRoot->removeStock(
                        $stockOutItemData->material->unit,
                        $totalUsage,
                        $stockOutItemData->stylePanel->id,
                        $stockOut->order_id,
                        auth()->user()->id
                    );
                    $aggregateRoot->persist();
                }
            }
        }
    }
}

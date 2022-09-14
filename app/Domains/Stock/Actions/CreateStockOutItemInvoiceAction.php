<?php

namespace App\Domains\Stock\Actions;

use App\Domains\Stock\Models\StockOutItem;
use App\Models\InventorySummary;
use App\Models\MaterialInvoiceItem;
use App\Models\MaterialVariation;
use App\Models\StockOutItemInvoice;

class CreateStockOutItemInvoiceAction
{
    public function create($invoiceItem, StockOutItem $stockOutItem)
    {
        $stockOutItemInvoice = StockOutItemInvoice::create([
            'stock_out_item_id' => $stockOutItem->id,
            'material_invoice_id' => $invoiceItem->invoice->id,
            'quantity' => $invoiceItem->usage,
            'unit' => 'm'
            ]);

        $stockOutItem->invoices()->save($stockOutItemInvoice);

        $materialVariation = MaterialVariation::query()
            ->where('material_id', $stockOutItem->material_id)
            ->where('colour_id', $stockOutItem->colour_id)
            ->first();

        $unitPrice = MaterialInvoiceItem::query()
            ->where('material_invoice_id', $invoiceItem->invoice->id)
            ->where('material_variation_id', $materialVariation->id)
            ->first();

        InventorySummary::create([
            'material_variation_id' => $materialVariation->id,
            'material_invoice_id' => $stockOutItemInvoice->material_invoice_id,
            'out' => $stockOutItemInvoice->quantity,
            'unit_price' => $unitPrice,
            'total_price' => $stockOutItemInvoice->quantity * $unitPrice
        ]);
    }
}

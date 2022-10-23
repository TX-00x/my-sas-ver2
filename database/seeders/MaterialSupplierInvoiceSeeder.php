<?php

namespace Database\Seeders;

use App\Models\Factory;
use App\Models\MaterialInvoice;
use App\Models\MaterialInvoiceItem;
use Illuminate\Database\Seeder;

class MaterialSupplierInvoiceSeeder extends Seeder
{
    public function run()
    {
        $invoice1 = MaterialInvoice::factory()->create([
            'supplier_id' => SupplierSeeder::getSupplierA(),
            'purchase_order_number' => 'AB11234',
            'invoice_number' => 'ABC12211',
            'factory_id' => FactorySeeder::getSLFactory(),
        ]);

        MaterialInvoiceItem::factory()->create([
            'material_invoice_id' => $invoice1->id,
            'material_variation_id' => MaterialSeeder::getMidDryTechGreenVariation()->id,
            'quantity' => 2,
            'unit' => 'm',
            'unit_price' => 800,
            'sub_total' => 2 * 800,
            'currency' => 'nzd'
        ]);

        MaterialInvoiceItem::factory()->create([
            'material_invoice_id' => $invoice1->id,
            'material_variation_id' => MaterialSeeder::getMidDryTechWhiteVariation()->id,
            'quantity' => 2,
            'unit' => 'm',
            'unit_price' => 800,
            'sub_total' => 2 * 800,
            'currency' => 'nzd'
        ]);


    }
}

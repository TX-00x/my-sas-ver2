<?php

namespace Database\Seeders;

use App\Domains\Currency\Models\Currency;
use App\Models\Category;
use App\Models\Colour;
use App\Models\Country;
use App\Models\Customer;
use App\Models\Factory;
use App\Models\File;
use App\Models\InventoryIn;
use App\Models\ItemType;
use App\Models\MaterialInventory;
use App\Models\MaterialInvoice;
use App\Models\MaterialInvoiceItem;
use App\Models\Materials;
use App\Models\MaterialVariation;
use App\Models\Size;
use App\Models\Supplier;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UserSeeder::class,
            CountrySeeder::class,
            FactorySeeder::class,
            WarehouseSeeder::class,
        ]);

        $user = User::query()->where('email','=', UserSeeder::CS_USER_1)->get()->first();

        // Customer Creation

        // Categories Creation
        $categories = collect([
            'Basketball',
            'Netball',
            'Rugby League',
            'Rugby',
            'Tag',
            'Touch',
            'Football',
            'Hockey',
        ]);

        $categories->map(function ($category) {
            Category::factory()->create([
                'name' => $category
            ]);
        });

        // Types Creation
        $types = collect([
            'T-SHIRT/ POLO',
            'LONG SLEEVE T-SHIRT/POLO',
            'HOODIE (CVC FLEECE)',
            'POLYESTER JACKET',
            'HOODIE SLEEVELESS (CVC FLEECE)',
            'TRACK JACKET',
            'TRACK PANT',
            'SINGLET',
            'POLYESTER CARGO SHORT',
        ]);
        $types->each(function ($type) {
            ItemType::factory()->create([
                'name' => $type
            ]);
        });

        $sizes = collect([
            '16K',
            '3XS',
            '2XS',
            'XS',
            'S',
            'M',
            'L',
            'XL',
            '2XL',
            '3XL'
        ]);

        $sizes->each(function ($size) {
            Size::factory()->create([
                'name' => $size,
                'slug' => Str::slug($size)
            ]);
        });

        $this->call([
            FileSeeder::class,
            CustomerSeeder::class,
            CategorySeeder::class,
            ItemTypeSeeder::class,
            SizeSeeder::class,
            StyleSeeder::class,
        ]);


        $midDryTech = Materials::factory()->create([
            'name' => 'Mid Dritech',
            'fiber_content' => '100% Polyester',
            'type' => 'fabric',
            'unit' => 'm'
        ]);

        $lightDritech = Materials::factory()->create([
            'name' => 'Light Dritech',
            'fiber_content' => '100% Polyester',
            'type' => 'fabric',
            'unit' => 'm'
        ]);

        $drytechRugby = Materials::factory()->create([
            'name' => 'Dritech Rugby',
            'fiber_content' => '100% Polyester',
            'type' => 'fabric',
            'unit' => 'm'
        ]);

        $white = Colour::factory()->create([
            'name' => 'White',
            'type' => 'fabric',
            'is_active' => 1,
        ]);

        $green = Colour::factory()->create([
            'name' => 'Green',
            'type' => 'fabric',
            'is_active' => 1,
        ]);

        $black = Colour::factory()->create([
            'name' => 'Black',
            'type' => 'fabric',
            'is_active' => 1,
        ]);

        $red = Colour::factory()->create([
            'name' => 'Red',
            'type' => 'fabric',
            'is_active' => 1,
        ]);

        $blue = Colour::factory()->create([
            'name' => 'Blue',
            'type' => 'fabric',
            'is_active' => 1,
        ]);

        $midDryTechWhite = MaterialVariation::factory()->create([
            'material_id' => $midDryTech->id,
            'colour_id' => $white->id,
        ]);

        $midDryTechGreen = MaterialVariation::factory()->create([
            'material_id' => $midDryTech->id,
            'colour_id' => $green->id,
        ]);

        $midDryTechBlack = MaterialVariation::factory()->create([
            'material_id' => $midDryTech->id,
            'colour_id' => $black->id,
        ]);

        $midDryTechRed = MaterialVariation::factory()->create([
            'material_id' => $midDryTech->id,
            'colour_id' => $red->id,
        ]);

//        --
        $lightDritechWhite = MaterialVariation::factory()->create([
            'material_id' => $lightDritech->id,
            'colour_id' => $white->id,
        ]);

        $lightDritechGreen = MaterialVariation::factory()->create([
            'material_id' => $lightDritech->id,
            'colour_id' => $green->id,
        ]);

        $lightDritechBlack = MaterialVariation::factory()->create([
            'material_id' => $lightDritech->id,
            'colour_id' => $black->id,
        ]);

        $lightDritechRed = MaterialVariation::factory()->create([
            'material_id' => $lightDritech->id,
            'colour_id' => $red->id,
        ]);
//        --

        $supplierA = Supplier::factory()->create([
            'name' => 'Company A',
            'email' => 'email@example.com',
            'description' => '',
        ]);

        $supplierB = Supplier::factory()->create([
            'name' => 'Company B',
            'email' => 'emailb@example.com',
            'description' => '',
        ]);

        $invoice1 = MaterialInvoice::factory()->create([
            'supplier_id' => $supplierA->id,
            'purchase_order_number' => 'AB11234',
            'invoice_number' => 'ABC12211',
            'factory_id' => Factory::first(),
        ]);

        MaterialInvoiceItem::factory()->create([
            'material_invoice_id' => $invoice1->id,
            'material_variation_id' => $lightDritechBlack->id,
            'quantity' => 2,
            'unit' => 'm',
            'unit_price' => 800,
            'sub_total' => 2 * 800,
            'currency' => 'nzd'
        ]);

        MaterialInvoiceItem::factory()->create([
            'material_invoice_id' => $invoice1->id,
            'material_variation_id' => $lightDritechBlack->id,
            'quantity' => 5,
            'unit' => 'm',
            'unit_price' => 1900,
            'sub_total' => 5 * 1900,
            'currency' => 'nzd'
        ]);

        MaterialInvoiceItem::factory()->create([
            'material_invoice_id' => $invoice1->id,
            'material_variation_id' => $lightDritechGreen->id,
            'quantity' => 10,
            'unit' => 'm',
            'unit_price' => 1900,
            'sub_total' => 10 * 1900,
            'currency' => 'nzd'
        ]);

        $lightDritechBlackInventory = MaterialInventory::factory()->create([
            'material_variation_id' => $lightDritechBlack->id,
            'unit' => 'm',
            'available_quantity' => 610,
            'allocated_quantity' => 100,
            'usable_quantity' => 500,
            'factory_id' => Factory::first(),
            'supplier_id' => Supplier::find(1) ? Supplier::find(1)->id : Supplier::factory()->create()->id,
            'action_taken_by' => $user->id,
        ]);

        $lightDritechGreenInventory = MaterialInventory::factory()->create([
            'material_variation_id' => $lightDritechGreen->id,
            'unit' => 'm',
            'available_quantity' => 1000,
            'allocated_quantity' => 0,
            'usable_quantity' => 1000,
            'factory_id' => Factory::first(),
            'supplier_id' => Supplier::find(1) ? Supplier::find(1)->id : Supplier::factory()->create()->id,
            'action_taken_by' => $user->id,
        ]);

        Currency::factory()->create([
            'name' => 'NZD',
            'status' => 'Enabled',
        ]);
        Currency::factory()->create([
            'name' => 'USD',
            'status' => 'Enabled',
        ]);
        Currency::factory()->create([
            'name' => '฿',
            'status' => 'Enabled',
        ]);
        \App\Domains\PurchaseOrder\Models\MaterialPurchaseOrder::factory()->withItems(3)->count(55)->create();



    }
}

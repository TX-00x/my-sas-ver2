<?php

namespace Database\Seeders;

use App\Domains\Currency\Models\Currency;
use App\Domains\PurchaseOrder\Models\MaterialPurchaseOrder;
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

        $this->call([
            UserSeeder::class,
            CountrySeeder::class,
            FactorySeeder::class,
            WarehouseSeeder::class,
        ]);

        $user = User::query()->where('email','=', UserSeeder::CS_USER_1)->get()->first();

        $this->call([
            FileSeeder::class,
            CustomerSeeder::class,
            CategorySeeder::class,
            ItemTypeSeeder::class,
            SizeSeeder::class,
            StyleSeeder::class,
            MaterialSeeder::class,
            SupplierSeeder::class,
            QuotationSeeder::class,
        ]);

        MaterialPurchaseOrder::factory()->withItems(3)->count(55)->create();

    }
}

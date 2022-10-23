<?php

namespace Database\Seeders;

use App\Models\MaterialSupplier;
use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    const SUPPLIER_A_EMAIL = 'email@example.com';
    const SUPPLIER_B_EMAIL = 'emailb@example.com';
    public function run()
    {
        $supplierA = Supplier::factory()->create([
            'name' => 'Supplier A',
            'email' => self::SUPPLIER_A_EMAIL,
            'description' => '',
        ]);

        MaterialSupplier::create([
            'variation_id' => MaterialSeeder::getMidDryTechWhiteVariation()->id,
            'supplier_id' => $supplierA->id,
            'factory_id' => FactorySeeder::getSLFactory()->id,
        ]);

        MaterialSupplier::create([
            'variation_id' => MaterialSeeder::getMidDryTechWhiteVariation()->id,
            'supplier_id' => $supplierA->id,
            'factory_id' => FactorySeeder::getNZFactory()->id,
        ]);

        MaterialSupplier::create([
            'variation_id' => MaterialSeeder::getMidDryTechGreenVariation()->id,
            'supplier_id' => $supplierA->id,
            'factory_id' => FactorySeeder::getSLFactory()->id,
        ]);

        MaterialSupplier::create([
            'variation_id' => MaterialSeeder::getMidDryTechGreenVariation()->id,
            'supplier_id' => $supplierA->id,
            'factory_id' => FactorySeeder::getNZFactory()->id,
        ]);

        $supplierB = Supplier::factory()->create([
            'name' => 'Supplier B',
            'email' => self::SUPPLIER_B_EMAIL,
            'description' => '',
        ]);

        MaterialSupplier::create([
            'variation_id' => MaterialSeeder::getMidDryTechWhiteVariation()->id,
            'supplier_id' => $supplierB->id,
            'factory_id' => FactorySeeder::getSLFactory()->id,
        ]);

        MaterialSupplier::create([
            'variation_id' => MaterialSeeder::getMidDryTechWhiteVariation()->id,
            'supplier_id' => $supplierB->id,
            'factory_id' => FactorySeeder::getNZFactory()->id,
        ]);

        MaterialSupplier::create([
            'variation_id' => MaterialSeeder::getMidDryTechGreenVariation()->id,
            'supplier_id' => $supplierB->id,
            'factory_id' => FactorySeeder::getSLFactory()->id,
        ]);

        MaterialSupplier::create([
            'variation_id' => MaterialSeeder::getMidDryTechGreenVariation()->id,
            'supplier_id' => $supplierB->id,
            'factory_id' => FactorySeeder::getNZFactory()->id,
        ]);
    }

    public static function getSupplierA()
    {
        return Supplier::query()->where('email', '=', self::SUPPLIER_A_EMAIL)->get()->first();
    }

    public static function getSupplierB()
    {
        return Supplier::query()->where('email', '=', self::SUPPLIER_B_EMAIL)->get()->first();
    }

}

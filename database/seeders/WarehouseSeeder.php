<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Warehouse;
use Illuminate\Database\Seeder;

class WarehouseSeeder extends Seeder
{
    public function run()
    {
        Warehouse::factory()->create([
            'name' => 'Warehouse 1',
            'country_id' => Country::where('sort', 'LK')->first()->id,
        ]);
        Warehouse::factory()->create([
            'name' => 'Warehouse 2',
            'country_id' => Country::where('sort', 'NZ')->first()->id,
        ]);
    }
}

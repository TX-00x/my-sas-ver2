<?php

namespace Database\Seeders;

use App\Models\Materials;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MaterialsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $materialsCSV = fopen(base_path("database/data/materials-table-mysas.csv"), "r");

        $firstLine = true;

        while (($data = fgetcsv($materialsCSV, 1000, ",")) !== FALSE) {
            if (!$firstLine) {
                Materials::create([
                    "name" => $data['0'],
                    "fiber_content" => $data['1'],
                    "type" => $data['2'],
                    "unit" => $data['3'],
                ]);
            }
            $firstLine = false;
        }
    }
}

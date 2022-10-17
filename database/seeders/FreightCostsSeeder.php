<?php

namespace Database\Seeders;

use App\Models\FreightCharge;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FreightCostsSeeder extends Seeder
{
    public function run()
    {
        $costs = [
            [
                'region' => 'Auckland',
                'amount' => 6.5,
                'gst_included' => true,
            ],
            [
                'region' => 'North island',
                'amount' => 12.5,
                'gst_included' => true,
            ],
            [
                'region' => 'South Island',
                'amount' => 22.5,
                'gst_included' => true,
            ],
        ];

        foreach ($costs as $cost) {
            FreightCharge::create($cost);
        }
    }
}

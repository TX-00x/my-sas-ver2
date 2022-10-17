<?php

namespace Database\Seeders;

use App\Models\Embellishment;
use Illuminate\Database\Seeder;

class EmblishmentSeeder extends Seeder
{
    public function run()
    {
        $embellishments = collect([
            [
                'name' => 'Heat Transfer',
                'cost' => 6,
                'setup_cost' => 60,
            ],
            [
                'name' => 'Screen Print',
                'cost' => 6,
                'setup_cost' => 60,
            ],
            [
                'name' => 'Embroidery',
                'cost' => 6,
                'setup_cost' => 60,
            ],
            [
                'name' => 'Applique',
                'cost' => 6,
                'setup_cost' => 60,
            ],
            [
                'name' => 'Tackle Twill',
                'cost' => 6,
                'setup_cost' => 60,
            ],
            [
                'name' => 'Partial Sublimation',
                'cost' => 6,
                'setup_cost' => 50,
            ],
            [
                'name' => 'Patch',
                'cost' => 5,
                'setup_cost' => 10,
            ],
        ]);


        $embellishments->each(function ($embellishmentData) {
            $embellishment = new Embellishment();
            $embellishment->fill($embellishmentData);
            $embellishment->save();
        });
    }
}

<?php

namespace Database\Seeders;

use App\Models\Colour;
use App\Models\Materials;
use App\Models\MaterialVariation;
use Illuminate\Database\Seeder;

class MaterialSeeder extends Seeder
{
    public function run()
    {
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

        $midDryTech = Materials::factory()->create([
            'name' => 'Mid Dritech',
            'fiber_content' => '100% Polyester',
            'type' => 'fabric',
            'unit' => 'm'
        ]);

        MaterialVariation::factory()->create([
            'material_id' => $midDryTech->id,
            'colour_id' => $white->id,
        ]);

        MaterialVariation::factory()->create([
            'material_id' => $midDryTech->id,
            'colour_id' => $green->id,
        ]);

        MaterialVariation::factory()->create([
            'material_id' => $midDryTech->id,
            'colour_id' => $black->id,
        ]);

        MaterialVariation::factory()->create([
            'material_id' => $midDryTech->id,
            'colour_id' => $red->id,
        ]);

        $lightDritech = Materials::factory()->create([
            'name' => 'Light Dritech',
            'fiber_content' => '100% Polyester',
            'type' => 'fabric',
            'unit' => 'm'
        ]);

        MaterialVariation::factory()->create([
            'material_id' => $lightDritech->id,
            'colour_id' => $white->id,
        ]);

        MaterialVariation::factory()->create([
            'material_id' => $lightDritech->id,
            'colour_id' => $green->id,
        ]);

        MaterialVariation::factory()->create([
            'material_id' => $lightDritech->id,
            'colour_id' => $black->id,
        ]);

        MaterialVariation::factory()->create([
            'material_id' => $lightDritech->id,
            'colour_id' => $red->id,
        ]);

        $drytechRugby = Materials::factory()->create([
            'name' => 'Dritech Rugby',
            'fiber_content' => '100% Polyester',
            'type' => 'fabric',
            'unit' => 'm'
        ]);

        MaterialVariation::factory()->create([
            'material_id' => $drytechRugby->id,
            'colour_id' => $blue->id,
        ]);

        MaterialVariation::factory()->create([
            'material_id' => $drytechRugby->id,
            'colour_id' => $red->id,
        ]);
    }

    public static function getMidDryTechWhiteVariation()
    {
        return MaterialVariation::query()
            ->whereHas('material', function ($materialQuery) {
                $materialQuery->where('name', 'Mid Dritech');
            })->whereHas('colour', function ($colourQuery) {
                $colourQuery->where('name', 'White');
            })->get()->first();
    }

    public static function getMidDryTechGreenVariation()
    {
        return MaterialVariation::query()
            ->whereHas('material', function ($materialQuery) {
                $materialQuery->where('name', 'Mid Dritech');
            })->whereHas('colour', function ($colourQuery) {
                $colourQuery->where('name', 'Green');
            })->get()->first();
    }
}

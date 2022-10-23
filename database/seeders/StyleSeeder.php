<?php

namespace Database\Seeders;


use App\Models\Category;
use App\Models\Customer;
use App\Models\Factory;
use App\Models\ItemType;
use App\Models\Materials;
use App\Models\Size;
use App\Models\Style;
use App\Models\StylePanel;
use Illuminate\Database\Seeder;

class StyleSeeder extends Seeder
{
    const STYLE_CODE_TEE_001 = 'tee-001';
    const STYLE_CODE_TEE_002 = 'tee-002';


    public function run()
    {
        // Normal Style
        $sLFactory = Factory::first();
        $category = Category::firstOrCreate([
            'name' => 'Basketball'
        ]);
        $itemType = ItemType::first();
        $size1 =  Size::firstOrCreate(['name' => 'S','slug' => 's']);
        $size2 =  Size::firstOrCreate(['name' => 'M','slug' => 'm']);

        /** @var Style $style */
        $style = Style::factory()->create([
            'code' => self::STYLE_CODE_TEE_001,
            'name' => 'TEE 001',
            'item_type_id' => $itemType->id,
            'belongs_to' => Style::INTERNAL,
            'styles_type' => Style::GENERAL,
        ]);

        $style->factories()->syncWithoutDetaching($sLFactory->id);
        $style->categories()->syncWithoutDetaching($category->id);
        $style->sizes()->syncWithoutDetaching([$size1->id, $size2->id]);

        // Customize Style for Customer
        $sLFactory = Factory::first();
        $customer = Customer::factory()->create();
        $itemType = ItemType::firstOrCreate(['name' => 'SINGLET']);
        $category = Category::firstOrCreate([
            'name' => 'Basketball'
        ]);
        $size1 =  Size::firstOrCreate(['name' => 'S','slug' => 's']);
        $size2 =  Size::firstOrCreate(['name' => 'M','slug' => 'm']);

        /** @var Style $style */
        $style2 = Style::factory()->create([
            'code' => self::STYLE_CODE_TEE_002,
            'name' => 'Women\'s Sublimated Training Singlet (TOP 222SW FB SCP)',
            'item_type_id' => $itemType->id,
            'customer_id' => $customer->id,
            'production_time' => 120,
            'belongs_to' => Style::INTERNAL,
            'styles_type' => Style::GENERAL,
        ]);

        $stylePanel = StylePanel::factory()->create([
            'name' => 'testpanel',
            'style_id' => $style2->id,
            'default_fabric_id' => Materials::factory()->create()->id,
        ]);

        $style2->factories()->syncWithoutDetaching($sLFactory->id);
        $style2->categories()->syncWithoutDetaching($category->id);
        $style2->sizes()->syncWithoutDetaching([$size1->id, $size2->id]);
        $stylePanel->fabrics()->syncWithoutDetaching(Materials::factory()->create()->id);
    }

    public static function findTee001()
    {
        return Style::query()->where('code', '=', self::STYLE_CODE_TEE_001)->get()->first();
    }

    public static function findTee002()
    {
        return Style::query()->where('code', '=', self::STYLE_CODE_TEE_002)->get()->first();
    }
}

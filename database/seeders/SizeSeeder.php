<?php
declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Size;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SizeSeeder extends Seeder
{
    public function run()
    {
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
    }
}

<?php
declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
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
    }
}

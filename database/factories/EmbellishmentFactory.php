<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Embellishment>
 */
class EmbellishmentFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => 'Emb - '. $this->faker->title,
            'cost' => 6.99,
            'setup_cost' => 60,
        ];
    }
}

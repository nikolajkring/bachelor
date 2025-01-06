<?php

namespace Database\Factories;

use App\Models\Kitchen;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Kitchen>
 */
class KitchenFactory extends Factory
{
    protected $model = Kitchen::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'kitchen_code' => strtoupper($this->faker->unique()->uuid),
        ];
    }
}
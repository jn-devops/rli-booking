<?php

namespace RLI\Booking\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use RLI\Booking\Models\Product;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'sku' => $this->faker->uuid(),
            'name' => $this->faker->word(),
            'processing_fee' => $this->faker->numberBetween(100,1000),
        ];
    }
}
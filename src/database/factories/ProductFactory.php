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
            'sku' => $this->faker->word(),
            'name' => $this->faker->sentence(),
            'processing_fee' => $this->faker->numberBetween(100,1000),
            'meta' => [
                'category' => $this->faker->word(),
                'status' => (int) $this->faker->boolean(),
                'brand' => $this->faker->word(),
                'price' => (int) $this->faker->numberBetween(100000000,1000000000),
                'location' => $this->faker->address(),
                'floor_area' => (int) $this->faker->numberBetween(20,500),
                'lot_area' => (int) $this->faker->numberBetween(20,500),
            ],
        ];
    }
}

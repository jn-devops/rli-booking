<?php

namespace RLI\Booking\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use RLI\Booking\Models\{Inventory, Product};

class InventoryFactory extends Factory
{
    protected $model = Inventory::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::factory()->create(),
            'property_code' => $this->faker->word()
        ];
    }
}

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
        $product = Product::factory()->create();

        return [
            'sku' => $product->sku,
            'property_code' => $this->faker->word()
                . '-0' . $this->faker->numberBetween(1,4)
                . '-0' . $this->faker->numberBetween(1,20)
                . '-0' . $this->faker->numberBetween(1,40)
        ];
    }
}

<?php

namespace RLI\Booking\Factories;


use RLI\Booking\Models\{Order, Product, Buyer};
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        $product = Product::factory()->create();
        return [
            'reference' => $this->faker->uuid(),
            'sku' => $product->sku,
            'property_code' => $this->faker->word(),
            'buyer_id' => Buyer::factory()->create(),
            'user_id' => User::factory()->create(),
            'dp_percent' => $this->faker->numberBetween(0,20),
            'dp_months' => $this->faker->numberBetween(0,24),
            'callback_url' => $this->faker->url(),
        ];
    }
}

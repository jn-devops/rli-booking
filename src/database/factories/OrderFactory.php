<?php

namespace RLI\Booking\Factories;


use RLI\Booking\Models\{Order, Product, Property, Buyer, Seller, MonthsToPayDownPayment, PercentDownPayment};
use Illuminate\Database\Eloquent\Factories\Factory;


class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'reference' => $this->faker->uuid(),
            'product_id' => Product::factory()->create(),
            'property_id' => Property::factory()->create(),
            'buyer_id' => Buyer::factory()->create(),
            'seller_id' => Seller::factory()->create(),
            'months_to_pay_down_payment_id' => MonthsToPayDownPayment::factory()->create(),
            'percent_down_payment_id' => PercentDownPayment::factory()->create(),
        ];
    }
}

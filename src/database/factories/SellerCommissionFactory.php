<?php

namespace RLI\Booking\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use RLI\Booking\Models\SellerCommission;
use RLI\Booking\Models\Seller;

class SellerCommissionFactory extends Factory
{
    protected $model = SellerCommission::class;

    public function definition(): array
    {
        return [
            'code' => $this->faker->word(),
            'scheme' => [
                0 => [
                    'seller_code' => Seller::factory()->create()->code,
                    'percent' => $this->faker->numberBetween(1, 10)/100
                ],
                1 => [
                    'seller_code' => Seller::factory()->create()->code,
                    'percent' => $this->faker->numberBetween(1, 10)/100
                ],
                2 => [
                    'seller_code' => Seller::factory()->create()->code,
                    'percent' => $this->faker->numberBetween(1, 10)/100
                ],
            ],
            'remarks' => $this->faker->sentence()
        ];
    }
}

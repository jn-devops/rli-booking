<?php

namespace RLI\Booking\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use RLI\Booking\Models\SellerCommission;

class SellerCommissionFactory extends Factory
{
    protected $model = SellerCommission::class;

    public function definition(): array
    {
        return [
            'code' => $this->faker->word(),
            'rate' => [
                'percent' => $this->faker->numberBetween(1, 10)/100
            ],
            'remarks' => $this->faker->sentence()
        ];
    }
}

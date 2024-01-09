<?php

namespace RLI\Booking\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use RLI\Booking\Models\PercentDownPayment;

class PercentDownPaymentFactory extends Factory
{
    protected $model = PercentDownPayment::class;

    public function definition(): array
    {
        return [
            'code' => $this->faker->word(),
            'name' => $this->faker->name(),
            'percent' => $this->faker->numberBetween(5, 10) * 1.00,
        ];
    }
}

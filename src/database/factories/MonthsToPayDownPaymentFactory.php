<?php

namespace RLI\Booking\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use RLI\Booking\Models\MonthsToPayDownPayment;

class MonthsToPayDownPaymentFactory extends Factory
{
    protected $model = MonthsToPayDownPayment::class;

    public function definition(): array
    {
        return [
            'code' => $this->faker->word(),
            'name' => $this->faker->name(),
            'months' => $this->faker->numberBetween(6, 24),
        ];
    }
}

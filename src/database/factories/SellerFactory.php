<?php

namespace RLI\Booking\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use RLI\Booking\Models\Seller;

class SellerFactory extends Factory
{
    protected $model = Seller::class;

    public function definition(): array
    {
        return [
            'code' => $this->faker->word(),
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'mobile' => $this->faker->phoneNumber(),
        ];
    }
}

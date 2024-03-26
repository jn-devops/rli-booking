<?php

namespace RLI\Booking\Factories;

use Database\Factories\UserFactory;
use RLI\Booking\Models\Seller;

class SellerFactory extends UserFactory
{
    protected $model = Seller::class;

    public function definition(): array
    {
        return array_merge([
            'mobile' => $this->faker->phoneNumber(),
            'bank_code' => $this->faker->word(),
            'account_number' => $this->faker->word(),
            'account_name' => $this->faker->name(),
            'mfiles_id' => $this->faker->numberBetween(1,1000),
        ], parent::definition());
    }
}

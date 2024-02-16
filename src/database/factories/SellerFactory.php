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
            //place new attributes here
        ], parent::definition());
    }
}

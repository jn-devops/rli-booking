<?php

namespace RLI\Booking\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use RLI\Booking\Models\Buyer;

class BuyerFactory extends Factory
{
    protected $model = Buyer::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'address' => $this->faker->address(),
            'birthdate' => $this->faker->date(),
            'email' => $this->faker->email(),
            'mobile' => $this->faker->phoneNumber(),
            'id_type' => $this->faker->word(),
            'id_number' => $this->faker->uuid(),
            'id_image_url' => $this->faker->url(),
            'selfie_image_url' => $this->faker->url(),
            'id_mark_url' => $this->faker->url(),
        ];
    }
}

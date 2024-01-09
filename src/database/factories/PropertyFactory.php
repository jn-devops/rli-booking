<?php

namespace RLI\Booking\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use RLI\Booking\Models\Property;

class PropertyFactory extends Factory
{
    protected $model = Property::class;

    public function definition(): array
    {
        return [
            'code' => $this->faker->word(),
            'sku' => $this->faker->uuid(),
        ];
    }
}

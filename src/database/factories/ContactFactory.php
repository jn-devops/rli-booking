<?php

namespace RLI\Booking\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use RLI\Booking\Models\Contact;

class ContactFactory extends Factory
{
    protected $model = Contact::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName(),
            'middle_name' => $this->faker->lastName(),
            'last_name' => $this->faker->lastName(),
            'civil_status' => $this->faker->randomElement(['Single','Married','Annuled/Divorced','Legally Seperated','Widow/er']),
            'sex' => $this->faker->randomElement(['Male','Female']),
            'nationality' => "Filipino",
            'date_of_birth' => $this->faker->date(),
            'email' => $this->faker->email(),
            'mobile' => $this->faker->phoneNumber(),
            'addresses' => [
                [
                    'type' => 'primary',
                    'city' => $this->faker->city()
                ],
                [
                    'type' => "secondary",
                    'city'=> $this->faker->city()
                ]
            ],
            'employment' => [],
            'co_borrowers' => [],
            'order' => [
                'sku' => $this->faker->word(),
                'seller_code' => $this->faker->word(),
                'property_code' => $this->faker->word(),
            ],
        ];
    }
}

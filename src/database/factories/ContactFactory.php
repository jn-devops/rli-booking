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
            'employment' => [
                'status' => $this->faker->word(),
                'industry' => $this->faker->word(),
                'gross_income' => $this->faker->word(),
                'nationality' => $this->faker->word(),
                'type' => $this->faker->word(),
                'current_position' => $this->faker->word(),
                'name' => $this->faker->word(),
                'contact_number' => $this->faker->word(),
                'address' => $this->faker->word(),
                'block_lot' => $this->faker->word(),
                'street_line2' => $this->faker->word(),
                'city' => $this->faker->word(),
                'province' => $this->faker->word(),
                'zip_code_postal_code' => $this->faker->word(),
                'tin_number' => $this->faker->word(),
                'pagibig_number' => $this->faker->word(),
                'sss_number' => $this->faker->word(),
            ],
            'co_borrowers' => [],
            'order' => [
                'sku' => $this->faker->word(),
                'seller_code' => $this->faker->word(),
                'property_code' => $this->faker->word(),
            ],
            'idImage' => $this->faker->imageUrl(format: 'jpeg'),
            'selfieImage' => $this->faker->imageUrl(format: 'jpeg'),
            'payslipImage' => $this->faker->imageUrl(format: 'jpeg')
        ];
    }
}

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
            'civil_status' => $this->faker->randomElement(['Single','Married','Annulled/Divorced','Legally Seperated','Widow/er']),
            'sex' => $this->faker->randomElement(['Male','Female']),
            'nationality' => "Filipino",
            'date_of_birth' => $this->faker->date(),
            'email' => $this->faker->email(),
            'mobile' => $this->faker->phoneNumber(),
            'spouse' => [
                'first_name' => $this->faker->firstName(),
                'middle_name' => $this->faker->lastName(),
                'last_name' => $this->faker->lastName(),
                'civil_status' => $this->faker->randomElement(['Single','Married','Annulled/Divorced','Legally Seperated','Widow/er']),
                'sex' => $this->faker->randomElement(['Male','Female']),
                'nationality' => "Filipino",
                'date_of_birth' => $this->faker->date(),
                'email' => $this->faker->email(),
                'mobile' => $this->faker->phoneNumber(),
            ],
            'addresses' => [
                [
                    'type' => 'primary',
                    'ownership' => $this->faker->word(),
                    'address1' => $this->faker->address(),
                    'locality' => $this->faker->city(),
                    'postal_code' => $this->faker->postcode(),
                    'country' => 'PH'
                ],
                [
                    'type' => "secondary",
                    'ownership' => $this->faker->word(),
                    'address1' => $this->faker->address(),
                    'locality' => $this->faker->city(),
                    'postal_code' => $this->faker->postcode(),
                    'country' => 'PH'
                ]
            ],
            'employment' => [
                'employment_status' => $this->faker->word(),
                'monthly_gross_income' => $this->faker->word(),
                'current_position' => $this->faker->word(),
                'employment_type' => $this->faker->word(),
                'employer' => [
                    'name' => $this->faker->word(),
                    'industry' => $this->faker->word(),
                    'nationality' => $this->faker->word(),
                    'address' => [
                        'type' => 'work',
                        'ownership' => $this->faker->word(),
                        'address1' => $this->faker->address(),
                        'locality' => $this->faker->city(),
                        'postal_code' => $this->faker->postcode(),
                        'country' => 'PH'
                    ],
                    'contact_no' => $this->faker->word(),
                ],
                'id' => [
                    'tin' => $this->faker->word(),
                    'pag-ibig' => $this->faker->word(),
                    'sss' => $this->faker->word(),
                    'gsis' => $this->faker->word(),
                ],
            ],
            'co_borrowers' => [
                [
                    'first_name' => $this->faker->firstName(),
                    'middle_name' => $this->faker->lastName(),
                    'last_name' => $this->faker->lastName(),
                    'civil_status' => $this->faker->randomElement(['Single','Married','Annulled/Divorced','Legally Seperated','Widow/er']),
                    'sex' => $this->faker->randomElement(['Male','Female']),
                    'nationality' => "Filipino",
                    'date_of_birth' => $this->faker->date(),
                    'email' => $this->faker->email(),
                    'mobile' => $this->faker->phoneNumber(),
                ],
                [
                    'first_name' => $this->faker->firstName(),
                    'middle_name' => $this->faker->lastName(),
                    'last_name' => $this->faker->lastName(),
                    'civil_status' => $this->faker->randomElement(['Single','Married','Annulled/Divorced','Legally Seperated','Widow/er']),
                    'sex' => $this->faker->randomElement(['Male','Female']),
                    'nationality' => "Filipino",
                    'date_of_birth' => $this->faker->date(),
                    'email' => $this->faker->email(),
                    'mobile' => $this->faker->phoneNumber(),
                ]
            ],
            'order' => [
                'sku' => $this->faker->word(),
                'seller_commission_code' => $this->faker->word(),
                'property_code' => $this->faker->word(),
            ],
            'idImage' => $this->faker->imageUrl(word: 'idImage', format: 'jpeg'),
            'selfieImage' => $this->faker->imageUrl(format: 'jpeg'),
            'payslipImage' => $this->faker->imageUrl(format: 'jpeg')
        ];
    }
}

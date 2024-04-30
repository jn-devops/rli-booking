<?php

use Illuminate\Foundation\Testing\{RefreshDatabase, WithFaker};
use RLI\Booking\Actions\PersistContactAction;
use RLI\Booking\Models\Contact;
use Illuminate\Support\Arr;

uses(RefreshDatabase::class, WithFaker::class);

beforeEach(function() {
    $this->faker = $this->makeFaker('en_PH');
});

dataset('attribs', function () {
    return [
        fn() => [
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
                    "type"=>"primary",
                    "city"=> $this->faker->city()
                ],
                [
                    "type"=>"secondary",
                    "city"=> $this->faker->city()
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
            'idImage' => null,
            'selfieImage' => null,
            'payslipImage' => null
        ]
    ];
});

test('persist contact action', function (array $attribs) {
    expect(Contact::count())->toBe(0);
    \Pest\Laravel\expectsDatabaseQueryCount(3);
    $action = app(PersistContactAction::class);
    $contact = $action->run($attribs);
    expect(Contact::count())->toBe(1);
    expect($contact)->toBeInstanceOf(Contact::class);
    expect($contact->toData())->toBe($attribs);
})->with('attribs');

test('persist contact action has an end point', function (array $attribs) {
    $response = $this->postJson(route('persist-contact'), $attribs);
    $response->assertStatus(200);
    $search = Arr::only($attribs, ['first_name', 'middle_name', 'last_name']);
    $contact = app(Contact::class)->where($search)->first();
    $response->assertJson(['uid' => $contact->uid, 'status' => 1]);
})->with('attribs');

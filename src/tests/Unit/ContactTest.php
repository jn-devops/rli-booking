<?php
use Illuminate\Foundation\Testing\{RefreshDatabase, WithFaker};
use RLI\Booking\Data\{ContactData, ContactOrderData};
use RLI\Booking\Models\Contact;

uses(RefreshDatabase::class, WithFaker::class);

beforeEach(function() {
    $this->faker = $this->makeFaker('en_PH');
});

test('contact has schema attributes', function () {
    $contact = Contact::factory()->create();
    expect($contact->first_name)->toBeString();
    expect($contact->middle_name)->toBeString();
    expect($contact->last_name)->toBeString();
    expect($contact->civil_status)->toBeString();
    expect($contact->sex)->toBeString();
    expect($contact->nationality)->toBeString();
    expect($contact->date_of_birth)->toBeString();
    expect($contact->email)->toBeString();
    expect($contact->mobile)->toBeString();
    expect($contact->addresses)->toBeArray();
    expect($contact->employment)->toBeArray();
    expect($contact->co_borrowers)->toBeArray();
    expect($contact->order)->toBeArray();
});

test('contact has data', function () {
    $contact = Contact::factory()->create();
    $data = ContactData::fromModel($contact);
    expect($data->first_name)->toBe($contact->first_name);
    expect($data->middle_name)->toBe($contact->middle_name);
    expect($data->last_name)->toBe($contact->last_name);
    expect($data->civil_status)->toBe($contact->civil_status);
    expect($data->sex)->toBe($contact->sex);
    expect($data->nationality)->toBe($contact->nationality);
    expect($data->date_of_birth)->toBe($contact->date_of_birth);
    expect($data->email)->toBe($contact->email);
    expect($data->mobile)->toBe($contact->mobile);
    expect($data->addresses)->toBe($contact->addresses);
    expect($data->employment)->toBe($contact->employment);
    expect($data->co_borrowers)->toBe($contact->co_borrowers);
    expect($data->order->toArray())->toBe(ContactOrderData::from($contact->order)->toArray());
});


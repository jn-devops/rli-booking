<?php

use Illuminate\Foundation\Testing\{RefreshDatabase, WithFaker};
use RLI\Booking\Models\{Buyer, Contact};
use RLI\Booking\Data\BuyerData;

uses(RefreshDatabase::class, WithFaker::class);

beforeEach(function() {
    $this->faker = $this->makeFaker('en_PH');
});

test('buyer has schema attributes', function () {
    $buyer = Buyer::factory()->create();
    expect($buyer->name)->toBeString();
    expect($buyer->address)->toBeString();
    expect($buyer->birthdate)->toBeString();
    expect($buyer->email)->toBeString();
    expect($buyer->mobile)->toBeString();
    expect($buyer->id_type)->toBeString();
    expect($buyer->id_number)->toBeString();
    expect($buyer->id_image_url)->toBeString();
    expect($buyer->selfie_image_url)->toBeString();
    expect($buyer->id_mark_url)->toBeString();
});

test('buyer has data', function () {
    $buyer = Buyer::factory()->forContact()->create();
    $data = BuyerData::fromModel($buyer);
    expect($data->name)->toBe($buyer->name);
    expect($data->address)->toBe($buyer->address);
    expect($data->birthdate)->toBe($buyer->birthdate);
    expect($data->email)->toBe($buyer->email);
    expect($data->mobile)->toBe($buyer->mobile);
    expect($data->id_type)->toBe($buyer->id_type);
    expect($data->id_image_url)->toBe($buyer->id_image_url);
    expect($data->selfie_image_url)->toBe($buyer->selfie_image_url);
    expect($data->id_mark_url)->toBe($buyer->id_mark_url);
});

test('buyer has contact', function () {
    $buyer = Buyer::factory()->create();
    expect($buyer->contact)->toBeNull();
    $contact = Contact::factory()->create([
        'idImage' => null,
        'selfieImage' => null,
        'payslipImage' => null,
        'voluntarySurrenderFormDocument' => null,
        'usufructAgreementDocument' => null,
        'contractToSellDocument' => null,
    ]);
    $buyer->contact()->associate($contact);
    $buyer->save();
    expect($buyer->contact)->toBeInstanceOf(Contact::class);
});

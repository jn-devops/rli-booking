<?php

use Illuminate\Foundation\Testing\{RefreshDatabase, WithFaker};
use RLI\Booking\Models\Buyer;

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

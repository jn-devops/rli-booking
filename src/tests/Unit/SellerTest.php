<?php

use Illuminate\Foundation\Testing\{RefreshDatabase, WithFaker};
use RLI\Booking\Models\Seller;

uses(RefreshDatabase::class, WithFaker::class);

beforeEach(function() {
    $this->faker = $this->makeFaker('en_PH');
});

test('seller has schema attributes', function () {
    $seller = Seller::factory()->create();
    expect($seller->code)->toBeString();
    expect($seller->name)->toBeString();
    expect($seller->email)->toBeString();
    expect($seller->mobile)->toBeString();
});

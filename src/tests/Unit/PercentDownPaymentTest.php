<?php

use Illuminate\Foundation\Testing\{RefreshDatabase, WithFaker};
use RLI\Booking\Models\PercentDownPayment;

uses(RefreshDatabase::class, WithFaker::class);

beforeEach(function() {
    $this->faker = $this->makeFaker('en_PH');
});

test('percent_down_payment has schema attributes', function () {
    $percent_down_payments = PercentDownPayment::factory()->create();
    expect($percent_down_payments->code)->toBeString();
    expect($percent_down_payments->name)->toBeString();
    expect($percent_down_payments->percent)->toBeFloat();
});

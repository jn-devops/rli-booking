<?php

use Illuminate\Foundation\Testing\{RefreshDatabase, WithFaker};
use RLI\Booking\Models\MonthsToPayDownPayment;

uses(RefreshDatabase::class, WithFaker::class);

beforeEach(function() {
    $this->faker = $this->makeFaker('en_PH');
});

test('months_to_pay_down_payment has schema attributes', function () {
    $months_to_pay_down_payment = MonthsToPayDownPayment::factory()->create();
    expect($months_to_pay_down_payment->code)->toBeString();
    expect($months_to_pay_down_payment->name)->toBeString();
    expect($months_to_pay_down_payment->months)->toBeInt();
});

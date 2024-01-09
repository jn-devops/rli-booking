<?php

use RLI\Booking\Models\{Order, Product, Property, Buyer, Seller, MonthsToPayDownPayment, PercentDownPayment};
use Illuminate\Foundation\Testing\{RefreshDatabase, WithFaker};

uses(RefreshDatabase::class, WithFaker::class);

beforeEach(function() {
    $this->faker = $this->makeFaker('en_PH');
});

test('order has schema attributes', function () {
    $order = Order::factory()->create();
    expect($order->reference)->toBeUuid();
    expect($order->product)->toBeInstanceOf(Product::class);
    expect($order->property)->toBeInstanceOf(Property::class);
    expect($order->buyer)->toBeInstanceOf(Buyer::class);
    expect($order->seller)->toBeInstanceOf(Seller::class);
    expect($order->months_to_pay_down_payment)->toBeInstanceOf(MonthsToPayDownPayment::class);
    expect($order->percent_down_payment)->toBeInstanceOf(PercentDownPayment::class);
});

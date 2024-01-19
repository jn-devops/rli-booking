<?php

use Illuminate\Foundation\Testing\{RefreshDatabase, WithFaker};
use RLI\Booking\Actions\GenerateVoucherAction;
use RLI\Booking\Models\{Order, Product};
use App\Models\User;

uses(RefreshDatabase::class, WithFaker::class);

beforeEach(function() {
    $this->faker = $this->makeFaker('en_PH');
});

test('new order action', function () {
    $product = Product::factory()->create();
    $seller = User::factory()->create();
    $url = str_replace('http:', 'https:', $this->faker->url());

    $order = GenerateVoucherAction::run([
        'email' => $seller->email,
        'sku' => $product->sku,
        'callback_url' => $url,
    ]);
    expect($order)->toBeInstanceOf(Order::class);
    expect($order->reference)->toBeUuid();
    expect($order->sku)->toBe($product->sku);
});
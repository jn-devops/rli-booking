<?php

use RLI\Booking\Classes\State\{InternallyCreatedPendingUpdate, UpdatedPendingProcessing};
use RLI\Booking\Actions\{GenerateVoucherAction, UpdateOrderAction};
use Illuminate\Foundation\Testing\{RefreshDatabase, WithFaker};
use RLI\Booking\Models\{Product, Voucher};
use RLI\Booking\Seeders\UserSeeder;

uses(RefreshDatabase::class, WithFaker::class);

beforeEach(function() {
    $this->seed(UserSeeder::class);
    $this->faker = $this->makeFaker('en_PH');
});

dataset('voucher', [
    [ fn() =>  GenerateVoucherAction::run(['sku' => Product::factory()->create()->sku]) ]
]);

test('update order action requires property_code, dp_percent, dp_months', function (Voucher $voucher) {
    $order = $voucher->getOrder();
    expect($order->property_code)->toBeEmpty();
    expect($order->dp_percent)->toBeEmpty();
    expect($order->dp_months)->toBeEmpty();
    expect($order->state)->toBeInstanceOf(InternallyCreatedPendingUpdate::class);
    $attribs = [
        'property_code' => $this->faker->word,
        'dp_percent' => $this->faker->numberBetween(0,20),
        'dp_months' => $this->faker->numberBetween(0,24)
    ];
    UpdateOrderAction::run($voucher, $attribs);
    $order = $order->fresh();
    expect($order->property_code)->toBe($attribs['property_code']);
    expect($order->dp_percent)->toBe($attribs['dp_percent']);
    expect($order->dp_months)->toBe($attribs['dp_months']);
    expect($order->state)->toBeInstanceOf(UpdatedPendingProcessing::class);
})->with('voucher');

<?php

use Illuminate\Foundation\Testing\{RefreshDatabase, WithFaker};
use RLI\Booking\Classes\State\InternallyCreatedPendingUpdate;
use RLI\Booking\Models\{Order, Product, Voucher};
use RLI\Booking\Actions\GenerateVoucherAction;
use RLI\Booking\Seeders\UserSeeder;
use App\Models\User;

uses(RefreshDatabase::class, WithFaker::class);

beforeEach(function() {
    $this->seed(UserSeeder::class);
    $this->faker = $this->makeFaker('en_PH');
});

dataset('default_seller', [
    [ fn() => User::where('email', config('booking.defaults.seller.email'))->first() ]
]);

test('generate voucher action requires sku attribute with default email', function (Product $product, User $default_seller) {
    $voucher = GenerateVoucherAction::run([
        'sku' => $product->sku,
    ]);
    expect($voucher)->toBeInstanceOf(Voucher::class);
    tap($voucher->getOrder(), function ($order) use ($product, $default_seller){
        expect($order)->toBeInstanceOf(Order::class);
        expect($order->seller->is($default_seller))->toBeTrue();
        expect($order->product->is($product))->toBeTrue();
        expect($order->reference)->toBeNull();
        expect($order->state)->toBeInstanceOf(InternallyCreatedPendingUpdate::class);
    });

})->with([
    [ fn() => Product::factory()->create() ]
])->with('default_seller');

test('generate voucher action accepts seller', function (Product $product, User $seller) {
    $voucher = GenerateVoucherAction::run([
        'sku' => $product->sku,
        'email' => $seller->email,
    ]);
    expect($voucher->getOrder()->seller->is($seller))->toBeTrue();
})->with([
    [ fn() => Product::factory()->create(), fn() => User::factory()->create() ]
]);

test('generate voucher action accepts transaction_id', function (Product $product, User $default_seller) {
    $transaction_id = $this->faker->word();
    $voucher = GenerateVoucherAction::run([
        'sku' => $product->sku,
        'transaction_id' => $transaction_id,
    ]);
    tap($voucher->getOrder(), function ($order) use ($transaction_id, $default_seller) {
        expect($order->transaction_id)->toBe($transaction_id);
        expect($order->seller->is($default_seller))->toBeTrue();
    });
})->with([
    [ fn() => Product::factory()->create() ]
])->with('default_seller');

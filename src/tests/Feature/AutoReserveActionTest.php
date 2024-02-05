<?php

use Illuminate\Foundation\Testing\{RefreshDatabase, WithFaker};
use RLI\Booking\Classes\State\ExternallyPopulatedPendingUpdate;
use RLI\Booking\Models\{Order, Product, Seller, Voucher};
use RLI\Booking\Actions\AutoReserveAction;
use RLI\Booking\Seeders\UserSeeder;

uses(RefreshDatabase::class, WithFaker::class);

beforeEach(function() {
    $this->seed(UserSeeder::class);
    $this->faker = $this->makeFaker('en_PH');
});

dataset('default_seller', [
    [ fn() => Seller::where('email', config('booking.defaults.seller.email'))->first() ]
]);

test('client api action accepts reference and sku', function (Product $product, Seller $default_seller) {
    $transaction_id = $this->faker->word();
    $voucher = AutoReserveAction::run($product->sku, $transaction_id);
    expect($voucher)->toBeInstanceOf(Voucher::class);
    tap($voucher->getOrder(), function (Order $order) use ($transaction_id, $product, $default_seller) {
        expect($order->transaction_id)->toBe($transaction_id);
        expect($order->product->is($product))->toBe(true);
        expect($order->seller->is($default_seller))->toBeTrue();
        expect($order->state)->toBeInstanceOf(ExternallyPopulatedPendingUpdate::class);
    });
})->with([
    [ fn() => Product::factory()->create() ]
])->with('default_seller');

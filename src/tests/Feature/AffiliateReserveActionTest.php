<?php

use Illuminate\Foundation\Testing\{RefreshDatabase, WithFaker};
use RLI\Booking\Classes\State\ExternallyPopulatedPendingUpdate;
use RLI\Booking\Models\{Order, Product, Seller, Voucher};
use RLI\Booking\Actions\AffiliateReserveAction;

uses(RefreshDatabase::class, WithFaker::class);

beforeEach(function() {
    $this->faker = $this->makeFaker('en_PH');
});

dataset('seller', [
    [ fn() => Seller::factory()->create() ]
]);

test('affiliate reserve action accepts email and  sku', function (Product $product, Seller $seller) {
    $voucher = AffiliateReserveAction::run($seller->email, $product->sku);
    expect($voucher)->toBeInstanceOf(Voucher::class);
    tap($voucher->getOrder(), function (Order $order) use ($product, $seller) {
        expect($order->product->is($product))->toBe(true);
        expect($order->seller->is($seller))->toBeTrue();
        expect($order->state)->toBeInstanceOf(ExternallyPopulatedPendingUpdate::class);
    });
})->with([
    [ fn() => Product::factory()->create() ]
])->with('seller');

test('affiliate reserve action accepts email, sku and property_code', function (Product $product, Seller $seller) {
    $property_code = $this->faker->word();
    $voucher = AffiliateReserveAction::run($seller->email, $product->sku, $property_code);
    expect($voucher)->toBeInstanceOf(Voucher::class);
    tap($voucher->getOrder(), function (Order $order) use ($product, $seller, $property_code) {
        expect($order->product->is($product))->toBe(true);
        expect($order->seller->is($seller))->toBeTrue();
        expect($order->state)->toBeInstanceOf(ExternallyPopulatedPendingUpdate::class);
        expect($order->property_code)->toBe($property_code);
    });
})->with([
    [ fn() => Product::factory()->create() ]
])->with('seller');

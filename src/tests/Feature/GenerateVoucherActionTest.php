<?php

use RLI\Booking\Models\{Contact, Order, Product, Seller, Voucher};
use Illuminate\Foundation\Testing\{RefreshDatabase, WithFaker};
use RLI\Booking\Classes\State\InternallyCreatedPendingUpdate;
use RLI\Booking\Actions\GenerateVoucherAction;
use RLI\Booking\Seeders\UserSeeder;

uses(RefreshDatabase::class, WithFaker::class);

beforeEach(function() {
    $this->seed(UserSeeder::class);
    $this->faker = $this->makeFaker('en_PH');
});

dataset('default_seller', [
    [ fn() => Seller::where('email', config('booking.defaults.seller.email'))->first() ]
]);

test('generate voucher action requires sku attribute with default email', function (Product $product, Seller $default_seller) {
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

test('generate voucher action accepts seller', function (Product $product, Seller $seller) {
    $voucher = GenerateVoucherAction::run([
        'sku' => $product->sku,
        'email' => $seller->email,
    ]);
    expect($voucher->getOrder()->seller->is($seller))->toBeTrue();
})->with([
    [ fn() => Product::factory()->create(), fn() => Seller::factory()->create() ]
]);

test('generate voucher action accepts transaction_id', function (Product $product) {
    $transaction_id = $this->faker->word();
    $voucher = GenerateVoucherAction::run([
        'sku' => $product->sku,
        'transaction_id' => $transaction_id,
    ]);
    tap($voucher->getOrder(), function ($order) use ($transaction_id) {
        expect($order->transaction_id)->toBe($transaction_id);
    });
})->with([
    [ fn() => Product::factory()->create() ]
]);

test('generate voucher action accepts property code', function (Product $product) {
    $property_code = $this->faker->word();
    $voucher = GenerateVoucherAction::run([
        'sku' => $product->sku,
        'property_code' => $property_code,
    ]);
    tap($voucher->getOrder(), function ($order) use ($property_code) {
        expect($order->property_code)->toBe($property_code);
    });
})->with([
    [ fn() => Product::factory()->create() ]
]);

test('generate voucher action accepts contact uid', function (Product $product, Contact $contact) {
    $contact_uid = (string) $contact->uid;
    $voucher = GenerateVoucherAction::run([
        'sku' => $product->sku,
        'contact_uid' => $contact_uid,
    ]);
    tap($voucher->getContact(), function ($voucher_contact) use ($contact) {
        expect($voucher_contact->is($contact))->toBeTrue();
    });
})->with([
    [ fn() => Product::factory()->create(), fn() => Contact::factory()->create() ]
]);

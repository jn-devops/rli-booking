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

test('generate voucher action requires sku attribute, default seller exists', function (Product $product, Seller $default_seller) {
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
        expect($order->transaction_id)->toBeNull();
        expect($order->property_code)->toBeNull();
    });
    expect($voucher->getContact())->toBeNull();
})->with([
    [ fn() => Product::factory()->create() ]
])->with('default_seller');

test('generate voucher action accepts seller email', function (Product $product, Seller $seller) {
    $voucher = GenerateVoucherAction::run([
        'sku' => $product->sku,
        'email' => $seller->email,
    ]);
    expect($voucher)->toBeInstanceOf(Voucher::class);
    tap($voucher->getOrder(), function ($order) use ($product, $seller){
        expect($order)->toBeInstanceOf(Order::class);
        expect($order->seller->is($seller))->toBeTrue();
        expect($order->product->is($product))->toBeTrue();
        expect($order->reference)->toBeNull();
        expect($order->state)->toBeInstanceOf(InternallyCreatedPendingUpdate::class);
        expect($order->transaction_id)->toBeNull();
        expect($order->property_code)->toBeNull();
    });
    expect($voucher->getContact())->toBeNull();
})->with([
    [ fn() => Product::factory()->create(), fn() => Seller::factory()->create() ]
]);

test('generate voucher action accepts transaction id', function (Product $product, string $transaction_id, Seller $default_seller) {
    $voucher = GenerateVoucherAction::run([
        'sku' => $product->sku,
        'transaction_id' => $transaction_id,
    ]);
    expect($voucher)->toBeInstanceOf(Voucher::class);
    tap($voucher->getOrder(), function ($order) use ($product, $default_seller, $transaction_id){
        expect($order)->toBeInstanceOf(Order::class);
        expect($order->seller->is($default_seller))->toBeTrue();
        expect($order->product->is($product))->toBeTrue();
        expect($order->reference)->toBeNull();
        expect($order->state)->toBeInstanceOf(InternallyCreatedPendingUpdate::class);
        expect($order->transaction_id)->toBe($transaction_id);
        expect($order->property_code)->toBeNull();
    });
    expect($voucher->getContact())->toBeNull();
})->with([
    [ fn() => Product::factory()->create(), fn() => $this->faker->word() ]
])->with('default_seller');

test('generate voucher action accepts property code', function (Product $product, string $property_code, Seller $default_seller) {
    $voucher = GenerateVoucherAction::run([
        'sku' => $product->sku,
        'property_code' => $property_code,
    ]);
    expect($voucher)->toBeInstanceOf(Voucher::class);
    tap($voucher->getOrder(), function ($order) use ($product, $default_seller, $property_code){
        expect($order)->toBeInstanceOf(Order::class);
        expect($order->seller->is($default_seller))->toBeTrue();
        expect($order->product->is($product))->toBeTrue();
        expect($order->reference)->toBeNull();
        expect($order->state)->toBeInstanceOf(InternallyCreatedPendingUpdate::class);
        expect($order->transaction_id)->toBeNull();
        expect($order->property_code)->toBe($property_code);
    });
    expect($voucher->getContact())->toBeNull();
})->with([
    [ fn() => Product::factory()->create(), fn() => $this->faker->word() ]
])->with('default_seller');

test('generate voucher action accepts contact uid', function (Product $product, Contact $contact, Seller $default_seller) {
    $voucher = GenerateVoucherAction::run([
        'sku' => $product->sku,
        'contact_uid' => (string) $contact->uid,
    ]);
    expect($voucher)->toBeInstanceOf(Voucher::class);
    tap($voucher->getOrder(), function ($order) use ($product, $default_seller){
        expect($order)->toBeInstanceOf(Order::class);
        expect($order->seller->is($default_seller))->toBeTrue();
        expect($order->product->is($product))->toBeTrue();
        expect($order->reference)->toBeNull();
        expect($order->state)->toBeInstanceOf(InternallyCreatedPendingUpdate::class);
        expect($order->transaction_id)->toBeNull();
        expect($order->property_code)->toBeNull();
    });
    expect($voucher->getContact()->is($contact))->toBeTrue();
})->with([
    [ fn() => Product::factory()->create(), fn() => Contact::factory()->create() ]
])->with('default_seller');

test('generate voucher end point requires sku attribute, default seller exists', function (Product $product, Seller $default_seller) {
    $seller = Seller::factory()->create();
    $attribs = [
        'sku' => $product->sku,
    ];
    $response = $this->actingAs($seller)->post(route('generate-voucher'), $attribs);
    $response->assertStatus(302);
    $params = ($response->getSession()->get('params'));
    $voucher = Voucher::where('code', $params['voucher'])->first();
    $order = Order::find($params['order']);
    expect($voucher->getOrder()->is($order))->toBeTrue();
    expect($order->product->is($product))->toBeTrue();
    expect($order->seller->is($default_seller))->toBeTrue();
    expect($order->reference)->toBeNull();
    expect($order->state)->toBeInstanceOf(InternallyCreatedPendingUpdate::class);
    expect($order->transaction_id)->toBeNull();
    expect($order->property_code)->toBeNull();
    expect($voucher->getContact())->toBeNull();
})->with([
    [ fn() => Product::factory()->create() ]
])->with('default_seller');

test('generate voucher end point requires sku attribute, accepts seller email', function (Product $product, Seller $seller) {
    $user = Seller::factory()->create();
    $attribs = [
        'sku' => $product->sku,
        'email' => $seller->email,
    ];
    $response = $this->actingAs($user)->post(route('generate-voucher'), $attribs);
    $response->assertStatus(302);
    $params = ($response->getSession()->get('params'));
    $voucher = Voucher::where('code', $params['voucher'])->first();
    $order = Order::find($params['order']);
    expect($voucher->getOrder()->is($order))->toBeTrue();
    expect($order->product->is($product))->toBeTrue();
    expect($order->seller->is($seller))->toBeTrue();
    expect($order->reference)->toBeNull();
    expect($order->state)->toBeInstanceOf(InternallyCreatedPendingUpdate::class);
    expect($order->transaction_id)->toBeNull();
    expect($order->property_code)->toBeNull();
    expect($voucher->getContact())->toBeNull();
})->with([
    [ fn() => Product::factory()->create(), fn() => Seller::factory()->create() ]
]);

test('generate voucher end point requires sku attribute, accepts transaction id', function (Product $product, string $transaction_id, Seller $default_seller) {
    $user = Seller::factory()->create();
    $attribs = [
        'sku' => $product->sku,
        'transaction_id' => $transaction_id,
    ];
    $response = $this->actingAs($user)->post(route('generate-voucher'), $attribs);
    $response->assertStatus(302);
    $params = ($response->getSession()->get('params'));
    $voucher = Voucher::where('code', $params['voucher'])->first();
    $order = Order::find($params['order']);
    expect($voucher->getOrder()->is($order))->toBeTrue();
    expect($order->product->is($product))->toBeTrue();
    expect($order->seller->is($default_seller))->toBeTrue();
    expect($order->reference)->toBeNull();
    expect($order->state)->toBeInstanceOf(InternallyCreatedPendingUpdate::class);
    expect($order->transaction_id)->toBe($transaction_id);
    expect($order->property_code)->toBeNull();
    expect($voucher->getContact())->toBeNull();
})->with([
    [ fn() => Product::factory()->create(), fn() => $this->faker->word() ]
])->with('default_seller');

test('generate voucher end point requires sku attribute, accepts property code', function (Product $product, string $property_code, Seller $default_seller) {
    $user = Seller::factory()->create();
    $attribs = [
        'sku' => $product->sku,
        'property_code' => $property_code,
    ];
    $response = $this->actingAs($user)->post(route('generate-voucher'), $attribs);
    $response->assertStatus(302);
    $params = ($response->getSession()->get('params'));
    $voucher = Voucher::where('code', $params['voucher'])->first();
    $order = Order::find($params['order']);
    expect($voucher->getOrder()->is($order))->toBeTrue();
    expect($order->product->is($product))->toBeTrue();
    expect($order->seller->is($default_seller))->toBeTrue();
    expect($order->reference)->toBeNull();
    expect($order->state)->toBeInstanceOf(InternallyCreatedPendingUpdate::class);
    expect($order->transaction_id)->toBeNull();
    expect($order->property_code)->toBe($property_code);
    expect($voucher->getContact())->toBeNull();
})->with([
    [ fn() => Product::factory()->create(), fn() => $this->faker->word() ]
])->with('default_seller');

test('generate voucher end point requires sku attribute, accepts contact uid', function (Product $product, Contact $contact, Seller $default_seller) {
    $user = Seller::factory()->create();
    $attribs = [
        'sku' => $product->sku,
        'contact_uid' => (string) $contact->uid,
    ];
    $response = $this->actingAs($user)->post(route('generate-voucher'), $attribs);
    $response->assertStatus(302);
    $params = ($response->getSession()->get('params'));
    $voucher = Voucher::where('code', $params['voucher'])->first();
    $order = Order::find($params['order']);
    expect($voucher->getOrder()->is($order))->toBeTrue();
    expect($order->product->is($product))->toBeTrue();
    expect($order->seller->is($default_seller))->toBeTrue();
    expect($order->reference)->toBeNull();
    expect($order->state)->toBeInstanceOf(InternallyCreatedPendingUpdate::class);
    expect($order->transaction_id)->toBeNull();
    expect($order->property_code)->toBeNull();
    expect($voucher->getContact()->is($contact))->toBeTrue();
})->with([
    [ fn() => Product::factory()->create(), fn() => Contact::factory()->create() ]
])->with('default_seller');

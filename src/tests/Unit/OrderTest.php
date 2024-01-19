<?php

use RLI\Booking\Models\{Order, Product, Buyer};
use Illuminate\Foundation\Testing\{RefreshDatabase, WithFaker};
use App\Models\User;

uses(RefreshDatabase::class, WithFaker::class);

beforeEach(function() {
    $this->faker = $this->makeFaker('en_PH');
});

test('order has schema attributes', function () {
    $order = Order::factory()->create();
    expect($order->reference)->toBeUuid();
    expect($order->property_code)->toBeString();
    expect($order->product)->toBeInstanceOf(Product::class);
    expect($order->sku)->toBe($order->product->sku);
    expect($order->buyer)->toBeInstanceOf(Buyer::class);
    expect($order->seller)->toBeInstanceOf(User::class);
    expect($order->dp_percent)->toBeInt();
    expect($order->dp_months)->toBeInt();
    expect($order->callback_url)->toBeUrl();
});

test('order can associate product', function (Order $order, Product $product) {
    $sku = $product->sku;
    $reference = $order->reference;
    $order->product()->associate($product);
    $order->save();
    $ord = Order::where('reference', $reference)->first();
    expect($ord->id)->toBe($order->id);
    $prod = Product::where('sku', $sku)->first();
    expect($ord->product->id)->toBe($prod->id);
})->with([
    [ fn() => Order::factory()->create(), fn() => Product::factory()->create() ]
]);

test('order can associate user as seller', function (Order $order, User $seller) {
    $email = $seller->email;
    $reference = $order->reference;
    $order->seller()->associate($seller);
    $order->save();
    $ord = Order::where('reference', $reference)->first();
    expect($ord->id)->toBe($order->id);
    $user = User::where('email', $email)->first();
    expect($ord->seller->id)->toBe($user->id);
})->with([
    [ fn() => Order::factory()->create(), fn() => User::factory()->create() ]
]);

test('order can associate buyer', function (Order $order, Buyer $buyer) {
    $id = $buyer->id;
    $reference = $order->reference;
    $order->buyer()->associate($buyer);
    $order->save();
    $ord = Order::where('reference', $reference)->first();
    expect($ord->id)->toBe($order->id);
    $buyer = Buyer::find($id);
    expect($ord->buyer->id)->toBe($buyer->id);
})->with([
    [ fn() => Order::factory()->create(), fn() => Buyer::factory()->create() ]
]);


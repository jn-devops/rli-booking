<?php

use Illuminate\Foundation\Testing\{RefreshDatabase, WithFaker};
use RLI\Booking\Models\{Order, Product, Buyer};
use Illuminate\Database\QueryException;
use App\Models\User;

uses(RefreshDatabase::class, WithFaker::class);

beforeEach(function() {
    $this->faker = $this->makeFaker('en_PH');
});

test('order has schema attributes', function () {
    $order = Order::factory()->create();
    expect($order->property_code)->toBeString();
    expect($order->product)->toBeInstanceOf(Product::class);
    expect($order->sku)->toBe($order->product->sku);
    expect($order->buyer)->toBeInstanceOf(Buyer::class);
    expect($order->seller)->toBeInstanceOf(User::class);
    expect($order->dp_percent)->toBeInt();
    expect($order->dp_months)->toBeInt();
    expect($order->transaction_id)->toBeString();
});

test('new order has requires sku', function (User $seller) {
    Order::create([
        'user_id' => $seller->getAttribute('id'),
    ]);
})->with([[
    fn() => User::factory()->create(),
]])->throws(QueryException::class);

test('new order has requires seller', function (Product $product) {
    Order::create([
        'sku' => $product->sku,
    ]);
})->with([[
    fn() => Product::factory()->create(),
]])->throws(QueryException::class);

test('new order has empty attributes', function (Product $product, User $seller, Buyer $buyer) {
    $order = new Order;
    $order->sku = $product->sku;
    $order->seller()->associate($seller);
    $order->save();
    expect($order->property_code)->toBeNull();
    expect($order->buyer)->toBeNull();
    expect($order->transaction_id)->toBeNull();
    expect($order->callback_url)->toBeNull();
})->with([[
    fn() => Product::factory()->create(),
    fn() => User::factory()->create(),
    fn() => Buyer::factory()->create(),
]]);

test('order can be referenced', function (Order $order) {
    $transaction_id = $order->transaction_id;
    $ord = Order::where('transaction_id', $transaction_id)->first();
    expect($ord->id)->toBe($order->id);
})->with([
    [ fn() => Order::factory()->create() ]
]);

test('order can associate user as a seller', function (Order $order, User $seller) {
    $email = $seller->getAttribute('email');
    $transaction_id = $order->transaction_id;
    $order->seller()->associate($seller);
    $order->save();
    $ord = Order::where('transaction_id', $transaction_id)->first();
    $user = User::where('email', $email)->first();
    expect($ord->seller->id)->toBe($user->id);
})->with([
    [ fn() => Order::factory()->create(), fn() => User::factory()->create() ]
]);

test('order can associate product', function (Order $order, Product $product) {
    $sku = $product->sku;
    $transaction_id = $order->transaction_id;
    $order->product()->associate($product);
    $order->save();
    $ord = Order::where('transaction_id', $transaction_id)->first();
    $prod = Product::where('sku', $sku)->first();
    expect($ord->product->id)->toBe($prod->id);
})->with([
    [ fn() => Order::factory()->create(), fn() => Product::factory()->create() ]
]);

test('order can associate buyer', function (Order $order, Buyer $buyer) {
    $id = $buyer->id;
    $transaction_id = $order->transaction_id;
    $order->buyer()->associate($buyer);
    $order->save();
    $ord = Order::where('transaction_id', $transaction_id)->first();
    $buyer = Buyer::find($id);
    expect($ord->buyer->id)->toBe($buyer->id);
})->with([
    [ fn() => Order::factory()->create(), fn() => Buyer::factory()->create() ]
]);


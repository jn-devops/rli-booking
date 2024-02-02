<?php

use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\{RefreshDatabase, WithFaker};
use RLI\Booking\Classes\State\{Abandoned,
    ConfirmedPendingInvoice,
    InternallyCreatedPendingUpdate,
    InvoicedPendingPayment,
    PaidPendingFulfillment,
    ProcessedPendingConfirmation,
    UpdatedPendingProcessing};
use RLI\Booking\Data\OrderData;
use RLI\Booking\Models\{Buyer, Order, Product};

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

test('order has default CreatedPendingUpdate state', function (Order $order) {
    expect($order->state)->toBeInstanceOf(InternallyCreatedPendingUpdate::class);
})->with([
    [ fn() => Order::factory()->create() ]
]);

test('order has state transitions', function (Order $order) {
    $order->state->transitionTo(UpdatedPendingProcessing::class);
    expect($order->state)->toBeInstanceOf(UpdatedPendingProcessing::class);
    $order->state->transitionTo(ProcessedPendingConfirmation::class);
    expect($order->state)->toBeInstanceOf(ProcessedPendingConfirmation::class);
    $order->state->transitionTo(ConfirmedPendingInvoice::class);
    expect($order->state)->toBeInstanceOf(ConfirmedPendingInvoice::class);
    $order->state->transitionTo(InvoicedPendingPayment::class);
    expect($order->state)->toBeInstanceOf(InvoicedPendingPayment::class);
    $order->state->transitionTo(PaidPendingFulfillment::class);
    expect($order->state)->toBeInstanceOf(PaidPendingFulfillment::class);
})->with([
    [ fn() => Order::factory()->create() ]
]);

test('order can be abandoned', function (Order $order) {
    $order->state->transitionTo(UpdatedPendingProcessing::class);
    $order->state->transitionTo(ProcessedPendingConfirmation::class);
    $order->state->transitionTo(ConfirmedPendingInvoice::class);
    $order->state->transitionTo(Abandoned::class);
    expect($order->state)->toBeInstanceOf(Abandoned::class);
})->with([
    [ fn() => Order::factory()->create() ]
]);

test('order has data', function (Order $order) {
    $order_data = OrderData::fromModel($order);
    expect($order_data->property_code)->toBe($order->property_code);
    expect($order_data->dp_percent)->toBe($order->dp_percent);
    expect($order_data->dp_months)->toBe($order->dp_months);
    expect($order_data->product->sku)->toBe($order->product->sku);
    expect($order_data->product->sku)->toBe($order->product->sku);
    expect($order_data->product->name)->toBe($order->product->name);
    expect($order_data->product->processing_fee)->toBe($order->product->processing_fee);
    expect($order_data->seller->email)->toBe($order->seller->getAttribute('email'));
    expect($order_data->seller->name)->toBe($order->seller->getAttribute('name'));
    expect($order_data->buyer->name)->toBe($order->buyer->name);
    expect($order_data->buyer->address)->toBe($order->buyer->address);
    expect($order_data->buyer->birthdate)->toBe($order->buyer->birthdate);
    expect($order_data->buyer->mobile)->toBe($order->buyer->mobile);
    expect($order_data->buyer->id_type)->toBe($order->buyer->id_type);
    expect($order_data->buyer->id_number)->toBe($order->buyer->id_number);
    expect($order_data->buyer->id_image_url)->toBe($order->buyer->id_image_url);
    expect($order_data->buyer->selfie_image_url)->toBe($order->buyer->selfie_image_url);
    expect($order_data->buyer->id_mark_url)->toBe($order->buyer->id_mark_url);
})->with([
    [ fn() => Order::factory()->create() ]
]);


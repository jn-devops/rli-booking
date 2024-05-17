<?php

use RLI\Booking\Classes\State\{Abandoned, InternallyCreatedPendingUpdate, UpdatedPendingProcessing};

use RLI\Booking\Classes\State\{ProcessedPendingConfirmation, ConfirmedPendingInvoice};
use RLI\Booking\Classes\State\{InvoicedPendingPayment, PaidPendingFulfillment};
use Illuminate\Foundation\Testing\{RefreshDatabase, WithFaker};
use RLI\Booking\Models\{Buyer, Inventory, Order, Product, Seller};
use RLI\Booking\Data\FinancialSchemeData;
use Illuminate\Database\QueryException;
use RLI\Booking\Data\OrderData;
use Carbon\Carbon;

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
    expect($order->seller)->toBeInstanceOf(Seller::class);
    expect($order->dp_percent)->toBeInt();
    expect($order->dp_months)->toBeInt();
    expect($order->transaction_id)->toBeString();
});

test('new order has requires sku', function (Seller $seller) {
    Order::create([
        'user_id' => $seller->getAttribute('id'),
    ]);
})->with([[
    fn() => Seller::factory()->create(),
]])->throws(QueryException::class);

test('new order has requires seller', function (Product $product) {
    app(Order::class)->create([
        'sku' => $product->sku,
    ]);
})->with([[
    fn() => Product::factory()->create(),
]])->throws(QueryException::class);

test('new order has empty attributes', function (Product $product, Seller $seller) {
    $order = tap(new Order, function ($order) use ($product, $seller) {
        $order->product()->associate($product);
        $order->seller()->associate($seller);
        $order->save();
    });
    expect($order->property_code)->toBeNull();
    expect($order->buyer)->toBeNull();
    expect($order->transaction_id)->toBeNull();
})->with([[
    fn() => Product::factory()->create(),
    fn() => Seller::factory()->create()
]]);

test('order can be referenced', function (Order $order) {
    $transaction_id = $order->transaction_id;
    $ord = Order::where('transaction_id', $transaction_id)->first();
    expect($ord->id)->toBe($order->id);
})->with([
    [ fn() => Order::factory()->create() ]
]);

test('order can associate user as a seller', function (Order $order, Seller $seller) {
    $email = $seller->getAttribute('email');
    $transaction_id = $order->transaction_id;
    $order->seller()->associate($seller);
    $order->save();
    $ord = Order::where('transaction_id', $transaction_id)->first();
    $user = Seller::where('email', $email)->first();
    expect($ord->seller->id)->toBe($user->id);
})->with([
    [ fn() => Order::factory()->create(), fn() => Seller::factory()->create() ]
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

test('order has data even when transaction_id is null', function (Order $order) {
    $order_data = OrderData::fromModel($order);
    expect($order_data->property_code)->toBe($order->property_code);
    expect($order_data->dp_percent)->toBe($order->dp_percent);
    expect($order_data->dp_months)->toBe($order->dp_months);
    expect($order_data->transaction_id)->toBe($order->transaction_id);
    expect($order_data->product->sku)->toBe($order->product->sku);
    expect($order_data->product->sku)->toBe($order->product->sku);
    expect($order_data->product->name)->toBe($order->product->name);
    expect($order_data->product->processing_fee)->toBe($order->product->processing_fee);
    expect($order_data->seller->email)->toBe($order->seller->getAttribute('email'));
    expect($order_data->seller->name)->toBe($order->seller->getAttribute('name'));
    expect($order_data->buyer->name)->toBe($order->buyer->name);
    expect($order_data->buyer->address)->toBe($order->buyer->address);
    expect($order_data->buyer->birthdate)->toBe($order->buyer->birthdate);
    expect($order_data->buyer->email)->toBe($order->buyer->email);
    expect($order_data->buyer->mobile)->toBe($order->buyer->mobile);
    expect($order_data->buyer->id_type)->toBe($order->buyer->id_type);
    expect($order_data->buyer->id_number)->toBe($order->buyer->id_number);
    expect($order_data->buyer->id_image_url)->toBe($order->buyer->id_image_url);
    expect($order_data->buyer->selfie_image_url)->toBe($order->buyer->selfie_image_url);
    expect($order_data->buyer->id_mark_url)->toBe($order->buyer->id_mark_url);
    expect($order_data->code_url)->toBe($order->code_url);
    expect($order_data->code_img_url)->toBe($order->code_img_url);
    expect($order_data->expiration_date)->toBe($order->expiration_date);
    expect($order_data->payment_id)->toBe($order->payment_id);
})->with([
    [ fn() => Order::factory()->create([ 'transaction_id' => null ]) ]
]);

test('order has data schemaless payment attribute', function (Order $order) {
    expect($order->code_url)->toBeEmpty();
    expect($order->code_img_url)->toBeEmpty();
    expect($order->expiration_date)->toBeEmpty();
    $code_url = $this->faker->url();
    $code_img_url = $this->faker->url();
    $date = Carbon::now();
    $date->addDays(config('rli-payment.expires_in'));
    $expiration_date = $date->format('YmdHis');
    $order->code_url = $code_url;
    $payment_id = $this->faker->word();
    expect($order->meta->get('payment.code_url'))->toBe($code_url);
    $order->code_img_url = $code_img_url;
    expect($order->meta->get('payment.code_img_url'))->toBe($code_img_url);
    $order->expiration_date = $expiration_date;
    expect($order->meta->get('payment.expiration_date'))->toBe($expiration_date);
    $order->payment_id = $payment_id;
    expect($order->meta->get('receipt.payment_id'))->toBe($payment_id);
})->with([
    [ fn() => Order::factory()->create([ 'transaction_id' => null ]) ]
]);

test('order has seller commission', function (Order $order) {
    expect($order->sellerCommission)->toBeNull();
    $seller_commission = \RLI\Booking\Models\SellerCommission::factory()->create();
    $order->sellerCommission()->associate($seller_commission);
    $order->save();
    expect($order->sellerCommission)->toBe($seller_commission);
})->with([
    [ fn() => Order::factory()->create([ 'transaction_id' => null ]) ]
]);

test('order has inventory', function (Order $order) {
    expect($order->inventory)->toBeNull();
    expect($order->property_code)->toBeNull();
    $inventory = Inventory::factory()->create();
    $order->inventory()->associate($inventory);
    $order->save();
    expect($order->inventory)->toBe($inventory);
    expect($order->property_code)->toBe($inventory->property_code);
})->with([
    [ fn() => Order::factory()->create([ 'transaction_id' => null, 'property_code' => null]) ]
]);

test('order has financial scheme', function (Order $order) {
    expect($order->financialScheme)->toBeNull();
    $order->dp_percent = 10;
    $order->dp_months = 12;
    expect($order->financialScheme)->toBeInstanceOf(FinancialSchemeData::class);
    $order->save();
    $order = Order::find($order->id);
    expect($order->financialScheme->toArray())->toBe(FinancialSchemeData::from(array_filter((['dp_percent' => 10, 'dp_months' => 12])))->toArray());
    $financialScheme = FinancialSchemeData::from(array_filter((['dp_percent' => 8, 'dp_months' => 8])));
    $order->financialScheme = $financialScheme;
    $order->save();
    $order = Order::find($order->id);
    expect($order->financialScheme->toArray())->toBe($financialScheme->toArray());
})->with([
    [ fn() => Order::factory()->create([ 'dp_percent' => null, 'dp_months' => null]) ]
]);

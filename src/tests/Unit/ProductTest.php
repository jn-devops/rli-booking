<?php

use Illuminate\Foundation\Testing\{RefreshDatabase, WithFaker};
use RLI\Booking\Data\ProductData;
use RLI\Booking\Models\Product;

uses(RefreshDatabase::class, WithFaker::class);

beforeEach(function() {
    $this->faker = $this->makeFaker('en_PH');
});

test('product has schema and schemaless attributes', function () {
    $product = Product::factory()->create();
    expect($product->sku)->toBeString();
    expect($product->name)->toBeString();
    expect($product->description)->toBeEmpty();
    expect($product->processing_fee)->toBeInt();
    expect($product->category)->toBeString();
    expect($product->status)->toBeBool();
    expect($product->unit_type)->toBeString();
    expect($product->brand)->toBeString();
    expect($product->price)->toBeInt();
    expect($product->location)->toBeString();
    expect($product->floor_area)->toBeInt();
    expect($product->floor_area)->toBeInt();
});

test('product can be referenced', function (Product $product) {
    $reference = $product->sku;
    $prod = app(Product::class)->where('sku', $reference)->first();
    expect($prod->id)->toBe($product->id);
})->with([
    [ fn() => Product::factory()->create() ]
]);

test('product has data', function () {
    $product = Product::factory()->create();
    $data = ProductData::fromModel($product);
    expect($data->sku)->toBe($product->sku);
    expect($data->name)->toBe($product->name);
    expect($data->processing_fee)->toBe($product->processing_fee);
});

<?php

use Illuminate\Foundation\Testing\{RefreshDatabase, WithFaker};
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
    $product->description = $description = $this->faker->name();
    $product->save();
    $prod = app(Product::class)->first();
    expect($prod->description)->toBe($description);
});

<?php

use Illuminate\Foundation\Testing\{RefreshDatabase, WithFaker};
use RLI\Booking\Models\{Inventory, Product};
use Spatie\LaravelData\DataCollection;
use RLI\Booking\Data\InventoryData;
use RLI\Booking\Data\ProductData;

uses(RefreshDatabase::class, WithFaker::class);

beforeEach(function() {
    $this->faker = $this->makeFaker('en_PH');
});

test('product has schema and schemaless attributes', function () {
    $product = Product::factory()->create();
    expect($product->sku)->toBeString();
    expect($product->type)->toBeString();
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

test('product has inventories', function (Product $product) {
    $inventory = new Inventory(['property_code' => $this->faker->word()]);
    $product->inventories()->save($inventory);
    $product->inventories()->saveMany([
        new Inventory(['property_code' => $this->faker->word() . '-01-02-03']),
        new Inventory(['property_code' => $this->faker->word() . '-02-03-04']),
        new Inventory(['property_code' => $this->faker->word() . '-03-04-05']),
        new Inventory(['property_code' => $this->faker->word() . '-04-05-06'])
    ]);
    expect($product->inventories)->toHaveCount(5);
})->with([
    [ fn() => Product::factory()->create() ]
]);

test('product has data', function () {
    $product = Product::factory()->has(Inventory::factory()->count(3))->create();
    $data = ProductData::fromModel($product);
    expect($data->sku)->toBe($product->sku);
    expect($data->name)->toBe($product->name);
    expect($data->processing_fee)->toBe($product->processing_fee);
    expect($data->category)->toBe($product->category);
    expect($data->status)->toBe($product->status);
    expect($data->unit_type)->toBe($product->unit_type);
    expect($data->brand)->toBe($product->brand);
    expect($data->price)->toBe($product->price);
    expect($data->location)->toBe($product->location);
    expect($data->floor_area)->toBe($product->floor_area);
    expect($data->lot_area)->toBe($product->lot_area);
    expect($data->inventories)->toBeInstanceOf(DataCollection::class);
    expect($data->inventories)->toHaveCount(3);
    expect($data->inventories->first())->toBeInstanceOf(InventoryData::class);
});

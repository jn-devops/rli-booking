<?php
use Illuminate\Foundation\Testing\{RefreshDatabase, WithFaker};
use RLI\Booking\Data\InventoryData;
use RLI\Booking\Models\Inventory;
use Illuminate\Support\Arr;

uses(RefreshDatabase::class, WithFaker::class);

beforeEach(function() {
    $this->faker = $this->makeFaker('en_PH');
});

test('inventory has schema attributes', function () {
    $contact = Inventory::factory()->create();
    expect($contact->property_code)->toBeString();
});

test('inventory has data', function () {
    $inventory = Inventory::factory()->create();
    $data = InventoryData::fromModel($inventory);
    expect($data->property_code)->toBe($inventory->property_code);
});

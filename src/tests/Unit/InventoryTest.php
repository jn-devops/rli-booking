<?php
use Illuminate\Foundation\Testing\{RefreshDatabase, WithFaker};
use RLI\Booking\Data\InventoryData;
use RLI\Booking\Models\Inventory;
use Illuminate\Support\Carbon;

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

test('inventory has meta', function () {
    $inventory = Inventory::factory()->create();
    $inventory->meta->project_code = $this->faker->word();
    $inventory->save();
    expect($inventory->meta->project_code)->toBe($inventory->meta['project_code']);
    $inventory->meta = $pbl = ['phase' => 0, 'block' => 10, 'lot' => 11];
    expect($inventory->meta->all())->toBe($pbl);
    $inventory->meta->set('unit_type', 'townhouse');
    expect($inventory->meta->all())->toBe(array_merge($pbl, ['unit_type' => 'townhouse']));
    expect($inventory->meta->get('unit_type'), 'townhouse');
    $inventory->save();
    Inventory::factory()->create();
    expect(Inventory::count())->toBe(2);
    $collection = app(Inventory::class)->withMeta(['unit_type' => 'townhouse'])->get();
    expect($collection->first()->is($inventory))->toBeTrue();
});

test('inventory can be reserved', function () {
    $inventory = Inventory::factory()->create();
    expect($inventory->reserved)->toBeFalse();
    expect($inventory->reserved_at)->toBeNull();
    $inventory->reserved = true;
    expect($inventory->reserved)->toBeTrue();
    expect($inventory->reserved_at)->toBeInstanceOf(Carbon::class);
    $inventory->reserved = false;
    expect($inventory->reserved)->toBeFalse();
    expect($inventory->reserved_at)->toBeNull();
});

test('inventory can be sold', function () {
    $inventory = Inventory::factory()->create();
    expect($inventory->sold)->toBeFalse();
    expect($inventory->sold_at)->toBeNull();
    $inventory->sold = true;
    expect($inventory->sold)->toBeTrue();
    expect($inventory->sold_at)->toBeInstanceOf(Carbon::class);
    $inventory->sold = false;
    expect($inventory->sold)->toBeFalse();
    expect($inventory->sold_at)->toBeNull();
});

test('inventory has mappings', function () {
    $inventory = Inventory::factory()->create();
    expect($inventory->mappings)->toBeNull();
    $inventory->mappings = $array = ['x' => 'y'];
    expect($inventory->mappings)->toBe($array);
});


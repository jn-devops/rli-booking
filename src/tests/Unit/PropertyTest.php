<?php

use Illuminate\Foundation\Testing\{RefreshDatabase, WithFaker};
use RLI\Booking\Models\Property;

uses(RefreshDatabase::class, WithFaker::class);

beforeEach(function() {
    $this->faker = $this->makeFaker('en_PH');
});

test('property has schema and schemaless attributes', function () {
    $property = Property::factory()->create();
    expect($property->code)->toBeString();
    expect($property->sku)->toBeString();
    expect($property->floorArea)->toBeEmpty();
    $property->floorArea = $floorArea = $this->faker->numberBetween(100, 1000);
    $property->save();
    $prop = app(Property::class)->first();
    expect($prop->floorArea)->toBe($floorArea);
});

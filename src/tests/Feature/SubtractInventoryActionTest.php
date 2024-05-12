<?php

use Illuminate\Foundation\Testing\{RefreshDatabase, WithFaker};
use RLI\Booking\Actions\SubtractInventoryAction;
use RLI\Booking\Events\InventorySubtracted;
use Illuminate\Support\Facades\Event;
use RLI\Booking\Models\Inventory;

uses(RefreshDatabase::class, WithFaker::class);

test('subtract inventory action works', function () {
    Event::fake(InventorySubtracted::class);
    $inventory = Inventory::factory()->create();
    expect($inventory->trashed())->toBeFalse();
    app(SubtractInventoryAction::class)->run($inventory);
    expect($inventory->fresh()->trashed())->toBeTrue();
    Event::assertDispatched(InventorySubtracted::class);
});

test('subtract inventory action has endpoints', function () {
    $inventory = Inventory::factory()->create();
    expect($inventory->trashed())->toBeFalse();
    $response = $this->post(route('subtract-inventory', $inventory->id));
    expect($response->status())->toBe(302);
    expect($inventory->fresh()->trashed())->toBeTrue();
});

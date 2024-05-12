<?php

namespace RLI\Booking\Actions;

use RLI\Booking\Events\InventorySubtracted;
use Lorisleiva\Actions\Concerns\AsAction;
use RLI\Booking\Models\Inventory;

class SubtractInventoryAction
{
    use AsAction;

    public function handle(Inventory $inventory): Inventory
    {
        $inventory->delete();
        InventorySubtracted::dispatch($inventory);

        return $inventory;
    }

    public function asController(Inventory $inventory): \Illuminate\Http\RedirectResponse
    {
        $this->handle($inventory);

        return back()->with('event', [
            'name' => 'inventory.subtracted',
            'data' => $inventory->toData(),
        ]);
    }
}

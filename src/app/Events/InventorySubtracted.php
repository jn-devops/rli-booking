<?php

namespace RLI\Booking\Events;

use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\Channel;
use RLI\Booking\Models\Inventory;

class InventorySubtracted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Inventory $inventory;


    public function __construct(Inventory $inventory)
    {
        $this->inventory = $inventory;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('inventory.' . $this->inventory->id),
        ];
    }

    public function broadcastAs(): string
    {
        return 'inventory.subtracted';
    }

    public function broadcastWith(): array
    {
        return [
            'inventory' => $this->inventory->id
        ];
    }
}

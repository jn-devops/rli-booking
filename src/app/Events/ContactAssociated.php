<?php

namespace RLI\Booking\Events;

use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\Channel;
use RLI\Booking\Models\Buyer;

class ContactAssociated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Buyer $buyer;


    public function __construct(Buyer $buyer)
    {
        $this->buyer = $buyer;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('contact.' . $this->buyer->contact->uid),
        ];
    }

    public function broadcastAs(): string
    {
        return 'contact.associated';
    }

    public function broadcastWith(): array
    {
        return [
            'buyerId' => $this->buyer->id,
            'contactUid' => $this->buyer->contact->uid
        ];
    }
}

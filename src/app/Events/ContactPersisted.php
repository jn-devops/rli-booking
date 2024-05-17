<?php

namespace RLI\Booking\Events;

use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\Channel;
use RLI\Booking\Models\Contact;

class ContactPersisted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Contact $contact;


    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('contact.' . $this->contact->uid),
        ];
    }

    public function broadcastAs(): string
    {
        return 'contact.persisted';
    }

    public function broadcastWith(): array
    {
        return [
            'contactUid' => $this->contact->uid
        ];
    }
}

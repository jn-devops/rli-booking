<?php

namespace RLI\Booking\Events;

use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\PrivateChannel;
use RLI\Booking\Models\{Buyer, Voucher};
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\Channel;

class BuyerInvoiced implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Buyer $buyer;

    public Voucher $voucher;

    public function __construct(Voucher $voucher)
    {
        $this->voucher = $voucher;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('voucher.' . $this->voucher->code),
        ];
    }

    public function broadcastAs(): string
    {
        return 'buyer.invoiced';
    }

    public function broadcastWith(): array
    {
        return [
            'buyerId' => $this->voucher->getOrder()->buyer->id,
        ];
    }
}

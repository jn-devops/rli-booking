<?php

namespace RLI\Booking\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use RLI\Booking\Models\Voucher;

class PaymentDetailsAcquired
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public Voucher $voucher){}
}

<?php

namespace RLI\Booking\Classes\State;

class PaidPendingFulfillment extends OrderState
{
    public function color(): string
    {
        return 'green';
    }
}

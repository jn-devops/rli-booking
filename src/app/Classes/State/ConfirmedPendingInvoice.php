<?php

namespace RLI\Booking\Classes\State;

class ConfirmedPendingInvoice extends OrderState
{
    public function color(): string
    {
        return 'yellow-green';
    }
}

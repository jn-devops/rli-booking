<?php

namespace RLI\Booking\Classes\State;

class InvoicedPendingPayment extends OrderState
{
    public function color(): string
    {
        return 'green';
    }
}

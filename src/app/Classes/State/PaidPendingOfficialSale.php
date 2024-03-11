<?php

namespace RLI\Booking\Classes\State;

class PaidPendingOfficialSale extends OrderState
{
    public function color(): string
    {
        return 'green';
    }
}

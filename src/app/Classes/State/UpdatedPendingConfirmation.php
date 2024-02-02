<?php

namespace RLI\Booking\Classes\State;

class UpdatedPendingConfirmation extends OrderState
{
    public function color(): string
    {
        return 'yellow-green';
    }
}

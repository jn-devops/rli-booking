<?php

namespace RLI\Booking\Classes\State;

class ProcessedPendingConfirmation extends OrderState
{
    public function color(): string
    {
        return 'yellow-green';
    }
}

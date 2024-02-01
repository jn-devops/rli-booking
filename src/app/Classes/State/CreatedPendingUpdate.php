<?php

namespace RLI\Booking\Classes\State;

class CreatedPendingUpdate extends OrderState
{
    public function color(): string
    {
        return 'yellow';
    }
}

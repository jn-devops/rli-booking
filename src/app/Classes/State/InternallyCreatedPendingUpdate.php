<?php

namespace RLI\Booking\Classes\State;

class InternallyCreatedPendingUpdate extends OrderState
{
    public function color(): string
    {
        return 'yellow';
    }
}

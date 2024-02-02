<?php

namespace RLI\Booking\Classes\State;

class ExternallyPopulatedPendingUpdate extends OrderState
{
    public function color(): string
    {
        return 'yellow';
    }
}

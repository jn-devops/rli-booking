<?php

namespace RLI\Booking\Classes\State;

class UpdatedPendingProcessing extends OrderState
{
    public function color(): string
    {
        return 'yellow-green';
    }
}

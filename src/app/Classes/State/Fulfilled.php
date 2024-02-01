<?php

namespace RLI\Booking\Classes\State;

class Fulfilled extends OrderState
{
    public function color(): string
    {
        return 'green';
    }
}

<?php

namespace RLI\Booking\Classes\State;

class Abandoned extends OrderState
{
    public function color(): string
    {
        return 'red';
    }
}

<?php

namespace RLI\Booking\Data;

use RLI\Booking\Interfaces\CanHydrateFromModel;
use RLI\Booking\Traits\HydrateFromModel;
use Spatie\LaravelData\Data;

class SellerData extends Data implements CanHydrateFromModel
{
    use HydrateFromModel;

    public function __construct(
        public string $email,
        public string $name,
    ) {}
}

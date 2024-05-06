<?php

namespace RLI\Booking\Data;

use RLI\Booking\Interfaces\CanHydrateFromModel;
use RLI\Booking\Traits\HydrateFromModel;
use Spatie\LaravelData\Data;

class SellerCommissionData extends Data implements CanHydrateFromModel
{
    use HydrateFromModel;

    public function __construct(
        public string $code,
        public array $rate,
        public ?string $remarks,
    ) {}
}

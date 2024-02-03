<?php

namespace RLI\Booking\Data;

use RLI\Booking\Interfaces\CanHydrateFromModel;
use RLI\Booking\Traits\HydrateFromModel;
use Spatie\LaravelData\Data;

class VoucherData extends Data implements CanHydrateFromModel
{
    use HydrateFromModel;

    public function __construct(
        public string $reference_code,
        public OrderData $order,
    ) {}
}

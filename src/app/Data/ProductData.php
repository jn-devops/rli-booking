<?php

namespace RLI\Booking\Data;

use RLI\Booking\Interfaces\CanHydrateFromModel;
use RLI\Booking\Traits\HydrateFromModel;
use Spatie\LaravelData\Data;
class ProductData extends Data implements CanHydrateFromModel
{
    use HydrateFromModel;

    public function __construct(
        public string $sku,
        public string $name,
        public int $processing_fee,
    ) {}
}

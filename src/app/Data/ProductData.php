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
        public int    $processing_fee,
        public string $category,
        public bool   $status,
        public string $unit_type,
        public string $brand,
        public int    $price,
        public string $location,
        public int    $floor_area,
        public int    $lot_area
    ) {}
}

<?php

namespace RLI\Booking\Data;

use RLI\Booking\Interfaces\CanHydrateFromModel;
use RLI\Booking\Traits\HydrateFromModel;
use Spatie\LaravelData\Data;

class OrderData extends Data implements CanHydrateFromModel
{
    use HydrateFromModel;

    public function __construct(
        public string $property_code,
        public int $dp_percent,
        public int $dp_months,
        public ProductData $product,
        public SellerData $seller,
        public BuyerData $buyer,
        public ?string $transaction_id
    ) {}
}
<?php

namespace RLI\Booking\Data;

use RLI\Booking\Models\Product;
use Spatie\LaravelData\Data;
class ProductData extends Data
{
    public function __construct(
        public string $sku,
        public string $name,
        public int $processing_fee,
    ) {}

    public static function fromModel(Product $product): self
    {
        return new self(
            sku: $product->sku,
            name: $product->name,
            processing_fee: $product->processing_fee
        );
    }
}

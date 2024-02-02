<?php

namespace RLI\Booking\Data;

use RLI\Booking\Models\Order;
use Spatie\LaravelData\Data;

class OrderData extends Data
{
    public function __construct(
        public string $property_code,
        public int $dp_percent,
        public int $dp_months,
        public ProductData $product,
        public SellerData $seller,
        public BuyerData $buyer,
        public ?string $transaction_id
    ) {}

    public static function fromModel(Order $order): self
    {
        return new self(
            property_code: $order->property_code,
            dp_percent: $order->dp_percent,
            dp_months: $order->dp_months,
            product: ProductData::fromModel($order->product),
            seller: SellerData::fromModel($order->seller),
            buyer: BuyerData::fromModel($order->buyer),
            transaction_id: $order->transaction_id
        );
    }
}

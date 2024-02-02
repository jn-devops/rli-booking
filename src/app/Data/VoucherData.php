<?php

namespace RLI\Booking\Data;

use RLI\Booking\Models\Voucher;
use Spatie\LaravelData\Data;

class VoucherData extends Data
{
    public function __construct(
        public string $reference_code,
        public OrderData $order,
    ) {}

    public static function fromModel(Voucher $voucher): self
    {
        return new self(
            reference_code: $voucher->code,
            order: OrderData::fromModel($voucher->getOrder()),
        );
    }
}

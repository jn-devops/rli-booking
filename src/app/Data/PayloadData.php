<?php

namespace RLI\Booking\Data;

use RLI\Booking\Models\Voucher;
use Spatie\LaravelData\Data;

class PayloadData extends Data
{
    public function __construct(
        public VoucherData $payload,
        public ?string $entity_type = null,
    ) {
        $this->entity_type = $this->entity_type ?: config('booking.webhook.entity_type');
    }

    public static function fromVoucher(Voucher $voucher, string $entity_type = null): self
    {
        return new self(VoucherData::fromModel($voucher), $entity_type);
    }
}

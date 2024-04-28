<?php

namespace RLI\Booking\Data;

use RLI\Booking\Interfaces\CanHydrateFromModel;
use RLI\Booking\Traits\HydrateFromModel;
use Spatie\LaravelData\Data;

class SellerData extends Data implements CanHydrateFromModel
{
    use HydrateFromModel;

    public function __construct(
        public string  $email,
        public string  $name,
        public ?string $mobile,
        public ?string $personal_email,
        public ?string $seller_code,
        public ?string $bank_code,
        public ?string $account_number,
        public ?string $account_name,
        public bool    $accredited,
        public ?int    $mfiles_id,
    ) {}
}

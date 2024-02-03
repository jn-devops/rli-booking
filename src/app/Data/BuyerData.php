<?php

namespace RLI\Booking\Data;

use RLI\Booking\Interfaces\CanHydrateFromModel;
use RLI\Booking\Traits\HydrateFromModel;
use Spatie\LaravelData\Data;

class BuyerData extends Data implements CanHydrateFromModel
{
    use HydrateFromModel;

    public function __construct(
        public string $name,
        public string $address,
        public string $birthdate,
        public string $email,
        public ?string $mobile,
        public string $id_type,
        public string $id_number,
        public ?string $id_image_url,
        public ?string $selfie_image_url,
        public ?string $id_mark_url,
    ) {}
}

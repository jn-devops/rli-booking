<?php

namespace RLI\Booking\Data;

use RLI\Booking\Models\Buyer;
use Spatie\LaravelData\Data;

class BuyerData extends Data
{
    public function __construct(
        public string $name,
        public string $address,
        public string $birthdate,
        public ?string $mobile,
        public string $id_type,
        public string $id_number,
        public ?string $id_image_url,
        public ?string $selfie_image_url,
        public ?string $id_mark_url,
    ) {}

    public static function fromModel(Buyer $buyer): self
    {
        return new self(
            name: $buyer->name,
            address: $buyer->address,
            birthdate: $buyer->birthdate,
            mobile: $buyer->mobile,
            id_type: $buyer->id_type,
            id_number: $buyer->id_number,
            id_image_url: $buyer->id_image_url,
            selfie_image_url: $buyer->selfie_image_url,
            id_mark_url: $buyer->id_mark_url
        );
    }
}

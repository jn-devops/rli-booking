<?php

namespace RLI\Booking\Data;

use Spatie\LaravelData\Data;

class AddressData extends Data
{
    public function __construct(
        public string $type,
        public string $ownership, //owned or rented
        public string $address1,
        public ?string $address2,
        public ?string $sublocality, //barangay
        public string $locality, //city or municipality
        public ?string $administrative_area, //province
        public ?string $postal_code, //zip code
        public ?string $sorting_code,
        public string $country = 'PH',
    ) {}
}

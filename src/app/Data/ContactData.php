<?php

namespace RLI\Booking\Data;

use RLI\Booking\Interfaces\CanHydrateFromModel;
use RLI\Booking\Traits\HydrateFromModel;
use Spatie\LaravelData\Data;

class ContactData extends Data implements CanHydrateFromModel
{
    use HydrateFromModel;

    public function __construct(
        public string $first_name,
        public string $middle_name,
        public string $last_name,
        public string $civil_status,
        public string $sex,
        public string $nationality,
        public string $date_of_birth,
        public string $email,
        public string $mobile,
        public ?array $addresses,
        public array $employment,
        public array $co_borrowers,
    ) {}
}

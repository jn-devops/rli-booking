<?php

namespace RLI\Booking\Data;

use Spatie\LaravelData\Data;
use App\Models\User;

class SellerData extends Data
{
    public function __construct(
        public string $email,
        public string $name,
    ) {}

    public static function fromModel(User $seller): self
    {
        return new self(
            email: $seller->getAttribute('email'),
            name: $seller->getAttribute('name')
        );
    }
}

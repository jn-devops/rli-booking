<?php

namespace RLI\Booking\Data;

use RLI\Booking\Interfaces\CanHydrateFromModel;
use RLI\Booking\Traits\HydrateFromModel;
use Spatie\LaravelData\Optional;
use RLI\Booking\Models\Buyer;
use Spatie\LaravelData\Data;

class BuyerData extends Data
{
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
        public ?ContactData $contact,
    ) {}

    public static function fromModel(Buyer $model): self
    {
        return new self (
            name: $model->name,
            address: $model->address,
            birthdate: $model->birthdate,
            email: $model->email,
            mobile: $model->mobile,
            id_type: $model->id_type,
            id_number: $model->id_number,
            id_image_url: $model->id_image_url,
            selfie_image_url: $model->selfie_image_url,
            id_mark_url: $model->id_mark_url,
            contact: $model->contact ? ContactData::fromModel($model->contact) : null
        );
    }
}

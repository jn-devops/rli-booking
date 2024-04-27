<?php

namespace RLI\Booking\Data;

use Spatie\LaravelData\{Data, Optional};
use Illuminate\Support\Carbon;

class ContactData extends Data
{
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
        public array  $employment,
        public array  $co_borrowers,
        public ContactOrderData|Optional $order,
    ) {}

    public static function fromModel(object $model): self
    {
        return new self(
            first_name: $model->first_name,
            middle_name: $model->middle_name,
            last_name: $model->last_name,
            civil_status: $model->civil_status,
            sex: $model->sex,
            nationality: $model->nationality,
            date_of_birth: $model->date_of_birth,
            email: $model->email,
            mobile: $model->mobile,
            addresses: $model->addresses,
            employment: $model->employment,
            co_borrowers: $model->co_borrowers,
            order: ContactOrderData::from($model->order)
        );
    }
}

class ContactOrderData extends Data
{
    public function __construct(
        public string $sku,
        public string $seller_code,
        public string $property_code,
    ) {}
}

<?php

namespace RLI\Booking\Data;

use Spatie\LaravelData\{Data, DataCollection, Optional};
use Illuminate\Support\Arr;
use Ramsey\Collection\Collection;
use RLI\Booking\Models\Contact;

class ContactData extends Data
{
    public function __construct(
        public PersonData $profile,
        public ?PersonData $spouse,
        /** @var AddressData[] */
        public DataCollection $addresses,
        public ContactEmploymentData|Optional $employment,
        /** @var PersonData[] */
        public DataCollection|Optional $co_borrowers,
        public ContactOrderData|Optional $order,
        public ContactMediaData|Optional $media,
    ) {}

    public static function from(...$payloads): static
    {
        $model = (object) $payloads[0];

        return new self(
            profile: new PersonData(
                first_name: $model->first_name,
                middle_name: $model->middle_name,
                last_name: $model->last_name,
                civil_status: $model->civil_status,
                sex: $model->sex,
                nationality: $model->nationality,
                date_of_birth: $model->date_of_birth,
                email: $model->email,
                mobile: $model->mobile
            ),
            spouse: $model->spouse ? PersonData::from($model->spouse) : null,
            addresses: new DataCollection(AddressData::class, $model->addresses),
            employment: ContactEmploymentData::from($model->employment),
            co_borrowers: new DataCollection(PersonData::class, $model->co_borrowers),
            order: ContactOrderData::from($model->order),
            media: new ContactMediaData(
                idImage: $model->idImage,
                selfieImage: $model->selfieImage,
                payslipImage: $model->payslipImage
            )
        );
    }

    public static function fromModel(object $model): self
    {
        return new self(
            profile: new PersonData(
                first_name: $model->first_name,
                middle_name: $model->middle_name,
                last_name: $model->last_name,
                civil_status: $model->civil_status,
                sex: $model->sex,
                nationality: $model->nationality,
                date_of_birth: $model->date_of_birth,
                email: $model->email,
                mobile: $model->mobile
            ),
            spouse: $model->spouse ? PersonData::from($model->spouse) : null,
            addresses: new DataCollection(AddressData::class, $model->addresses),
            employment: ContactEmploymentData::from($model->employment),
            co_borrowers: new DataCollection(PersonData::class, $model->co_borrowers),
            order: ContactOrderData::from($model->order),
            media: ContactMediaData::from(array_filter([
                'idImage' => optional($model->idImage)->getUrl(),
                'selfieImage' => optional($model->selfieImage)->getUrl(),
                'payslipImage' => optional($model->payslipImage)->getUrl()
            ]))
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

class ContactEmploymentData extends Data
{
    public function __construct(
        public string $employment_status,
        public string $monthly_gross_income,
        public string $current_position,
        public string $employment_type,
        public ContactEmploymentEmployerData $employer,
        public ContactEmploymentIdData|Optional $id,
    ) {}
}

class ContactEmploymentEmployerData extends Data
{
    public function __construct(
        public string $name,
        public string $industry,
        public string $nationality,
        public AddressData $address,
        public string $contact_no,
    ) {}
}

class ContactEmploymentIdData extends Data
{
    public function __construct(
        public ?string $tin,
        public ?string $pag_ibig,
        public ?string $sss,
        public ?string $gsis,
    ) {}
}

class ContactMediaData extends Data
{
    public function __construct(
        public ?string $idImage,
        public ?string $selfieImage,
        public ?string $payslipImage,
    ) {}


}

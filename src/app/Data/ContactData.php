<?php

namespace RLI\Booking\Data;

use Spatie\LaravelData\{Data, DataCollection, Optional};

class ContactData extends Data
{
    public function __construct(
        public string $uid,
        public PersonData $profile,
        public ?PersonData $spouse,
        /** @var AddressData[] */
        public DataCollection $addresses,
        public ContactEmploymentData|Optional $employment,
        /** @var PersonData[] */
        public DataCollection|Optional $co_borrowers,
        public ContactOrderData|Optional $order,
        /** @var UploadData[] */
        public DataCollection|Optional $uploads,
    ) {}

    public static function from(...$payloads): static
    {
        $attribs = (object) $payloads[0];

        return new self(
            uid: $attribs->uid,
            profile: new PersonData(
                first_name: $attribs->first_name,
                middle_name: $attribs->middle_name,
                last_name: $attribs->last_name,
                civil_status: $attribs->civil_status,
                sex: $attribs->sex,
                nationality: $attribs->nationality,
                date_of_birth: $attribs->date_of_birth,
                email: $attribs->email,
                mobile: $attribs->mobile
            ),
            spouse: $attribs->spouse ? PersonData::from($attribs->spouse) : null,
            addresses: new DataCollection(AddressData::class, $attribs->addresses),
            employment: ContactEmploymentData::from($attribs->employment),
            co_borrowers: new DataCollection(PersonData::class, $attribs->co_borrowers),
            order: ContactOrderData::from($attribs->order),
            uploads: new DataCollection(
                dataClass: UploadData::class,
                items: collect($attribs->media)
                    ->mapWithKeys(function ($item, $key) {
                        return [
                            $key => [
                                'name' => $item['name'],
                                'url' => $item['original_url']
                            ]
                        ];
                    })
                    ->toArray()
            )
        );
    }

    public static function fromModel(object $model): self
    {
        return new self(
            uid: $model->uid,
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
            uploads: new DataCollection(UploadData::class, $model->uploads)
        );
    }
}

class ContactOrderData extends Data
{
    public function __construct(
        public string $sku,
        public string $seller_commission_code,
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

class UploadData extends Data
{
    public function __construct(
        public string $name,
        public string $url
    ) {}
}

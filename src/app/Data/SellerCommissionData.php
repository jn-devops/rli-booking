<?php

namespace RLI\Booking\Data;

use Spatie\LaravelData\{Data, DataCollection, Optional};
use RLI\Booking\Interfaces\CanHydrateFromModel;
use RLI\Booking\Traits\HydrateFromModel;

class SellerCommissionData extends Data implements CanHydrateFromModel
{
    use HydrateFromModel;

    public function __construct(
        public string $code,
        public ?string $project_code,
        /** @var SellerCommissionSchemeData[] */
        public DataCollection $scheme,
        public ?string $remarks,
    ) {}

    public static function fromModel(object $model): self
    {
        return new self(
            code: $model->code,
            project_code: $model->project_code,
            scheme: new DataCollection(SellerCommissionSchemeData::class, $model->scheme),
            remarks: $model->remarks
        );
    }
}

class SellerCommissionSchemeData extends Data
{
    public function __construct(
        public string $seller_code,
        public float $percent,
        public float|Optional $amount,
    ) {}
}

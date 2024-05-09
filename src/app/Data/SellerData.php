<?php

namespace RLI\Booking\Data;

use Spatie\LaravelData\{Data, DataCollection, Optional};
use RLI\Booking\Models\Seller;

class SellerData extends Data
{
    public function __construct(
        public ?string $code,
        public string  $email,
        public string  $name,
        public ?string $mobile,
        public ?string $personal_email,
        public ?string $default_seller_commission_code,
        public ?string $bank_code,
        public ?string $account_number,
        public ?string $account_name,
        public bool    $accredited,
        public ?int    $mfiles_id,
        /** @var SellerCommissionData[] */
        public DataCollection|Optional $seller_commissions
    ) {}


    public static function fromModel(Seller $model): self
    {
        return new self (
            code: $model->code,
            email: $model->email,
            name: $model->name,
            mobile: $model->mobile,
            personal_email: $model->personal_email,
            default_seller_commission_code: $model->default_seller_commission_code,
            bank_code: $model->bank_code,
            account_number: $model->account_number,
            account_name: $model->account_name,
            accredited: $model->accredited,
            mfiles_id: $model->mfiles_id,
            seller_commissions: new DataCollection(SellerCommissionData::class, $model->sellerCommissions)
        );
    }
}

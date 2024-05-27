<?php

namespace RLI\Booking\Models;

use FrittenKeeZ\Vouchers\Models\Voucher as BaseVoucher;
use RLI\Booking\Data\{ContactData, OrderData};
use RLI\Booking\Interfaces\AttributableData;

/**
 * Class Voucher
 *
 * @property string $code
 * @property string $checkin_code
 *
 * @method   int    getKey()
 */
class Voucher extends BaseVoucher implements AttributableData
{
    static public function from(BaseVoucher $voucher): self
    {
        $model = new self;
        $model->setRawAttributes($voucher->getAttributes(), true);
        $model->exists = true;
        $model->setConnection($voucher->getConnectionName());
        $model->fireModelEvent('retrieved', false);

        return $model;
    }

    /**
     * Retrieve the model for a bound value.
     *
     * @param  mixed  $value
     * @param  string|null  $field
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveRouteBinding($value, $field = null): ?\Illuminate\Database\Eloquent\Model
    {
        return $this->where('code', $value)->firstOrFail();
    }

    /**
     * Helper function to retrieve order from voucher.
     *
     * @return Order|null
     */
    public function getOrder(): ?Order
    {
        return $this->getEntities(Order::class)->first();
    }

    /**
     * Helper function to retrieve order from voucher.
     *
     * @return Contact|null
     */
    public function getContact(): ?Contact
    {
        return $this->getEntities(Contact::class)->first();
    }

    public function toData(): array
    {
        $contact = $this->getContact();

        return array_merge(
            [ 'reference_code' => $this->code ],
            [ 'order' => OrderData::fromModel($this->getOrder()) ],
            [ 'contact' =>  $contact ? ContactData::fromModel($contact) : null ]
        );
    }
}

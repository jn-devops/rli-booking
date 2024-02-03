<?php

namespace RLI\Booking\Models;

use FrittenKeeZ\Vouchers\Models\Voucher as BaseVoucher;
use RLI\Booking\Interfaces\AttributableData;
use RLI\Booking\Data\OrderData;

/**
 * Class Voucher
 *
 * @property string $code
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
     * @return Order
     */
    public function getOrder(): Order
    {
        return $this->getEntities(Order::class)->first();
    }

    public function toData(): array
    {
        return array_merge(
            [ 'reference_code' => $this->code ],
            [ 'order' => OrderData::fromModel($this->getOrder()) ]
        );
    }
}

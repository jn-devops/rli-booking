<?php

namespace RLI\Booking\Models;

/**
 * Class Voucher
 *
 * @property string $code
 *
 * @method   int    getKey()
 */
class Voucher extends \FrittenKeeZ\Vouchers\Models\Voucher
{
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
}

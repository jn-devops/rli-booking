<?php

namespace RLI\Booking\Models;

use RLI\Booking\Traits\HasPackageFactory as HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use RLI\Booking\Traits\HasMeta;

/**
 * Class Order
 *
 * @property BelongsTo $product
 * @property BelongsTo $property
 * @property BelongsTo $buyer
 * @property BelongsTo $seller
 * @property BelongsTo $months_to_pay_down_payment
 * @property BelongsTo $percent_down_payment
 *
 * @method   int    getKey()
 */
class Order extends Model
{
    use HasFactory;
    use HasMeta;

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function buyer(): BelongsTo
    {
        return $this->belongsTo(Buyer::class);
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(Seller::class);
    }

    public function months_to_pay_down_payment(): BelongsTo
    {
        return $this->belongsTo(MonthsToPayDownPayment::class);
    }

    public function percent_down_payment(): BelongsTo
    {
        return $this->belongsTo(PercentDownPayment::class);
    }
}

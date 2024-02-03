<?php

namespace RLI\Booking\Models;

use RLI\Booking\Data\{BuyerData, ProductData, SellerData};
use RLI\Booking\Traits\HasPackageFactory as HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use RLI\Booking\Interfaces\AttributableData;
use RLI\Booking\Classes\State\OrderState;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Spatie\ModelStates\HasStates;
use RLI\Booking\Traits\HasMeta;

/**
 * Class Order
 *
 * @property integer    $id
 * @property string     $sku
 * @property string     $property_code
 * @property int        $dp_percent
 * @property int        $dp_months
 * @property Product    $product
 * @property Buyer      $buyer
 * @property Seller     $seller
 * @property string     $transaction_id
 * @property OrderState $state
 *
 * @method   int        getKey()
 */
class Order extends Model implements AttributableData
{
    use HasFactory;
    use Notifiable;
    use HasStates;
    use HasMeta;

    protected $fillable = ['property_code', 'dp_percent', 'dp_months', 'transaction_id'];

    protected $casts = [
        'state' => OrderState::class
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'sku', 'sku');
    }

    public function buyer(): BelongsTo
    {
        return $this->belongsTo(Buyer::class);
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(Seller::class, 'user_id');
    }

    public function routeNotificationForWebhook(): string
    {
        return config('booking.defaults.order.webhook');
    }

    public function toData(): array
    {
        return array_merge($this->only(array_diff($this->getFillable(), $this->getHidden())), [
            'product' => ProductData::fromModel($this->product),
            'seller' => SellerData::fromModel($this->seller),
            'buyer' => BuyerData::fromModel($this->buyer)
        ]);
    }
}

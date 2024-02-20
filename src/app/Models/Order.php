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
 * @property string     $code_url
 * @property string     $code_img_url
 * @property string     $expiration_date
 *
 * @method   int        getKey()
 */
class Order extends Model implements AttributableData
{
    use HasFactory;
    use Notifiable;
    use HasStates;
    use HasMeta;

    protected $fillable = ['property_code', 'dp_percent', 'dp_months', 'transaction_id', 'code_url', 'code_img_url', 'expiration_date'];

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
        return $this->belongsTo(Seller::class, 'seller_id', 'id', 'users');
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

    public function getCodeUrlAttribute(): ?string
    {
        return $this->getAttribute('meta')->get('payment.code_url');
    }

    public function setCodeUrlAttribute(string $value): self
    {

        $this->getAttribute('meta')->set('payment.code_url', $value);

        return $this;
    }

    public function getCodeImgUrlAttribute(): ?string
    {
        return $this->getAttribute('meta')->get('payment.code_img_url');
    }

    public function setCodeImgUrlAttribute(string $value): self
    {

        $this->getAttribute('meta')->set('payment.code_img_url', $value);

        return $this;
    }

    public function getExpirationDateAttribute(): ?string
    {
        return $this->getAttribute('meta')->get('payment.expiration_date');
    }

    public function setExpirationDateAttribute(string $value): self
    {

        $this->getAttribute('meta')->set('payment.expiration_date', $value);

        return $this;
    }
}

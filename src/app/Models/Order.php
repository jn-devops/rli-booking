<?php

namespace RLI\Booking\Models;

use RLI\Booking\Traits\HasPackageFactory as HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use RLI\Booking\Traits\HasMeta;
use App\Models\User;

/**
 * Class Order
 *
 * @property integer   $id
 * @property string    $reference
 * @property string    $sku
 * @property string    $property_code
 * @property int       $dp_percent
 * @property int       $dp_months
 * @property string    $callback_url
 * @property BelongsTo $product
 * @property BelongsTo $buyer
 * @property BelongsTo $seller
 *
 *
 * @method   int    getKey()
 */
class Order extends Model
{
    use HasFactory;
    use Notifiable;
    use HasMeta;

    protected $fillable = ['reference', 'sku', 'property_code', 'dp_percent', 'dp_months', 'callback_url'];

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
        return $this->belongsTo(User::class, 'user_id');
    }

    public function routeNotificationForWebhook(): string
    {
        return 'https://eomuckur5juqabu.m.pipedream.net';
    }
}

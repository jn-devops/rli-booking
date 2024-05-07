<?php

namespace RLI\Booking\Models;

use RLI\Booking\Traits\HasPackageFactory as HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use RLI\Booking\Interfaces\AttributableData;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Inventory
 *
 * @property int    $id
 * @property string $property_code
 *
 * @method   int    getKey()
 */
class Inventory extends Model implements AttributableData
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = ['property_code'];

    public function toData(): array
    {
        return $this->only(array_diff($this->getFillable(), $this->getHidden()));
    }

    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}

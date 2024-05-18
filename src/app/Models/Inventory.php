<?php

namespace RLI\Booking\Models;

use Spatie\SchemalessAttributes\Casts\SchemalessAttributes;
use RLI\Booking\Traits\HasPackageFactory as HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use RLI\Booking\Interfaces\AttributableData;
use Illuminate\Database\Eloquent\Model;
use RLI\Booking\Traits\HasMeta;
use Illuminate\Support\Carbon;

/**
 * Class Inventory
 *
 * @property int                  $id
 * @property string               $sku
 * @property string               $property_code
 * @property Product              $product
 * @property SchemalessAttributes $meta
 * @property array                $mappings
 * @property Carbon               $reserved_at
 * @property Carbon               $sold_at
 * @property bool                 $reserved
 * @property bool                 $sold
 *
 * @method   int    getKey()
 */
class Inventory extends Model implements AttributableData
{
    use SoftDeletes;
    use HasFactory;
    use HasMeta;

    protected $fillable = ['sku', 'property_code'];

    protected $casts = [
        'mappings' => 'array',
        'reserved_at' => 'datetime',
        'sold_at' => 'datetime',
    ];

    public function toData(): array
    {
        return $this->only(array_diff($this->getFillable(), $this->getHidden()));
    }

    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Product::class, 'sku', 'sku');
    }

    public function getReservedAttribute(): bool
    {
        $reservedAt = $this->getAttribute('reserved_at');

        return $reservedAt && $reservedAt <= now();
    }

    public function setReservedAttribute(bool $value): self
    {
        $this->forceFill(['reserved_at' => $value ? Carbon::now() : null]);

        return $this;
    }

    public function getSoldAttribute(): bool
    {
        $reservedAt = $this->getAttribute('sold_at');

        return $reservedAt && $reservedAt <= now();
    }

    public function setSoldAttribute(bool $value): self
    {
        $this->forceFill(['sold_at' => $value ? Carbon::now() : null]);

        return $this;
    }
}

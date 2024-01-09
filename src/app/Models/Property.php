<?php

namespace RLI\Booking\Models;

use RLI\Booking\Traits\HasPackageFactory as HasFactory;
use Illuminate\Database\Eloquent\Model;
use RLI\Booking\Traits\HasMeta;

/**
 * Class Property
 *
 * @property string $code
 * @property string $sku
 * @property int    $floorArea
 *
 * @method   int    getKey()
 */
class Property extends Model
{
    use HasFactory;
    use HasMeta;

    protected $fillable = ['code', 'sku'];

    public function getFloorAreaAttribute(): ?int
    {
        return $this->getAttribute('meta')->get('floor_area');
    }

    public function setFloorAreaAttribute(int $value): static
    {
        $this->getAttribute('meta')->set('floor_area', $value);

        return $this;
    }
}

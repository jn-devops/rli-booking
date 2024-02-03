<?php

namespace RLI\Booking\Models;

use RLI\Booking\Traits\HasPackageFactory as HasFactory;
use RLI\Booking\Interfaces\AttributableData;
use Illuminate\Database\Eloquent\Model;
use RLI\Booking\Traits\HasMeta;

/**
 * Class Product
 *
 * @property int     $id
 * @property string  $sku
 * @property string  $name
 * @property int     $processing_fee
 * @property string  $description
 *
 * @method   int     getKey()
 */
class Product extends Model implements AttributableData
{
    use HasFactory;
    use HasMeta;

    protected $fillable = ['sku', 'name', 'processing_fee'];

    public function getDescriptionAttribute(): ?string
    {
        return $this->getAttribute('meta')->get('description');
    }

    public function setDescriptionAttribute(string $value): static
    {
        $this->getAttribute('meta')->set('description', $value);

        return $this;
    }

    public function toData(): array
    {
        return $this->only(array_diff($this->getFillable(), $this->getHidden()));
    }
}

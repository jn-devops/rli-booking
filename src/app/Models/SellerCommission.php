<?php

namespace RLI\Booking\Models;

use RLI\Booking\Traits\HasPackageFactory as HasFactory;
use RLI\Booking\Interfaces\AttributableData;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Buyer
 *
 * @property int     $id
 * @property string  $code
 * @property array   $rate
 * @property string  $remarks
 *
 * @method   int    getKey()
 */
class SellerCommission extends Model implements AttributableData
{
    use HasFactory;

    protected $fillable = ['code', 'rate', 'remarks'];

    protected $casts = [
        'rate' => 'array'
    ];

    public function toData(): array
    {
        return $this->only(array_diff($this->getFillable(), $this->getHidden()));
    }
}

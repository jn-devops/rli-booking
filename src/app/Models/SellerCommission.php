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
 * @property array   $scheme
 * @property string  $remarks
 *
 * @method   int    getKey()
 */
class SellerCommission extends Model implements AttributableData
{
    use HasFactory;

    protected $fillable = ['code', 'scheme', 'remarks'];

    protected $casts = [
        'scheme' => 'array'
    ];

    public function toData(): array
    {
        return $this->only(array_diff($this->getFillable(), $this->getHidden()));
    }
}

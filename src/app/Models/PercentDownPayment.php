<?php

namespace RLI\Booking\Models;

use RLI\Booking\Traits\HasPackageFactory as HasFactory;
use Illuminate\Database\Eloquent\Model;
use RLI\Booking\Traits\HasMeta;

/**
 * Class PercentDownPayment
 *
 * @property string $code
 * @property string $name
 * @property float  $percent
 *
 * @method   int    getKey()
 */
class PercentDownPayment extends Model
{
    use HasFactory;
    use HasMeta;

    protected $fillable = ['code', 'name', 'percent'];
}

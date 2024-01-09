<?php

namespace RLI\Booking\Models;

use RLI\Booking\Traits\HasPackageFactory as HasFactory;
use Illuminate\Database\Eloquent\Model;
use RLI\Booking\Traits\HasMeta;

/**
 * Class MonthsToPayDownPayment
 *
 * @property string $code
 * @property string $name
 * @property int    $months
 *
 * @method   int    getKey()
 */
class MonthsToPayDownPayment extends Model
{
    use HasFactory;
    use HasMeta;

    protected $fillable = ['code', 'name', 'months'];
}

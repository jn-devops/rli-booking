<?php

namespace RLI\Booking\Models;

use RLI\Booking\Traits\HasPackageFactory as HasFactory;
use Illuminate\Database\Eloquent\Model;
use RLI\Booking\Traits\HasMeta;

/**
 * Class Seller
 *
 * @property string $code
 * @property string $name
 * @property string $email
 * @property string $mobile
 *
 * @method   int    getKey()
 */
class Seller extends Model
{
    use HasFactory;
    use HasMeta;

    protected $fillable = ['code', 'name', 'email', 'mobile'];
}

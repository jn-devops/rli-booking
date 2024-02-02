<?php

namespace RLI\Booking\Models;

use RLI\Booking\Traits\HasPackageFactory as HasFactory;
use Illuminate\Database\Eloquent\Model;
use RLI\Booking\Traits\HasMeta;

/**
 * Class Buyer
 *
 * @property int    $id
 * @property string $name
 * @property string $address
 * @property string $birthdate
 * @property string $email
 * @property string $mobile
 * @property string $id_type
 * @property string $id_number
 * @property string $id_image_url
 * @property string $selfie_image_url
 * @property string $id_mark_url
 *
 * @method   int    getKey()
 */
class Buyer extends Model
{
    use HasFactory;
    use HasMeta;

    protected $fillable = ['name', 'address', 'birthdate', 'email', 'mobile', 'id_type', 'id_number', 'id_image_url', 'selfie_image_url', 'id_mark_url'];
}

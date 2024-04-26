<?php

namespace RLI\Booking\Models;

use RLI\Booking\Traits\HasPackageFactory as HasFactory;
use RLI\Booking\Interfaces\AttributableData;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Contact
 *
 * @property int    $id
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property string $civil_status
 * @property string $sex
 * @property string $nationality
 * @property string $date_of_birth
 * @property string $email
 * @property string $mobile
 * @property array $addresses
 * @property array $employment
 * @property array $co_borrowers
 *
 * @method   int    getKey()
 */

class Contact extends Model implements AttributableData
{
    use HasFactory;
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'civil_status',
        'sex',
        'nationality',
        'date_of_birth',
        'email',
        'mobile',
        'addresses',
        'employment',
        'co_borrowers'
    ];
 
    protected $casts = [
        "addresses" => "array",
        "employment" => "array",
        "co_borrowers" => "array"
    ];

    public function toData(): array
    {
        return $this->only(array_diff($this->getFillable(), $this->getHidden()));
    }
}

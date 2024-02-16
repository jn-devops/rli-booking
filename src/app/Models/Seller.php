<?php

namespace RLI\Booking\Models;

use RLI\Booking\Traits\HasPackageFactory as HasFactory;
use RLI\Booking\Interfaces\AttributableData;
use Parental\HasParent;
use App\Models\User;

/**
 * Class Seller
 *
 * @property int    $id
 * @property string $name
 * @property string $email
 *
 * @method   int    getKey()
 */
class Seller extends User implements AttributableData
{
    use HasFactory;
    use HasParent;

    static public function from(User $user): self
    {
        $model = new Seller();
        $model->setRawAttributes($user->getAttributes(), true);
        $model->exists = true;
        $model->setConnection($user->getConnectionName());
        $model->fireModelEvent('retrieved', false);

        return $model;
    }

    public function toData(): array
    {
        return $this->only(array_diff($this->getFillable(), $this->getHidden()));
    }
}

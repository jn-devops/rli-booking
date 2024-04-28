<?php

namespace RLI\Booking\Models;

use RLI\Booking\Traits\HasPackageFactory as HasFactory;
use RLI\Booking\Interfaces\AttributableData;
use RLI\Booking\Traits\HasMeta;
use Parental\HasParent;
use App\Models\User;

/**
 * Class Seller
 *
 * @property int    $id
 * @property string $name
 * @property string $email
 * @property string $mobile
 * @property string $personal_email
 * @property string $seller_code
 * @property string $bank_code
 * @property string $account_number
 * @property string $account_name
 * @property bool   $accredited
 * @property int    $mfiles_id
 *
 * @method   int    getKey()
 */
class Seller extends User implements AttributableData
{
    use HasFactory;
    use HasParent;
    use HasMeta;

    protected $fillable = ['name', 'email', 'mobile', 'personal_email', 'seller_code', 'bank_code', 'account_number', 'account_name', 'accredited', 'mfiles_id'];

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

    public function getPersonalEmailAttribute(): ?string
    {
        return $this->getAttribute('meta')->get('personal_email');
    }

    public function setPersonalEmailAttribute(string $value): static
    {
        $this->getAttribute('meta')->set('personal_email', $value);

        return $this;
    }

    public function getSellerCodeAttribute(): ?string
    {
        return $this->getAttribute('meta')->get('seller_code', $this->getAttribute('email'));
    }

    public function setSellerCodeAttribute(?string $value): static
    {
        $this->getAttribute('meta')->set('seller_code', $value);

        return $this;
    }

    public function getBankCodeAttribute(): ?string
    {
        return $this->getAttribute('meta')->get('bank_code');
    }

    public function setBankCodeAttribute(?string $value): static
    {
        $this->getAttribute('meta')->set('bank_code', $value);

        return $this;
    }

    public function getAccountNumberAttribute(): ?string
    {
        return $this->getAttribute('meta')->get('account_number');
    }

    public function setAccountNumberAttribute(?string $value): static
    {
        $this->getAttribute('meta')->set('account_number', $value);

        return $this;
    }

    public function getAccountNameAttribute(): ?string
    {
        return $this->getAttribute('meta')->get('account_name');
    }

    public function setAccountNameAttribute(?string $value): static
    {
        $this->getAttribute('meta')->set('account_name', $value);

        return $this;
    }

    public function getAccreditedAttribute(): bool
    {
        return $this->getAttribute('accredited_at')
            && $this->getAttribute('accredited_at') <= now();
    }

    public function setAccreditedAttribute(bool $value): void
    {
        $this->setAttribute('accredited_at', $value ? now() : null);
    }

    public function routeNotificationForEngageSpark()
    {
        return $this->mobile;
    }
}

<?php

namespace RLI\Booking\Models;

use Spatie\MediaLibrary\MediaCollections\Exceptions\FileCannotBeAdded;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use RLI\Booking\Traits\HasPackageFactory as HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\MediaCollections\File;
use RLI\Booking\Interfaces\AttributableData;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\{Arr, Str};
use Spatie\MediaLibrary\HasMedia;
use RLI\Booking\Data\ContactData;
use Illuminate\Support\Carbon;
use Spatie\Image\Enums\Fit;

/**
 * Class Contact
 *
 * @property int    $id
 * @property string $uid
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property string $civil_status
 * @property string $sex
 * @property string $nationality
 * @property Carbon $date_of_birth
 * @property string $email
 * @property string $mobile
 * @property array  $spouse
 * @property array  $addresses
 * @property array  $employment
 * @property array  $co_borrowers
 * @property array  $uploads
 * @property array  $order
 * @property array  $media
 * @property Media  $idImage
 * @property Media  $selfieImage
 * @property Media  $payslipImage
 *
 * @method   int    getKey()
 */

class Contact extends Model implements AttributableData, HasMedia
{
    use InteractsWithMedia;
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
        'spouse',
        'addresses',
        'employment',
        'co_borrowers',
        'order',
        'idImage',
        'selfieImage',
        'payslipImage'
    ];

    protected $casts = [
        'spouse' => 'array',
        'addresses' => 'array',
        'employment' => 'array',
        'co_borrowers' => 'array',
        'order' => 'array',
    ];

    protected array $dates = [
        'date_of_birth'
    ];

    public function toData(): array
    {
        return ContactData::fromModel($this)->toArray();
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uid = Str::orderedUuid()->toString();
        });
    }

    /**
     * @return Media|null
     */
    public function getIdImageAttribute(): ?Media
    {
        return $this->getFirstMedia('id-images');
    }

    /**
     * @param string|null $url
     * @return $this
     * @throws FileCannotBeAdded
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function setIdImageAttribute(?string $url): static
    {
        if ($url)
            $this->addMediaFromUrl($url)->toMediaCollection('id-images');

        return $this;
    }

    /**
     * @return Media|null
     */
    public function getSelfieImageAttribute(): ?Media
    {
        return $this->getFirstMedia('selfie-images');
    }

    /**
     * @param string|null $url
     * @return $this
     * @throws FileCannotBeAdded
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function setSelfieImageAttribute(?string $url): static
    {
        if ($url)
            $this->addMediaFromUrl($url)->toMediaCollection('selfie-images');

        return $this;
    }

    /**
     * @return Media|null
     */
    public function getPayslipImageAttribute(): ?Media
    {
        return $this->getFirstMedia('payslip-images');
    }

    /**
     * @param string|null $url
     * @return $this
     * @throws FileCannotBeAdded
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function setPayslipImageAttribute(?string $url): static
    {
        if ($url)
            $this->addMediaFromUrl($url)->toMediaCollection('payslip-images');

        return $this;
    }

    /**
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $collections = [
            'id-images' => 'image/jpeg',
            'selfie-images' => 'image/jpeg',
            'payslip-images' => 'image/jpeg',
        ];

        foreach ($collections as $collection => $mimeType) {
            $this->addMediaCollection($collection)
                ->singleFile()
                ->acceptsFile(function (File $file) use ($mimeType) {
                    return $file->mimeType === $mimeType;
                });
        }
    }

    /**
     * @param Media|null $media
     * @return void
     */
    public function registerMediaConversions(Media $media = null): void
    {
        $this
            ->addMediaConversion('preview')
            ->fit(Fit::Contain, 300, 300)
            ->nonQueued();
    }

    public function getUploadsAttribute(): array
    {
        return collect($this->media)
            ->mapWithKeys(function ($item, $key) {
                $collection_name = $item['collection_name'];
                $name = Str::camel(Str::singular($collection_name));
                $url = $item['original_url'];
                return [
                    $key => [
                        'name' => $name,
                        'url' => $url
                    ]
                ];
            })
            ->toArray();
    }
}

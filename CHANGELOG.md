#Change Log

## [Unreleased] - 27 Apr 2024
### Added
#### CHANGELOG.md
#### src/app/Actions/PersistContactAction.php
#### src/tests/Feature/PersistContactActionTest.php
#### src/app/Actions/AssociateContactAction.php
#### src/tests/Feature/AssociateContactActionTest.php
#### src/app/Actions/AttachContactMediaAction.php
#### src/tests/Feature/AttachContactMediaActionTest.php
#### src/database/migrations/2024_04_27_080825_add_uid_and_order_to_contacts_table.php
    $table->uuid('uid')->after('id'); 
    $table->json('order')->after('co_borrowers')->nullable();
#### database/migrations/2024_04_27_165703_add_contact_id_to_buyers_table.php]
    $table->foreignId('contact_id')->nullable();
#### src/app/Observers/SellerObserver.php
    public function creating(Seller $seller): void
    {
        $seller->seller_code = $seller->email;
    }
### Changed
#### routes/api.php
    Route::post('/persist-contact/', \RLI\Booking\Actions\PersistContactAction::class)->name('persist-contact');
    Route::post('attach-contact-media/{uid}', \RLI\Booking\Actions\AttachContactMediaAction::class)->name('attach-contact-media');
#### routes/web.php
    Route::post('associate-contact/{buyer}/{contact}', \RLI\Booking\Actions\AssociateContactAction::class)->name('associate-contact');
#### src/app/Models/Contact.php
    /**
    * Class Contact
      * ...
      * @property array  $order
      * @property Media  $idImage
      * @property Media  $selfieImage
      * @property Media  $payslipImage
      * ...
    */

    protected $fillable = [
        ...
        'order',
        'idImage',
        'selfieImage',
        'payslipImage'
    ];

    protected $casts = [
      ...
      'order' => 'array',
    ];
    
    protected static function boot(): void
    {
      parent::boot();
    
      static::creating(function ($model) {
          $model->uid = Str::ulid();
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

#### src/app/Models/Buyer.php
    public function contact(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }
#### src/app/Models/Seller.php
    /**
    * Class Seller
    * ....
    * @property string $seller_code

    protected $fillable = [... 'seller_code', ...];


    public function getSellerCodeAttribute(): ?string
    {
        return $this->getAttribute('meta')->get('seller_code', $this->getAttribute('email'));
    }

    public function setSellerCodeAttribute(?string $value): static
    {
        $this->getAttribute('meta')->set('seller_code', $value);

        return $this;
    }
#### src/app/Actions/UpdateSellerBankInformationAction.php
    public function rules(): array
    {
        return [
            'seller_code' => ['required', 'string', 'unique:users,meta->seller_code'],
            ...
        ];
    }
#### src/app/Providers/EventServiceProvider.php
    use RLI\Booking\Observers\SellerObserver;
    use RLI\Booking\Models\Seller;

    public function boot(): void
    {
        ...
        Seller::observe(SellerObserver::class);
    }
#### src/app/Data/ContactData.php
    public function __construct(
        ...
        public ContactOrderData|Optional $order,
        public ?string $idImage,
        public ?string $selfieImage,
        public ?string $payslipImage,
    }

    public static function fromModel(object $model): self
    {
        return new self(
            first_name: $model->first_name,
            middle_name: $model->middle_name,
            last_name: $model->last_name,
            civil_status: $model->civil_status,
            sex: $model->sex,
            nationality: $model->nationality,
            date_of_birth: $model->date_of_birth,
            email: $model->email,
            mobile: $model->mobile,
            addresses: $model->addresses,
            employment: $model->employment,
            co_borrowers: $model->co_borrowers,
            order: ContactOrderData::from($model->order),
            idImage: $model->idImage->getUrl(),
            selfieImage: $model->selfieImage->getUrl(),
            payslipImage: $model->payslipImage->getUrl()
        );
    }

    class ContactOrderData extends Data
    {
        public function __construct(
        public string $sku,
        public string $seller_code,
        public string $property_code,
    ) {}
    }
#### src/app/Data/SellerData.php
    public ?string $seller_code,
#### src/tests/Unit/ContactTest.php
    test('contact has schema attributes', function () {
        ...
        expect($contact->order)->toBeArray();
        expect($contact->idImage)->toBeInstanceOf(Media::class);
        expect($contact->selfieImage)->toBeInstanceOf(Media::class);
        expect($contact->payslipImage)->toBeInstanceOf(Media::class);
    });

    test('contact has data', function () {
        ...
        expect($data->order->toArray())->toBe(ContactOrderData::from($contact->order)->toArray());
        expect($data->idImage)->toBe($contact->idImage->getUrl());
        expect($data->selfieImage)->toBe($contact->selfieImage->getUrl());
        expect($data->payslipImage)->toBe($contact->payslipImage->getUrl());
    });

    test('contact can attach media', function () {
        $idImageUrl = 'https://jn-img.enclaves.ph/Test/idImage.jpg';
        $selfieImageUrl = 'https://jn-img.enclaves.ph/Test/selfieImage.jpg';
        $payslipImageUrl = 'https://jn-img.enclaves.ph/Test/payslipImage.jpg';
        $contact = Contact::factory()->create(['idImage' => null, 'selfieImage' => null, 'payslipImage' => null]);
        $contact->idImage = $idImageUrl;
        $contact->selfieImage = $selfieImageUrl;
        $contact->payslipImage = $payslipImageUrl;
        $contact->save();
    
        expect($contact->idImage)->toBeInstanceOf(Media::class);
        expect($contact->selfieImage)->toBeInstanceOf(Media::class);
        expect($contact->payslipImage)->toBeInstanceOf(Media::class);
        expect($contact->idImage->name)->toBe('idImage');
        expect($contact->idImage->file_name)->toBe('idImage.jpg');
        expect($contact->payslipImage->file_name)->toBe('payslipImage.jpg');
        expect($contact->idImage->name)->toBe('idImage');
        expect($contact->selfieImage->name)->toBe('selfieImage');
        expect($contact->payslipImage->name)->toBe('payslipImage');
        expect($contact->idImage->file_name)->toBe('idImage.jpg');
        expect($contact->selfieImage->file_name)->toBe('selfieImage.jpg');
        expect($contact->payslipImage->file_name)->toBe('payslipImage.jpg');
        tap(config('app.url'), function ($host) use ($contact) {
            expect($contact->idImage->getUrl())->toBe(__(':host/storage/:path', ['host' => $host, 'path' => $contact->idImage->getPathRelativeToRoot()]));
            expect($contact->selfieImage->getUrl())->toBe(__(':host/storage/:path', ['host' => $host, 'path' => $contact->selfieImage->getPathRelativeToRoot()]));
            expect($contact->payslipImage->getUrl())->toBe(__(':host/storage/:path', ['host' => $host, 'path' => $contact->payslipImage->getPathRelativeToRoot()]));
            $contact->idImage->delete();
        });
        $contact->selfieImage->delete();
        $contact->payslipImage->delete();
        $contact->clearMediaCollection('id-images');
        $contact->clearMediaCollection('selfie-images');
        $contact->clearMediaCollection('payslip-images');
    });

#### src/tests/Unit/BuyerTest.php
    test('buyer has contact', function () {
        $buyer = Buyer::factory()->forContact()->create();
        expect($buyer->contact)->toBeInstanceOf(Contact::class);
        $buyer = Buyer::factory()->create();
        expect($buyer->contact)->toBeNull();
        $contact = Contact::factory()->create();
        $buyer->contact()->associate($contact);
        $buyer->save();
        expect($buyer->contact)->toBeInstanceOf(Contact::class);
    });
#### src/tests/Feature/UpdateSellerBankInformationActionTest.php
    $attribs = [
        'seller_code' => $this->faker->email(),
        ...
    ];
    expect($seller->seller_code)->toBe($attribs['seller_code']);
#### src/tests/Unit/SellerTest.php
    test('seller has data', function () {
        ...
        expect($data->seller_code)->toBe($seller->seller_code);
        ...
    });

    test('seller default seller_code is email', function () {
        $seller = Seller::factory()->create(['seller_code'=> null]);
        expect($seller->seller_code)->toBe($seller->email);
    });
#### src/database/factories/ContactFactory.php
    'order' => [
        'sku' => $this->faker->word(),
        'seller_code' => $this->faker->word(),
        'property_code' => $this->faker->word(),
      ],
    'idImage' => $this->faker->imageUrl(format: 'jpeg'),
    'selfieImage' => $this->faker->imageUrl(format: 'jpeg'),
    'payslipImage' => $this->faker->imageUrl(format: 'jpeg')
#### src/database/factories/SellerFactory.php
    'seller_code' => $this->faker->word(),
#### resources/js/Pages/Profile/Partials/UpdateBankInformationForm.vue
    const form = useForm({
        seller_code: props.seller.seller_code,
        ...
    });

      <!-- Seller Code -->
      <div class="col-span-6 sm:col-span-4">
          <InputLabel for="seller_code" value="Seller Code" />
          <TextInput
              id="seller_code"
              v-model="form.seller_code"
              type="text"
              class="mt-1 block w-full"
              required
          />
          <InputError :message="form.errors.seller_code" class="mt-2" />
      </div>
### Fixed
#### Contact
    /**
    * Class Contact
    *
    * ...
    * @property Carbon $date_of_birth
    * ...

      protected array $dates = [
          'date_of_birth'
      ];
### Notes


#Change Log

## [Unreleased] - 27 Apr 2024
### Added
#### CHANGELOG.md
#### src/app/Actions/PersistContactAction.php
#### src/tests/Feature/PersistContactActionTest.php
#### src/app/Actions/AssociateContactAction.php
#### src/tests/Feature/AssociateContactActionTest.php
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
#### routes/web.php
    Route::post('associate-contact/{buyer}/{contact}', \RLI\Booking\Actions\AssociateContactAction::class)->name('associate-contact');
#### src/app/Models/Contact.php
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
        public ?array $order
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
    expect($contact->order)->toBeArray();
    expect($data->order)->toBe($contact->order);
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


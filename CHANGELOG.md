#Change Log

## [Unreleased] - 27 Apr 2024
### Added
#### CHANGELOG.md
#### src/app/Actions/PersistContactAction.php
#### src/tests/Feature/PersistContactActionTest.php
#### src/database/migrations/2024_04_27_080825_add_uid_and_order_to_contacts_table.php
    $table->uuid('uid')->after('id'); 
    $table->json('order')->after('co_borrowers')->nullable();
### Changed
#### routes/api.php
    Route::post('/persist-contact/', \RLI\Booking\Actions\PersistContactAction::class)->name('persist-contact');
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
#### src/tests/Unit/ContactTest.php
    expect($contact->order)->toBeArray();
    expect($data->order)->toBe($contact->order);
#### src/database/factories/ContactFactory.php
    'order' => [
        'sku' => $this->faker->word(),
        'seller_code' => $this->faker->word(),
        'property_code' => $this->faker->word(),
      ],
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


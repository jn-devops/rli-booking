<?php

use Illuminate\Foundation\Testing\{RefreshDatabase, WithFaker};
use RLI\Booking\Seeders\{PermissionSeeder, RoleSeeder};
use RLI\Booking\Models\{Seller, SellerCommission};
use RLI\Booking\Data\SellerData;
use App\Models\User;
use RLI\Booking\Enums\{PermissionsEnum, SellerRolesEnum};

uses(RefreshDatabase::class, WithFaker::class);

beforeEach(function() {
    $this->faker = $this->makeFaker('en_PH');
});

test('seller is user', function () {
    $user = User::factory()->create();
    $seller = Seller::from($user);
    expect($seller->is($user))->toBeTrue();
});

test('seller has schema attributes', function () {
    $seller = Seller::factory()->create();
    expect($seller->code)->toBeString();
    expect($seller->name)->toBeString();
    expect($seller->email)->toBeString();
    expect($seller->mobile)->toBeString();
    expect($seller->default_seller_commission_code)->toBeString();
    expect($seller->bank_code)->toBeString();
    expect($seller->account_number)->toBeString();
    expect($seller->account_name)->toBeString();
    expect($seller->mfiles_id)->toBeInt();
    expect($seller->accredited)->toBeFalse();
});

test('seller has seller commissions', function () {
    $manager = Seller::factory()->create();
    $supervisor = Seller::factory()->create();
    $seller = Seller::factory()->has(SellerCommission::factory()->count(5))->create();
    expect($seller->sellerCommissions)->toHaveCount(5);
    $seller = Seller::factory()->create();
    $seller->sellerCommissions()->saveMany([
        new SellerCommission([
            'code' => 'ABC-123', 'scheme' => $scheme = [
                [
                    'seller_code' => $manager->code,
                    'percent' => 0.02
                ],
                [
                    'seller_code' => $supervisor->code,
                    'percent' => 0.03
                ],
                [
                    'seller_code' => $seller->code,
                    'percent' => 0.04
                ],
            ],
            'remarks' => $this->faker->sentence()]),
        new SellerCommission(['code' => 'DEF-456', 'scheme' => [], 'remarks' => $this->faker->sentence()]),
        new SellerCommission(['code' => 'GHI-789', 'scheme' => [], 'remarks' => $this->faker->sentence()]),
    ]);
    expect($seller->sellerCommissions)->toHaveCount(3);
    $seller_commission = $seller->sellerCommissions->where('code', 'ABC-123')->first();
    expect($seller_commission->scheme)->toBe($scheme);
});

test('seller default code is uuid', function () {
    $seller = Seller::factory()->create(['code'=> null]);
    expect($seller->code)->toBeUuid();
});

test('seller default seller commission code is null', function () {
    $seller = Seller::factory()->create(['default_seller_commission_code'=> null]);
    expect($seller->default_seller_commission_code)->toBeNull();
});

test('seller has data', function () {
    $seller = Seller::factory()->create();
    $seller->sellerCommissions()->saveMany([
        new SellerCommission(['code' => $this->faker->word(), 'scheme' => [], 'remarks' => $this->faker->sentence()]),
        new SellerCommission(['code' => $this->faker->word(), 'scheme' => [], 'remarks' => $this->faker->sentence()]),
        new SellerCommission(['code' => $this->faker->word(), 'scheme' => [], 'remarks' => $this->faker->sentence()]),
    ]);
//    $seller = Seller::factory()->has(SellerCommission::factory()->count(2))->create();
    $data = SellerData::fromModel($seller);
    expect($data->code)->toBe($seller->code);
    expect($data->name)->toBe($seller->name);
    expect($data->email)->toBe($seller->email);
    expect($data->mobile)->toBe($seller->mobile);
    expect($data->default_seller_commission_code)->toBe($seller->default_seller_commission_code);
    expect($data->bank_code)->toBe($seller->bank_code);
    expect($data->account_number)->toBe($seller->account_number);
    expect($data->account_name)->toBe($seller->account_name);
    expect($data->mfiles_id)->toBe($seller->mfiles_id);
    expect($data->accredited)->toBe($seller->accredited);
    expect($data->seller_commissions)->toBeInstanceOf(\Spatie\LaravelData\DataCollection::class);
    expect($data->seller_commissions)->toHaveCount(3);
});

test('seller has roles', function () {
    $this->seed(PermissionSeeder::class);
    $this->seed(RoleSeeder::class);
    $seller = Seller::factory()->create();
    $seller->assignRole(SellerRolesEnum::BROKER);
    expect($seller->hasRole(SellerRolesEnum::BROKER))->toBeTrue();
    expect($seller->can([
        PermissionsEnum::CREATE_CONTACTS->value,
        PermissionsEnum::VIEW_CONTACTS->value,
        PermissionsEnum::EDIT_CONTACTS->value,
        PermissionsEnum::ASSIGN_CONTACTS->value,
        PermissionsEnum::DELETE_CONTACTS->value
        ])
    )->toBeTrue();
});

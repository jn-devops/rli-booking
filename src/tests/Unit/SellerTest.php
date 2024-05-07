<?php

use Illuminate\Foundation\Testing\{RefreshDatabase, WithFaker};
use RLI\Booking\Data\SellerData;
use RLI\Booking\Models\Seller;
use App\Models\User;

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

test('seller has data', function () {
    $seller = Seller::factory()->create();
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
});

test('seller default code is uuid', function () {
    $seller = Seller::factory()->create(['code'=> null]);
    expect($seller->code)->toBeUuid();
});

test('seller default seller commission code is null', function () {
    $seller = Seller::factory()->create(['default_seller_commission_code'=> null]);
    expect($seller->default_seller_commission_code)->toBeNull();
});

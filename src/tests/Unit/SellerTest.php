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
    expect($seller->name)->toBeString();
    expect($seller->email)->toBeString();
    expect($seller->mobile)->toBeString();
    expect($seller->bank_code)->toBeString();
    expect($seller->account_number)->toBeString();
    expect($seller->account_name)->toBeString();
    expect($seller->mfiles_id)->toBeInt();
    expect($seller->accredited)->toBeFalse();
});

test('seller has data', function () {
    $seller = Seller::factory()->create();
    $data = SellerData::fromModel($seller);
    expect($data->email)->toBe($seller->email);
    expect($data->name)->toBe($seller->name);
});

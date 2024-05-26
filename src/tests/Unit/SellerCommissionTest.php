<?php

use Illuminate\Foundation\Testing\{RefreshDatabase, WithFaker};
use RLI\Booking\Data\SellerCommissionData;
use RLI\Booking\Models\SellerCommission;
use RLI\Booking\Models\Seller;

uses(RefreshDatabase::class, WithFaker::class);

beforeEach(function() {
    $this->faker = $this->makeFaker('en_PH');
});

test('seller commission has schema attributes', function () {
    $seller_commission = SellerCommission::factory()->create();
    expect($seller_commission->seller)->toBeInstanceOf(Seller::class);
    expect($seller_commission->code)->toBeString();
    expect($seller_commission->project_code)->toBeString();
    expect($seller_commission->scheme)->toBeArray();
    expect($seller_commission->remarks)->toBeString();
});

test('seller commission may just contain a code', function () {
    $code = $this->faker->word();
    $seller_commission = new SellerCommission(['code' => $code]);
    $seller_commission->save();
    $sc = SellerCommission::where('code', $code)->first();
    expect($sc->is($seller_commission))->toBeTrue();
    expect($sc->scheme)->toBeEmpty();
});

test('seller commission has unique seller code and project code', function () {
    $code = $this->faker->word();
    $project_code = $this->faker->word();
    SellerCommission::factory()->create(['code' => $code, 'project_code' => $project_code]);
    SellerCommission::factory()->create(['code' => $code, 'project_code' => $project_code]);
})->expectException(\Illuminate\Database\UniqueConstraintViolationException::class);

test('seller commission has data', function () {
    $seller_commission = SellerCommission::factory()->create();
    $data = SellerCommissionData::fromModel($seller_commission);
    expect($data->code)->toBe($seller_commission->code);
    expect($data->project_code)->toBe($seller_commission->project_code);
    expect($data->scheme->toArray())->toBe($seller_commission->scheme);
    expect($data->remarks)->toBe($seller_commission->remarks);
});


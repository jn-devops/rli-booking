<?php

use Illuminate\Foundation\Testing\{RefreshDatabase, WithFaker};
use RLI\Booking\Models\SellerCommission;
use RLI\Booking\Data\SellerCommissionData;

uses(RefreshDatabase::class, WithFaker::class);

beforeEach(function() {
    $this->faker = $this->makeFaker('en_PH');
});

test('seller commission has schema attributes', function () {
    $seller_commission = SellerCommission::factory()->create();
    expect($seller_commission->code)->toBeString();
    expect($seller_commission->rate)->toBeArray();
    expect($seller_commission->remarks)->toBeString();
});

test('seller commission has data', function () {
    $seller_commission = SellerCommission::factory()->create();
    $data = SellerCommissionData::fromModel($seller_commission);
    expect($data->code)->toBe($seller_commission->code);
    expect($data->rate)->toBe($seller_commission->rate);
    expect($data->remarks)->toBe($seller_commission->remarks);
});


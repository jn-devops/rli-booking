<?php

use RLI\Booking\Classes\State\{InternallyCreatedPendingUpdate, UpdatedPendingProcessing};
use Illuminate\Foundation\Testing\{RefreshDatabase, WithFaker};
use RLI\Booking\Actions\UpdateSellerBankInformationAction;
use RLI\Booking\Seeders\UserSeeder;
use RLI\Booking\Models\Seller;

uses(RefreshDatabase::class, WithFaker::class);

beforeEach(function() {
    $this->seed(UserSeeder::class);
    $this->faker = $this->makeFaker('en_PH');
});

dataset('seller', [
    [ fn() =>  Seller::factory()->create(['bank_code' => null, 'account_number' => null, 'account_name' => null]) ]
]);

test('update seller bank information action requires bank_code, account_number, account_name', function (Seller $seller) {
    expect($seller->bank_code)->toBeEmpty();
    expect($seller->account_number)->toBeEmpty();
    expect($seller->account_name)->toBeEmpty();
    $attribs = [
        'seller_code' => $this->faker->email(),
        'bank_code' => $this->faker->word(),
        'account_number' => $this->faker->word(),
        'account_name' => $this->faker->name()
    ];
    $data = UpdateSellerBankInformationAction::run($seller, $attribs);
    $seller = $seller->fresh();
    expect($seller->seller_code)->toBe($attribs['seller_code']);
    expect($seller->bank_code)->toBe($attribs['bank_code']);
    expect($seller->account_number)->toBe($attribs['account_number']);
    expect($seller->account_name)->toBe($attribs['account_name']);
})->with('seller');

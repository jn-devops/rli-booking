<?php

use Illuminate\Foundation\Testing\{RefreshDatabase, WithFaker};
use RLI\Booking\Actions\UpdateSellerMFilesIdAction;
use RLI\Booking\Models\Seller;

uses(RefreshDatabase::class, WithFaker::class);

beforeEach(function() {
    $this->faker = $this->makeFaker('en_PH');
});

dataset('seller', [
    [ fn() =>  Seller::factory()->create(['mfiles_id' => null]) ]
]);

test('update seller mfiles id action works', function (Seller $seller) {
    expect($seller->mfiles_id)->toBeNull();
    $mfiles_id = $this->faker->numberBetween(1000,9999);
    $action = app(UpdateSellerMFilesIdAction::class);
    $action->run($seller, $mfiles_id);
    expect($seller->mfiles_id)->toBe($mfiles_id);
})->with('seller');

test('update seller mfiles id  works has end points', function (Seller $seller) {
    expect($seller->mfiles_id)->toBeNull();
    $mfiles_id = $this->faker->numberBetween(1000,9999);
    $attribs = ['email' => $seller->email, 'mfiles_id' => $mfiles_id];
    $response = $this->postJson(route('update-seller-mfiles_id', $attribs));
    $response->assertStatus(200);
    $seller->refresh();
    $response->assertJsonFragment($seller->toData());
    expect($seller->mfiles_id)->toBe($mfiles_id);
})->with('seller');

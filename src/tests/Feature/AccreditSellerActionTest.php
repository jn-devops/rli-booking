<?php

use Illuminate\Foundation\Testing\{RefreshDatabase, WithFaker};
use RLI\Booking\Actions\AccreditSellerAction;
use RLI\Booking\Models\Seller;

uses(RefreshDatabase::class, WithFaker::class);

beforeEach(function() {
    $this->faker = $this->makeFaker('en_PH');
});

dataset('seller', [
    [ fn() =>  Seller::factory()->create(['accredited_at' => null]) ]
]);

test('accredit seller action works with accredit parameter', function (Seller $seller) {
    expect($seller->accredited)->toBeFalse();
    $action = app(AccreditSellerAction::class);
    $action->run($seller, false);
    expect($seller->accredited)->toBeFalse();
    $action->run($seller, true);
    expect($seller->accredited)->toBeTrue();
})->with('seller');

test('accredit seller action works even without accredit parameter', function (Seller $seller) {
    expect($seller->accredited)->toBeFalse();
    $action = app(AccreditSellerAction::class);
    $action->run($seller);
    expect($seller->accredited)->toBeTrue();
})->with('seller');

test('accredit seller action works has end points - works with parameter', function (Seller $seller) {
    expect($seller->accredited)->toBeFalse();
    $attribs = ['email' => $seller->email, 'accredit' => true];
    $response = $this->postJson(route('accredit-seller', $attribs));
    $response->assertStatus(200);
    $seller->refresh();
    $response->assertJsonFragment($seller->toData());
    expect($seller->accredited)->toBeTrue();
})->with('seller');

test('accredit seller action works has end points - works without parameter', function (Seller $seller) {
    expect($seller->accredited)->toBeFalse();
    $attribs = ['email' => $seller->email];
    $response = $this->postJson(route('accredit-seller', $attribs));
    $response->assertStatus(200);
    $seller->refresh();
    $response->assertJsonFragment($seller->toData());
    expect($seller->accredited)->toBeTrue();
})->with('seller');

<?php

use Illuminate\Foundation\Testing\{RefreshDatabase, WithFaker};
use RLI\Booking\Actions\RegisterSellerAction;
use RLI\Booking\Models\Seller;

uses(RefreshDatabase::class, WithFaker::class);

beforeEach(function() {
    $this->faker = $this->makeFaker('en_PH');
});

test('register seller action', function () {
    $mobile = $this->faker->phoneNumber();
    $email = $this->faker->email();
    $name = $this->faker->name();
    $password = $this->faker->password(8);
    $personal_email = $this->faker->email();

    $action = app(RegisterSellerAction::class);
    $attribs = compact('mobile', 'email', 'name', 'password', 'personal_email');
    $seller = $action->execute($attribs);
    expect($seller)->toBeInstanceOf(Seller::class);
    expect($seller->mobile)->toBe($mobile);
    expect($seller->email)->toBe($email);
    expect($seller->name)->toBe($name);
    expect($seller->personal_email)->toBe($personal_email);
});

test('register seller action has end points', function () {
    $mobile = $this->faker->phoneNumber();
    $email = $this->faker->email();
    $name = $this->faker->name();
    $password = $this->faker->password(8);
    $personal_email = $this->faker->email();
    $attribs = compact('mobile', 'email', 'name', 'password', 'personal_email');
    $response = $this->postJson(route('register-seller'), $attribs);
    $response->assertStatus(200);
    $seller = Seller::where('email', $email)->first();
    expect($seller)->toBeInstanceOf(Seller::class);
    expect($seller->mobile)->toBe($mobile);
    expect($seller->email)->toBe($email);
    expect($seller->name)->toBe($name);
    expect($seller->personal_email)->toBe($personal_email);
    $response->assertJsonFragment(compact( 'email', 'name'));
});

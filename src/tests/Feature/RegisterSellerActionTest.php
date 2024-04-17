<?php

use Illuminate\Foundation\Testing\{RefreshDatabase, WithFaker};
use RLI\Booking\Notifications\RegisteredSellerNotification;
use RLI\Booking\Actions\RegisterSellerAction;
use Illuminate\Support\Facades\Notification;
use RLI\Booking\Models\Seller;

uses(RefreshDatabase::class, WithFaker::class);

beforeEach(function() {
    $this->faker = $this->makeFaker('en_PH');
});

test('register seller action works', function () {
    Notification::fake();
    expect(Seller::all()->count())->toBe(0);
    $mobile = $this->faker->phoneNumber();
    $email = $this->faker->email();
    $name = $this->faker->name();
    $password = $this->faker->password(8);
    $personal_email = $this->faker->email();
    $action = app(RegisterSellerAction::class);
    $attribs = compact('mobile', 'email', 'name', 'password', 'personal_email');
    $seller = $action->execute($attribs);
    expect(Seller::all()->count())->toBe(1);
    expect($seller)->toBeInstanceOf(Seller::class);
    expect($seller->mobile)->toBe($mobile);
    expect($seller->email)->toBe($email);
    expect($seller->name)->toBe($name);
    expect($seller->personal_email)->toBe($personal_email);
    expect($seller->bank_code)->toBeNull();
    expect($seller->account_number)->toBeNull();
    expect($seller->account_name)->toBeNull();
    expect($seller->accredited)->toBeFalse();
    expect($seller->mfiles_id)->toBeNull();
    Notification::assertSentTo($seller, RegisteredSellerNotification::class);
});

test('register seller action has end points', function () {
    Notification::fake();
    expect(Seller::all()->count())->toBe(0);
    $mobile =$this->faker->phoneNumber();
    $mobile = "+639190842154";
    $email = $this->faker->email();
    $email = "clandrade@joy-nostalg.com";
    $name = $this->faker->name();
    $password = $this->faker->password(8);
    $personal_email = $this->faker->email();
    $attribs = compact('mobile', 'email', 'name', 'password', 'personal_email');
    $response = $this->postJson(route('register-seller'), $attribs);
    $response->assertStatus(200);
    expect(Seller::all()->count())->toBe(1);
    $seller = Seller::where('email', $email)->first();
    expect($seller)->toBeInstanceOf(Seller::class);
    expect($seller->mobile)->toBe($mobile);
    expect($seller->email)->toBe($email);
    expect($seller->name)->toBe($name);
    expect($seller->personal_email)->toBe($personal_email);
    expect($seller->bank_code)->toBeNull();
    expect($seller->account_number)->toBeNull();
    expect($seller->account_name)->toBeNull();
    expect($seller->accredited)->toBeFalse();
    expect($seller->mfiles_id)->toBeNull();
    $bank_code = null;
    $account_number = null;
    $account_name = null;
    $accredited = false;
    $mfiles_id = null;
    $response->assertJsonFragment(compact( 'email', 'name', 'mobile', 'personal_email', 'bank_code', 'account_number', 'account_name', 'accredited', 'mfiles_id'));
    Notification::assertSentTo($seller, RegisteredSellerNotification::class);
});

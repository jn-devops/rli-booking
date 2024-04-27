<?php

use Illuminate\Foundation\Testing\{RefreshDatabase, WithFaker};
use RLI\Booking\Actions\AssociateContactAction;
use RLI\Booking\Models\{Buyer, Contact};

uses(RefreshDatabase::class, WithFaker::class);

dataset('buyer', function () {
    return [
        [fn () => Buyer::factory()->create()]
    ];
});

dataset('contact', function () {
    return [
        [fn () => Contact::factory()->create()]
    ];
});

test('associate action works', function (Buyer $buyer, Contact $contact) {
    expect($buyer->contact)->toBeNull();
    $action = app(AssociateContactAction::class);
    $buyer = $action->run($buyer, $contact);
    expect($buyer->contact)->toBe($contact);
})->with('buyer', 'contact');

test('associate action end-point works', function (Buyer $buyer, Contact $contact) {
    expect($buyer->contact)->toBeNull();
    $response = $this->post(route('associate-contact', ['buyer' => $buyer->id, 'contact' => $contact->id]));
    $response->assertStatus(302);
    expect($buyer->fresh()->contact->is($contact))->toBeTrue();
})->with('buyer', 'contact');

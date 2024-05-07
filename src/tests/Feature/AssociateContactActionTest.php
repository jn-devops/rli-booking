<?php

use Illuminate\Foundation\Testing\{RefreshDatabase, WithFaker};
use RLI\Booking\Actions\AssociateContactAction;
use RLI\Booking\Events\ContactAssociated;
use RLI\Booking\Models\{Buyer, Contact};
use Illuminate\Support\Facades\Event;

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

test('associate contact action works', function (Buyer $buyer, Contact $contact) {
    Event::fake(ContactAssociated::class);
    expect($buyer->contact)->toBeNull();
    $action = app(AssociateContactAction::class);
    $buyer = $action->run($buyer, $contact);
    expect($buyer->contact)->toBe($contact);
    Event::assertDispatched(ContactAssociated::class, function (ContactAssociated $event) use ($buyer, $contact) {
        return $event->buyer->is($buyer) && $event->buyer->contact->is($contact);
    });
})->with('buyer', 'contact');

test('associate contact action end-point works', function (Buyer $buyer, Contact $contact) {
    expect($buyer->contact)->toBeNull();
    $response = $this->post(route('associate-contact', ['buyer' => $buyer->id, 'contact' => $contact->uid]));
    $response->assertStatus(302);
    expect($buyer->fresh()->contact->is($contact))->toBeTrue();
})->with('buyer', 'contact');

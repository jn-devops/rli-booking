<?php

use Illuminate\Foundation\Testing\{RefreshDatabase, WithFaker};
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use RLI\Booking\Actions\AttachContactMediaAction;
use RLI\Booking\Models\Contact;

uses(RefreshDatabase::class, WithFaker::class);

dataset('contact', function () {
    return [
        [fn () => Contact::factory()->create(['idImage' => null, 'selfieImage' => null, 'payslipImage' => null])]
    ];
});

test('attach contact media action works', function (Contact $contact) {
    $attribs = [
        'idImage' => 'https://jn-img.enclaves.ph/Test/idImage.jpg',
        'selfieImage' => 'https://jn-img.enclaves.ph/Test/selfieImage.jpg',
        'payslipImage' => 'https://jn-img.enclaves.ph/Test/payslipImage.jpg'
    ];

    $contact = app(AttachContactMediaAction::class)->run($contact, $attribs);
    expect($contact->idImage)->toBeInstanceOf(Media::class);
    expect($contact->selfieImage)->toBeInstanceOf(Media::class);
    expect($contact->payslipImage)->toBeInstanceOf(Media::class);
    expect($contact->idImage->name)->toBe('idImage');
    expect($contact->idImage->file_name)->toBe('idImage.jpg');
    expect($contact->selfieImage->name)->toBe('selfieImage');
    expect($contact->selfieImage->file_name)->toBe('selfieImage.jpg');
    expect($contact->payslipImage->name)->toBe('payslipImage');
    expect($contact->payslipImage->file_name)->toBe('payslipImage.jpg');
    $contact->idImage->delete();
    $contact->selfieImage->delete();
    $contact->payslipImage->delete();
    $contact->clearMediaCollection('id-images');
    $contact->clearMediaCollection('selfie-images');
    $contact->clearMediaCollection('payslip-images');
})->with('contact');

test('attach contact media action has an endpoint', function (Contact $contact) {
    $attribs = [
        'idImage' => 'https://jn-img.enclaves.ph/Test/idImage.jpg',
        'selfieImage' => 'https://jn-img.enclaves.ph/Test/selfieImage.jpg',
        'payslipImage' => 'https://jn-img.enclaves.ph/Test/payslipImage.jpg'
    ];
    $response = $this->post(route('attach-contact-media', ['uid' => $contact->uid]), $attribs);
    $response->assertStatus(200);

    expect($contact->idImage)->toBeInstanceOf(Media::class);
    expect($contact->selfieImage)->toBeInstanceOf(Media::class);
    expect($contact->payslipImage)->toBeInstanceOf(Media::class);
    expect($contact->idImage->name)->toBe('idImage');
    expect($contact->idImage->file_name)->toBe('idImage.jpg');
    expect($contact->selfieImage->name)->toBe('selfieImage');
    expect($contact->selfieImage->file_name)->toBe('selfieImage.jpg');
    expect($contact->payslipImage->name)->toBe('payslipImage');
    expect($contact->payslipImage->file_name)->toBe('payslipImage.jpg');
    $contact->idImage->delete();
    $contact->selfieImage->delete();
    $contact->payslipImage->delete();
    $contact->clearMediaCollection('id-images');
    $contact->clearMediaCollection('selfie-images');
    $contact->clearMediaCollection('payslip-images');
})->with('contact');


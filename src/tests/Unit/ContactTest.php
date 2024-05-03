<?php
use Illuminate\Foundation\Testing\{RefreshDatabase, WithFaker};
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use RLI\Booking\Data\{ContactData, ContactEmploymentData, ContactOrderData};
use RLI\Booking\Models\Contact;
use Illuminate\Support\Arr;

uses(RefreshDatabase::class, WithFaker::class);

beforeEach(function() {
    $this->faker = $this->makeFaker('en_PH');
});

test('contact has schema attributes', function () {
    $contact = Contact::factory()->create();
    expect($contact->first_name)->toBeString();
    expect($contact->middle_name)->toBeString();
    expect($contact->last_name)->toBeString();
    expect($contact->civil_status)->toBeString();
    expect($contact->sex)->toBeString();
    expect($contact->nationality)->toBeString();
    expect($contact->date_of_birth)->toBeString();
    expect($contact->email)->toBeString();
    expect($contact->mobile)->toBeString();
    expect($contact->addresses)->toBeArray();
    expect($contact->employment)->toBeArray();
    expect($contact->co_borrowers)->toBeArray();
    expect($contact->order)->toBeArray();
    expect($contact->idImage)->toBeInstanceOf(Media::class);
    expect($contact->selfieImage)->toBeInstanceOf(Media::class);
    expect($contact->payslipImage)->toBeInstanceOf(Media::class);
});

test('contact has data', function () {
    $contact = Contact::factory()->create();
    $data = ContactData::fromModel($contact);
    expect($data->profile->first_name)->toBe($contact->first_name);
    expect($data->profile->middle_name)->toBe($contact->middle_name);
    expect($data->profile->last_name)->toBe($contact->last_name);
    expect($data->profile->civil_status)->toBe($contact->civil_status);
    expect($data->profile->sex)->toBe($contact->sex);
    expect($data->profile->nationality)->toBe($contact->nationality);
    expect($data->profile->date_of_birth)->toBe($contact->date_of_birth);
    expect($data->profile->email)->toBe($contact->email);
    expect($data->profile->mobile)->toBe($contact->mobile);
    if ($contact->spouse) {
        expect($data->spouse->first_name)->toBe($contact->spouse['first_name']);
        expect($data->spouse->middle_name)->toBe($contact->spouse['middle_name']);
        expect($data->spouse->last_name)->toBe($contact->spouse['last_name']);
        expect($data->spouse->civil_status)->toBe($contact->spouse['civil_status']);
        expect($data->spouse->sex)->toBe($contact->spouse['sex']);
        expect($data->spouse->nationality)->toBe($contact->spouse['nationality']);
        expect($data->spouse->date_of_birth)->toBe($contact->spouse['date_of_birth']);
        expect($data->spouse->email)->toBe($contact->spouse['email']);
        expect($data->spouse->mobile)->toBe($contact->spouse['mobile']);
    }
    foreach ($data->addresses->toArray() as $index => $address) {
        expect(array_filter($address))->toBe(array_filter($contact->addresses[$index]));
    }
    expect($data->employment->toArray())->toBe(ContactEmploymentData::from($contact->employment)->toArray());
    foreach ($data->co_borrowers->toArray() as $index => $co_borrower) {
        expect(array_filter($co_borrower))->toBe(array_filter($contact->co_borrowers[$index]));
    };
    expect($data->order->toArray())->toBe(ContactOrderData::from($contact->order)->toArray());
    foreach (array_filter($data->media->toArray()) as $index => $url) {
        expect($contact->$index->getUrl())->toBe($url);
    };
});

test('contact can attach media', function () {
    $idImageUrl = 'https://jn-img.enclaves.ph/Test/idImage.jpg';
    $selfieImageUrl = 'https://jn-img.enclaves.ph/Test/selfieImage.jpg';
    $payslipImageUrl = 'https://jn-img.enclaves.ph/Test/payslipImage.jpg';
    $contact = Contact::factory()->create(['idImage' => null, 'selfieImage' => null, 'payslipImage' => null]);
    $contact->idImage = $idImageUrl;
    $contact->selfieImage = $selfieImageUrl;
    $contact->payslipImage = $payslipImageUrl;
    $contact->save();
    expect($contact->idImage)->toBeInstanceOf(Media::class);
    expect($contact->selfieImage)->toBeInstanceOf(Media::class);
    expect($contact->payslipImage)->toBeInstanceOf(Media::class);
    expect($contact->idImage->name)->toBe('idImage');
    expect($contact->idImage->file_name)->toBe('idImage.jpg');
    expect($contact->payslipImage->file_name)->toBe('payslipImage.jpg');
    expect($contact->idImage->name)->toBe('idImage');
    expect($contact->selfieImage->name)->toBe('selfieImage');
    expect($contact->payslipImage->name)->toBe('payslipImage');
    expect($contact->idImage->file_name)->toBe('idImage.jpg');
    expect($contact->selfieImage->file_name)->toBe('selfieImage.jpg');
    expect($contact->payslipImage->file_name)->toBe('payslipImage.jpg');
    tap(config('app.url'), function ($host) use ($contact) {
        expect($contact->idImage->getUrl())->toBe(__(':host/storage/:path', ['host' => $host, 'path' => $contact->idImage->getPathRelativeToRoot()]));
        expect($contact->selfieImage->getUrl())->toBe(__(':host/storage/:path', ['host' => $host, 'path' => $contact->selfieImage->getPathRelativeToRoot()]));
        expect($contact->payslipImage->getUrl())->toBe(__(':host/storage/:path', ['host' => $host, 'path' => $contact->payslipImage->getPathRelativeToRoot()]));
        $contact->idImage->delete();
    });
    $contact->selfieImage->delete();
    $contact->payslipImage->delete();
    $contact->clearMediaCollection('id-images');
    $contact->clearMediaCollection('selfie-images');
    $contact->clearMediaCollection('payslip-images');
});

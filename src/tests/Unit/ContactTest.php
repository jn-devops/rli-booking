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

dataset('contact', function () {
    return [
        [
            fn () => Contact::factory()->create([
                'idImage' => 'https://jn-img.enclaves.ph/Test/idImage.jpg',
                'selfieImage' => 'https://jn-img.enclaves.ph/Test/selfieImage.jpg',
                'payslipImage' => 'https://jn-img.enclaves.ph/Test/payslipImage.jpg',
                'voluntarySurrenderFormDocument' => 'https://unec.edu.az/application/uploads/2014/12/pdf-sample.pdf',
                'usufructAgreementDocument' => 'https://jn-img.enclaves.ph/Microservices%20Logo/Level%200%20-Book%20Flight_Property.pdf',
                'contractToSellDocument' => 'https://s29.q4cdn.com/175625835/files/doc_downloads/test.pdf',
                'deedOfRestrictionsDocument' => 'https://s29.q4cdn.com/175625835/files/doc_downloads/test.pdf',
                'disclosureDocument' => 'https://s29.q4cdn.com/175625835/files/doc_downloads/test.pdf',
                'borrowerConformityDocument' => 'https://s29.q4cdn.com/175625835/files/doc_downloads/test.pdf',
                'statementOfAccountDocument' => 'https://s29.q4cdn.com/175625835/files/doc_downloads/test.pdf',
                'invoiceDocument' => 'https://s29.q4cdn.com/175625835/files/doc_downloads/test.pdf',
                'receiptDocument' => 'https://s29.q4cdn.com/175625835/files/doc_downloads/test.pdf',
                'deedOfSaleDocument' => 'https://s29.q4cdn.com/175625835/files/doc_downloads/test.pdf',
            ])
        ]
    ];
});

test('contact has schema attributes', function (Contact $contact) {
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
    expect($contact->voluntarySurrenderFormDocument)->toBeInstanceOf(Media::class);
    expect($contact->usufructAgreementDocument)->toBeInstanceOf(Media::class);
    expect($contact->contractToSellDocument)->toBeInstanceOf(Media::class);
    expect($contact->deedOfRestrictionsDocument)->toBeInstanceOf(Media::class);
    expect($contact->disclosureDocument)->toBeInstanceOf(Media::class);
    expect($contact->borrowerConformityDocument)->toBeInstanceOf(Media::class);
    expect($contact->statementOfAccountDocument)->toBeInstanceOf(Media::class);
    expect($contact->invoiceDocument)->toBeInstanceOf(Media::class);
    expect($contact->receiptDocument)->toBeInstanceOf(Media::class);
    expect($contact->deedOfSaleDocument)->toBeInstanceOf(Media::class);
    expect($contact->reference_code)->toBeString();
})->with('contact');

test('contact has data', function (Contact $contact) {
    $data = ContactData::fromModel($contact);
    expect($data->uid)->toBe($contact->uid);
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

    foreach (array_filter($data->uploads->toArray()) as $upload) {
        $name = $upload['name'];
        $url = $upload['url'];
        expect($contact->$name->getUrl())->toBe($url);
    };
    expect($data->uploads->toArray())->toBe($contact->uploads);
    expect($data->reference_code)->toBe($contact->reference_code);
})->with('contact');

test('contact can attach media', function () {
    $idImageUrl = 'https://jn-img.enclaves.ph/Test/idImage.jpg';
    $selfieImageUrl = 'https://jn-img.enclaves.ph/Test/selfieImage.jpg';
    $payslipImageUrl = 'https://jn-img.enclaves.ph/Test/payslipImage.jpg';
    $voluntarySurrenderFormDocument = 'https://unec.edu.az/application/uploads/2014/12/pdf-sample.pdf';
    $usufructAgreementDocument = 'https://jn-img.enclaves.ph/Microservices%20Logo/Level%200%20-Book%20Flight_Property.pdf';
    $contractToSellDocument = 'https://s29.q4cdn.com/175625835/files/doc_downloads/test.pdf';
    $deedOfRestrictionsDocument = 'https://s29.q4cdn.com/175625835/files/doc_downloads/test.pdf';
    $disclosureDocument = 'https://s29.q4cdn.com/175625835/files/doc_downloads/test.pdf';
    $borrowerConformityDocument = 'https://s29.q4cdn.com/175625835/files/doc_downloads/test.pdf';
    $statementOfAccountDocument = 'https://s29.q4cdn.com/175625835/files/doc_downloads/test.pdf';
    $invoiceDocument = 'https://s29.q4cdn.com/175625835/files/doc_downloads/test.pdf';
    $receiptDocument = 'https://s29.q4cdn.com/175625835/files/doc_downloads/test.pdf';
    $deedOfSaleDocument = 'https://s29.q4cdn.com/175625835/files/doc_downloads/test.pdf';
    $contact = Contact::factory()->create([
        'idImage' => null,
        'selfieImage' => null,
        'payslipImage' => null,
        'voluntarySurrenderFormDocument' => null,
        'usufructAgreementDocument' => null,
        'contractToSellDocument' => null,
        'deedOfRestrictionsDocument' => null,
        'disclosureDocument' => null,
        'borrowerConformityDocument' => null,
        'statementOfAccountDocument' => null,
        'invoiceDocument' => null,
        'receiptDocument' => null,
        'deedOfSaleDocument' => null
    ]);
    $contact->idImage = $idImageUrl;
    $contact->selfieImage = $selfieImageUrl;
    $contact->payslipImage = $payslipImageUrl;
    $contact->voluntarySurrenderFormDocument = $voluntarySurrenderFormDocument;
    $contact->usufructAgreementDocument = $usufructAgreementDocument;
    $contact->contractToSellDocument = $contractToSellDocument;
    $contact->deedOfRestrictionsDocument = $deedOfRestrictionsDocument;
    $contact->disclosureDocument = $disclosureDocument;
    $contact->borrowerConformityDocument = $borrowerConformityDocument;
    $contact->statementOfAccountDocument = $statementOfAccountDocument;
    $contact->invoiceDocument = $invoiceDocument;
    $contact->receiptDocument = $receiptDocument;
    $contact->deedOfSaleDocument = $deedOfSaleDocument;

    $contact->save();
    expect($contact->idImage)->toBeInstanceOf(Media::class);
    expect($contact->selfieImage)->toBeInstanceOf(Media::class);
    expect($contact->payslipImage)->toBeInstanceOf(Media::class);
    expect($contact->voluntarySurrenderFormDocument)->toBeInstanceOf(Media::class);
    expect($contact->usufructAgreementDocument)->toBeInstanceOf(Media::class);
    expect($contact->contractToSellDocument)->toBeInstanceOf(Media::class);
    expect($contact->deedOfRestrictionsDocument)->toBeInstanceOf(Media::class);
    expect($contact->disclosureDocument)->toBeInstanceOf(Media::class);
    expect($contact->borrowerConformityDocument)->toBeInstanceOf(Media::class);
    expect($contact->statementOfAccountDocument)->toBeInstanceOf(Media::class);
    expect($contact->invoiceDocument)->toBeInstanceOf(Media::class);
    expect($contact->receiptDocument)->toBeInstanceOf(Media::class);
    expect($contact->deedOfSaleDocument)->toBeInstanceOf(Media::class);
    expect($contact->idImage->name)->toBe('idImage');
    expect($contact->selfieImage->name)->toBe('selfieImage');
    expect($contact->payslipImage->name)->toBe('payslipImage');
    expect($contact->voluntarySurrenderFormDocument->name)->toBe('voluntarySurrenderFormDocument');
    expect($contact->usufructAgreementDocument->name)->toBe('usufructAgreementDocument');
    expect($contact->contractToSellDocument->name)->toBe('contractToSellDocument');
    expect($contact->deedOfRestrictionsDocument->name)->toBe('deedOfRestrictionsDocument');
    expect($contact->disclosureDocument->name)->toBe('disclosureDocument');
    expect($contact->borrowerConformityDocument->name)->toBe('borrowerConformityDocument');
    expect($contact->statementOfAccountDocument->name)->toBe('statementOfAccountDocument');
    expect($contact->invoiceDocument->name)->toBe('invoiceDocument');
    expect($contact->receiptDocument->name)->toBe('receiptDocument');
    expect($contact->deedOfSaleDocument->name)->toBe('deedOfSaleDocument');
    expect($contact->idImage->file_name)->toBe('idImage.jpg');
    expect($contact->selfieImage->file_name)->toBe('selfieImage.jpg');
    expect($contact->payslipImage->file_name)->toBe('payslipImage.jpg');
    expect($contact->voluntarySurrenderFormDocument->file_name)->toBe('pdf-sample.pdf');
    expect($contact->usufructAgreementDocument->file_name)->toBe('Level-0--Book-Flight_Property.pdf');
    expect($contact->contractToSellDocument->file_name)->toBe('test.pdf');
    expect($contact->deedOfRestrictionsDocument->file_name)->toBe('test.pdf');
    expect($contact->disclosureDocument->file_name)->toBe('test.pdf');
    expect($contact->borrowerConformityDocument->file_name)->toBe('test.pdf');
    expect($contact->statementOfAccountDocument->file_name)->toBe('test.pdf');
    expect($contact->invoiceDocument->file_name)->toBe('test.pdf');
    expect($contact->receiptDocument->file_name)->toBe('test.pdf');
    expect($contact->deedOfSaleDocument->file_name)->toBe('test.pdf');
    tap(config('app.url'), function ($host) use ($contact) {
        expect($contact->idImage->getUrl())->toBe(__(':host/storage/:path', ['host' => $host, 'path' => $contact->idImage->getPathRelativeToRoot()]));
        expect($contact->selfieImage->getUrl())->toBe(__(':host/storage/:path', ['host' => $host, 'path' => $contact->selfieImage->getPathRelativeToRoot()]));
        expect($contact->payslipImage->getUrl())->toBe(__(':host/storage/:path', ['host' => $host, 'path' => $contact->payslipImage->getPathRelativeToRoot()]));
        expect($contact->voluntarySurrenderFormDocument->getUrl())->toBe(__(':host/storage/:path', ['host' => $host, 'path' => $contact->voluntarySurrenderFormDocument->getPathRelativeToRoot()]));
        expect($contact->usufructAgreementDocument->getUrl())->toBe(__(':host/storage/:path', ['host' => $host, 'path' => $contact->usufructAgreementDocument->getPathRelativeToRoot()]));
        expect($contact->contractToSellDocument->getUrl())->toBe(__(':host/storage/:path', ['host' => $host, 'path' => $contact->contractToSellDocument->getPathRelativeToRoot()]));
        expect($contact->deedOfRestrictionsDocument->getUrl())->toBe(__(':host/storage/:path', ['host' => $host, 'path' => $contact->deedOfRestrictionsDocument->getPathRelativeToRoot()]));
        expect($contact->disclosureDocument->getUrl())->toBe(__(':host/storage/:path', ['host' => $host, 'path' => $contact->disclosureDocument->getPathRelativeToRoot()]));
        expect($contact->borrowerConformityDocument->getUrl())->toBe(__(':host/storage/:path', ['host' => $host, 'path' => $contact->borrowerConformityDocument->getPathRelativeToRoot()]));
        expect($contact->statementOfAccountDocument->getUrl())->toBe(__(':host/storage/:path', ['host' => $host, 'path' => $contact->statementOfAccountDocument->getPathRelativeToRoot()]));
        expect($contact->invoiceDocument->getUrl())->toBe(__(':host/storage/:path', ['host' => $host, 'path' => $contact->invoiceDocument->getPathRelativeToRoot()]));
        expect($contact->receiptDocument->getUrl())->toBe(__(':host/storage/:path', ['host' => $host, 'path' => $contact->receiptDocument->getPathRelativeToRoot()]));
        expect($contact->deedOfSaleDocument->getUrl())->toBe(__(':host/storage/:path', ['host' => $host, 'path' => $contact->deedOfSaleDocument->getPathRelativeToRoot()]));
    });
    $contact->idImage->delete();
    $contact->selfieImage->delete();
    $contact->payslipImage->delete();
    $contact->voluntarySurrenderFormDocument->delete();
    $contact->usufructAgreementDocument->delete();
    $contact->contractToSellDocument->delete();
    $contact->deedOfRestrictionsDocument->delete();
    $contact->disclosureDocument->delete();
    $contact->borrowerConformityDocument->delete();
    $contact->statementOfAccountDocument->delete();
    $contact->invoiceDocument->delete();
    $contact->receiptDocument->delete();
    $contact->deedOfSaleDocument->delete();
    $contact->clearMediaCollection('id-images');
    $contact->clearMediaCollection('selfie-images');
    $contact->clearMediaCollection('payslip-images');
    $contact->clearMediaCollection('voluntary_surrender_form-documents');
    $contact->clearMediaCollection('usufruct_agreement-documents');
    $contact->clearMediaCollection('contract_to_sell-documents');
    $contact->clearMediaCollection('deed_of_restrictions-documents');
    $contact->clearMediaCollection('disclosure-documents');
    $contact->clearMediaCollection('borrower_conformity-documents');
    $contact->clearMediaCollection('statement_of_account-documents');
    $contact->clearMediaCollection('invoice-documents');
    $contact->clearMediaCollection('receipt-documents');
    $contact->clearMediaCollection('deed_of_sale-documents');
});

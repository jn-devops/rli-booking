<?php

use RLI\Booking\Models\{Contact, Inventory, Order, Seller, SellerCommission, Voucher};
use Illuminate\Foundation\Testing\{RefreshDatabase, WithFaker};
use RLI\Booking\Classes\State\UpdatedPendingProcessing;
use RLI\Booking\Actions\EarmarkContactAction;
use RLI\Booking\Data\FinancialSchemeData;

uses(RefreshDatabase::class, WithFaker::class);

beforeEach(function() {
    $this->faker = $this->makeFaker('en_PH');
});

dataset('contact', function () {
    return [
        fn() => Contact::factory()->create([
            'idImage' => null,
            'selfieImage' => null,
            'payslipImage' => null,
            'voluntarySurrenderFormDocument' => null,
            'usufructAgreementDocument' => null,
            'contractToSellDocument' => null,
        ])
    ];
});

dataset('inventory', function () {
    return [
        fn() => Inventory::factory()->create()
    ];
});

dataset('seller', function () {
    return [
        fn() => Seller::factory()->create()
    ];
});

dataset('seller_commission', function () {
    return [
        fn() => SellerCommission::factory()->create()
    ];
});

dataset('financial scheme', function () {
    return [
        fn() => new FinancialSchemeData(dp_percent: 10, dp_months: 12)
    ];
});

test('earmark contact action', function (Contact $contact, Inventory $inventory, Seller $seller, SellerCommission $sellerCommission, FinancialSchemeData $financialSchemeData) {
    $voucher = EarmarkContactAction::run(...func_get_args());
    expect($voucher)->toBeInstanceOf(Voucher::class);
    tap($voucher->getOrder(), function (Order $order) use ($inventory, $seller, $sellerCommission, $financialSchemeData) {
        expect($order->state)->toBeInstanceOf(UpdatedPendingProcessing::class);
        expect($order->property_code)->toBe($inventory->property_code);
        expect((int) ($order->dp_percent - $financialSchemeData->dp_percent))->toBe(0 );
        expect((int) ($order->dp_months - $financialSchemeData->dp_months))->toBe(0);
        expect($order->seller->is($seller))->toBeTrue();
        expect($order->sellerCommission->is($sellerCommission))->toBeTrue();
    });
    tap($voucher->getContact(), function (Contact $orderContact) use ($contact, $voucher) {
        expect($orderContact->is($contact))->toBeTrue();
        expect($orderContact->reference_code)->toBe($voucher->code);
    });
})->with('contact', 'inventory', 'seller', 'seller_commission', 'financial scheme');

test('earmark contact end points', function (Contact $contact, Inventory $inventory, Seller $seller, SellerCommission $sellerCommission, FinancialSchemeData $financialSchemeData) {
    $attribs = [
        'contact_uid' => $contact->uid,
        'property_code' => $inventory->property_code,
        'seller_email' => $seller->email,
        'seller_commission_code' => $sellerCommission->code, //must exist in seller commissions
        'dp_percent' => $financialSchemeData->dp_percent,
        'dp_months' => $financialSchemeData->dp_months,
    ];
    $response = $this->actingAs($seller)->post(route('onboard-contact'), $attribs);
    $response->assertStatus(302);
    $params = $response->getSession()->get('params');
    $voucher = Voucher::where('code', $params['voucher'])->first();
    tap($voucher->getOrder(), function (Order $order) use ($inventory, $seller, $sellerCommission, $financialSchemeData) {
        expect($order->state)->toBeInstanceOf(UpdatedPendingProcessing::class);
        expect($order->property_code)->toBe($inventory->property_code);
        expect((int) ($order->dp_percent - $financialSchemeData->dp_percent))->toBe(0 );
        expect((int) ($order->dp_months - $financialSchemeData->dp_months))->toBe(0);
        expect($order->seller->is($seller))->toBeTrue();
        expect($order->sellerCommission->is($sellerCommission))->toBeTrue();
    });
    tap($voucher->getContact(), function (Contact $orderContact) use ($contact, $voucher) {
        expect($orderContact->is($contact))->toBeTrue();
        expect($orderContact->reference_code)->toBe($voucher->code);
    });
    expect($response->getTargetUrl())->toBe(route('references.show', ['voucher' => $voucher->code]));
})->with('contact', 'inventory', 'seller', 'seller_commission', 'financial scheme');

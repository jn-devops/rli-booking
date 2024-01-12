<?php

use Illuminate\Foundation\Testing\{RefreshDatabase, WithFaker};
use FrittenKeeZ\Vouchers\Facades\Vouchers;
use RLI\Booking\Models\{Buyer, Order};
use Carbon\CarbonInterval;
use App\Models\User;

uses(RefreshDatabase::class, WithFaker::class);

beforeEach(function() {
    $this->faker = $this->makeFaker('en_PH');
});

test('voucher has a prefix, mask, owner, related entity, metadata and expiry', function () {
    $prefix = 'jn';
    $mask = '***-***-***';
    $expiry = CarbonInterval::create('P30D');
    $seller = User::factory()->create();
    $order = Order::factory()->create();
    $metadata = [
        'discount' => 10
    ];
    $voucher = Vouchers::withPrefix($prefix)
        ->withMask($mask)
        ->withOwner($seller)
        ->withEntities($order)
        ->withMetadata($metadata)
        ->withExpireDateIn($expiry)
        ->create();

    $code = $voucher->code;
    $buyer = Buyer::factory()->create();
    $success = false;
    try {
        $success = Vouchers::redeem($code, $buyer, ['foo' => 'bar']);
    } catch (FrittenKeeZ\Vouchers\Exceptions\VoucherNotFoundException $e) {
        // Code provided did not match any vouchers in the database.
    } catch (FrittenKeeZ\Vouchers\Exceptions\VoucherAlreadyRedeemedException $e) {
        // Voucher has already been redeemed.
    }
    expect($success)->toBeTrue();
    expect($voucher->owner)->toBe($seller);
    expect($voucher->voucherEntities->first()->entity)->toBeInstanceOf(Order::class);
    expect($voucher->voucherEntities->first()->entity->id)->toBe($order->id);
    expect($voucher->metadata)->toBe($metadata);

    $success = false;
    try {
        $success = Vouchers::redeem($code, $buyer, ['foo' => 'bar']);
    } catch (FrittenKeeZ\Vouchers\Exceptions\VoucherNotFoundException $e) {
        // Code provided did not match any vouchers in the database.
    } catch (FrittenKeeZ\Vouchers\Exceptions\VoucherAlreadyRedeemedException $e) {
        // Voucher has already been redeemed.
    }

    expect($success)->toBeFalse();
});

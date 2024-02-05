<?php

namespace RLI\Booking\Actions;

use RLI\Booking\Classes\State\ExternallyPopulatedPendingUpdate;
use Lorisleiva\Actions\Concerns\AsAction;
use RLI\Booking\Models\Voucher;

class AffiliateReserveAction
{
    use AsAction;

    public function handle(string $email, string $sku, string $property_code = null): Voucher
    {
        $attribs = compact('email', 'sku', 'property_code');

        return tap(GenerateVoucherAction::run($attribs), function ($voucher) {
            $order = $voucher->getOrder();
            $order->state->transitionTo(ExternallyPopulatedPendingUpdate::class);
        });
    }

    public function asController(string $sku, string $email, string $property_code = null): \Illuminate\Http\RedirectResponse
    {
        $voucher = $this->handle($sku, $email, $property_code);
        $order = $voucher->getOrder();

        return redirect()->route('edit-order', [
            'voucher' => $voucher->code,
            'order' => $order->id
        ]);
    }
}

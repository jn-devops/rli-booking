<?php

namespace RLI\Booking\Actions;

use RLI\Booking\Classes\State\ExternallyPopulatedPendingUpdate;
use Lorisleiva\Actions\Concerns\AsAction;
use RLI\Booking\Models\Voucher;

class AutoReserveAction
{
    use AsAction;

    public function handle(string $sku, string $transaction_id): Voucher
    {
        $attribs = compact('sku', 'transaction_id');

        return tap(GenerateVoucherAction::run($attribs), function ($voucher) {
            $order = $voucher->getOrder();
            $order->state->transitionTo(ExternallyPopulatedPendingUpdate::class);
        });
    }

    public function asController(string $sku, string $transaction_id): \Illuminate\Http\RedirectResponse
    {
        $voucher = $this->handle($sku, $transaction_id);
        $order = $voucher->getOrder();

        return redirect()->route('edit-order', [
            'voucher' => $voucher->code,
            'order' => $order->id
        ])->withHeaders(['X-Frame-Options' => 'ALLOW FROM *']);
    }
}

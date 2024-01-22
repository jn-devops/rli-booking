<?php

namespace RLI\Booking\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use RLI\Booking\Models\Voucher;

class AutoReserveAction
{
    use AsAction;

    public function handle(string $sku, string $transaction_id): Voucher
    {
        $attribs = compact('sku', 'transaction_id');

        return GenerateVoucherAction::run($attribs);
    }

    public function asController(string $sku, string $transaction_id): \Illuminate\Http\RedirectResponse
    {
        $voucher = $this->handle($sku, $transaction_id);
        $order = $voucher->getOrder();

        return redirect()->route('edit-order', [
            'voucher' => $voucher->code,
            'order' => $order->id
        ]);
    }
}

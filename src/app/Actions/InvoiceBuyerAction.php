<?php

namespace RLI\Booking\Actions;

use RLI\Booking\Notifications\InvoiceBuyerNotification;
use RLI\Booking\Classes\State\InvoicedPendingPayment;
use RLI\Booking\Events\PaymentDetailsAcquired;
use Lorisleiva\Actions\Concerns\AsAction;
use RLI\Booking\Events\BuyerInvoiced;
use Illuminate\Support\Facades\Http;
use RLI\Booking\Models\Voucher;

class InvoiceBuyerAction
{
    use AsAction;

    public function handle(Voucher $voucher): string
    {
        $order = $voucher->getOrder();
        $invoiceFilePath = $this->generateInvoice($voucher);
        $order->buyer->notify(new InvoiceBuyerNotification($voucher, $invoiceFilePath));
        $order->state->transitionTo(InvoicedPendingPayment::class);
        BuyerInvoiced::dispatch($voucher);

        return $invoiceFilePath;
    }

    /**
     * @param PaymentDetailsAcquired $event
     * @return void
     */
    public function asListener(PaymentDetailsAcquired $event): void
    {
        $this->handle($event->voucher);
    }

    protected function generateInvoice(Voucher $voucher): string
    {
        $response = Http::post('https://eolhdxkbhybdspj.m.pipedream.net/', [
            'voucher' => $voucher->toData(),
        ]);

        return $response->body();
    }

}

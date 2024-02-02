<?php

namespace RLI\Booking\Actions;

use RLI\Booking\Notifications\OrderConfirmedNotification;
use RLI\Booking\Classes\State\ConfirmedPendingInvoice;
use Lorisleiva\Actions\Concerns\AsAction;
use RLI\Booking\Events\BuyerProcessed;
use RLI\Booking\Models\Voucher;

class ConfirmOrderAction
{
    use AsAction;

    public function handle(Voucher $voucher): void
    {
        $order = $voucher->getOrder();
        $order->notify(new OrderConfirmedNotification($voucher));
        $order->state->transitionTo(ConfirmedPendingInvoice::class);
    }

    /**
     * @param BuyerProcessed $event
     * @return void
     */
    public function asListener(BuyerProcessed $event): void
    {
        $this->handle($event->voucher);
    }
}

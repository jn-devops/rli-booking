<?php

namespace RLI\Booking\Actions;

use RLI\Booking\Notifications\OrderConfirmedNotification;
use RLI\Booking\Classes\State\ConfirmedPendingInvoice;
use Lorisleiva\Actions\Concerns\AsAction;
use RLI\Booking\Events\BuyerProcessed;
use RLI\Booking\Models\Order;

class ConfirmOrderAction
{
    use AsAction;

    /**
     * @param Order $order
     * @return void
     */
    public function handle(Order $order): void
    {
        $order->notify(new OrderConfirmedNotification);
        $order->state->transitionTo(ConfirmedPendingInvoice::class);
    }

    /**
     * @param BuyerProcessed $event
     * @return void
     */
    public function asListener(BuyerProcessed $event): void
    {
        $order = $event->voucher->getOrder();

        $this->handle($order);
    }
}

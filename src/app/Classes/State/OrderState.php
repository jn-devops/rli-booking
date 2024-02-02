<?php

namespace RLI\Booking\Classes\State;

use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;

abstract class OrderState extends State
{
    abstract public function color(): string;

    public static function config(): StateConfig
    {
        return parent::config()
            ->default(CreatedPendingUpdate::class)
            ->allowTransition(CreatedPendingUpdate::class, UpdatedPendingConfirmation::class)
            ->allowTransition(UpdatedPendingConfirmation::class, ConfirmedPendingInvoice::class)
            ->allowTransition(ConfirmedPendingInvoice::class, InvoicedPendingPayment::class)
            ->allowTransition(InvoicedPendingPayment::class, PaidPendingFulfillment::class)
            ->allowTransition(PaidPendingFulfillment::class, Fulfilled::class)

            ->allowTransition(CreatedPendingUpdate::class, Abandoned::class)
            ->allowTransition(UpdatedPendingConfirmation::class, Abandoned::class)
            ->allowTransition(ConfirmedPendingInvoice::class, Abandoned::class)
            ->allowTransition(InvoicedPendingPayment::class, Abandoned::class)
            ;
    }
}

<?php

namespace RLI\Booking\Classes\State;

use Spatie\ModelStates\StateConfig;
use Spatie\ModelStates\State;

abstract class OrderState extends State
{
    abstract public function color(): string;

    public static function config(): StateConfig
    {
        return parent::config()
            ->default(InternallyCreatedPendingUpdate::class)
            ->allowTransition(InternallyCreatedPendingUpdate::class, ExternallyPopulatedPendingUpdate::class)
            ->allowTransition(InternallyCreatedPendingUpdate::class, UpdatedPendingProcessing::class)
            ->allowTransition(ExternallyPopulatedPendingUpdate::class, UpdatedPendingProcessing::class)
            ->allowTransition(UpdatedPendingProcessing::class, ProcessedPendingConfirmation::class)
            ->allowTransition(ProcessedPendingConfirmation::class, ConfirmedPendingInvoice::class)
            ->allowTransition(ConfirmedPendingInvoice::class, InvoicedPendingPayment::class)
            ->allowTransition(InvoicedPendingPayment::class, PaidPendingFulfillment::class)
            ->allowTransition(PaidPendingFulfillment::class, Fulfilled::class)

            ->allowTransition(InternallyCreatedPendingUpdate::class, Abandoned::class)
            ->allowTransition(ExternallyPopulatedPendingUpdate::class, Abandoned::class)
            ->allowTransition(UpdatedPendingProcessing::class, Abandoned::class)
            ->allowTransition(ProcessedPendingConfirmation::class, Abandoned::class)
            ->allowTransition(ConfirmedPendingInvoice::class, Abandoned::class)
            ->allowTransition(InvoicedPendingPayment::class, Abandoned::class)
            ;
    }
}

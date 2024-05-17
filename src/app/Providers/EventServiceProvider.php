<?php

namespace RLI\Booking\Providers;

use RLI\Booking\Actions\{AssociateContactAction, ConfirmOrderAction, InvoiceBuyerAction};
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use RLI\Booking\Events\{BuyerProcessed, ContactPersisted, PaymentDetailsAcquired};
use RLI\Booking\Observers\SellerObserver;
use Illuminate\Support\Facades\Event;
use RLI\Booking\Models\Seller;

class EventServiceProvider extends ServiceProvider
{
    /**
     * TODO: refactor the event listeners when they reach to 3
     *
     * @return void
     */
    public function boot(): void
    {
        parent::boot();
        Event::listen(BuyerProcessed::class, ConfirmOrderAction::class);
        Event::listen(PaymentDetailsAcquired::class, InvoiceBuyerAction::class);
        Event::listen(ContactPersisted::class, AssociateContactAction::class);
        Seller::observe(SellerObserver::class);
    }
}

<?php

namespace RLI\Booking\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use RLI\Booking\Actions\ConfirmOrderAction;
use Illuminate\Support\Facades\Event;
use RLI\Booking\Events\BuyerProcessed;

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
    }
}

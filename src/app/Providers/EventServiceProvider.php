<?php

namespace RLI\Booking\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use RLI\Booking\Actions\ConfirmOrderAction;
use RLI\Booking\Events\BuyerProcessed;

class EventServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        parent::boot();
        Event::listen(BuyerProcessed::class, ConfirmOrderAction::class);
    }
}

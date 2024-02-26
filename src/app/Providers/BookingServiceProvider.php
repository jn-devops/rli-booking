<?php

namespace RLI\Booking\Providers;

use Lorisleiva\Actions\Facades\Actions;
use Illuminate\Support\ServiceProvider;
use RLI\Booking\Classes\Bitly;

class BookingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(base_path('src/config.php'), 'booking');
        $this->app->register(EventServiceProvider::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom([
            'src/database/migrations'
        ]);
        if ($this->app->runningInConsole()) {
            Actions::registerCommands('src/app/Actions');
        }
        Bitly::$client_token = config('booking.bitly.client.token');
        Bitly::$client_group_guid = config('booking.bitly.client.group_guid');
        Bitly::$client_domain = config('booking.bitly.client.domain');
    }
}

<?php

namespace RLI\Booking\Providers;

use Lorisleiva\Actions\Facades\Actions;
use Illuminate\Support\ServiceProvider;

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
    }
}

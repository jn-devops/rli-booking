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
        Actions::registerRoutes('src/app/Actions');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom([
            'src/database/migrations'
        ]);
    }
}

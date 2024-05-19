<?php

namespace RLI\Booking\Providers;

use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Lorisleiva\Actions\Facades\Actions;
use Illuminate\Support\ServiceProvider;
use RLI\Booking\Classes\Bitly;
use Illuminate\Support\Str;

class BookingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(base_path('src/config.php'), 'booking');
        $this->app->register(EventServiceProvider::class);
        $this->extendImportFormattingHeaders();
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

    protected function extendImportFormattingHeaders(): void
    {
        HeadingRowFormatter::extend('cornerstone-inventory-1', function($value, $key) {
            $heading = Str::snake(Str::camel($value));
            return match ($heading) {
                'property_i_d' => 'property_id',
                't_c_p' => 'tcp',
                't_s_p' => 'tsp',
                'v_a_t' => 'vat',
                't_s_p_baseline' => 'tsp_baseline',
                'a/_c_provision' => 'ac_provision',
                'custom_complete_price_a_d_d_o_n_s' => 'custom_complete_price_add_ons',
                'custom_bare_price_h_o_u_s_e_p_r_i_c_e' => 'custom_bare_price_house_price',
                'lot_selling_price_per_square_meter_b_a_s_e_l_o_t' => 'lot_selling_price_per_square_meter_base_lot',
                'total_house_price_h_o_u_s_e_p_r_i_c_e(same_with_column_s)' => 'total_house_price_same_with_columns)',
                default  => $heading,
            };
        });
    }
}

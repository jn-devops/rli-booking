<?php

namespace RLI\Booking\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class PercentDownPaymentSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('percent_down_payments')->insert([
            [
                'code' => 'SC',
                'name' => 'Spot Cash',
                'percent' => 0,
            ],
            [
                'code' => 'FP',
                'name' => '5 Percent',
                'percent' => 0.05,
            ],
        ]);
    }
}

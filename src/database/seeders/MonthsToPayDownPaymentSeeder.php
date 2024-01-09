<?php

namespace RLI\Booking\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class MonthsToPayDownPaymentSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('months_to_pay_down_payments')->insert([
            [
                'code' => 'SC',
                'name' => 'Spot Cash',
                'months' => 0,
            ],
            [
                'code' => 'SMTP',
                'name' => 'Six Months to Pay',
                'months' => 6,
            ],
        ]);
    }
}

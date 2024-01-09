<?php

namespace RLI\Booking\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class SellerSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('sellers')->insert([
            [
                'code' => 'SELLER-01',
                'name' => 'James Martin',
                'email' => 'james.martin@yahoo.com',
                'mobile' => '09161111111'
            ],
            [
                'code' => 'SELLER-02',
                'name' => 'Joyce Jimenez',
                'email' => 'joyce.jimenez@google.com',
                'mobile' => '09232222222'
            ],
        ]);
    }
}

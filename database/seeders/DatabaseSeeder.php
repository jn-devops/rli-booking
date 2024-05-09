<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use RLI\Booking\Seeders\SellerCommissionSeeder;
use RLI\Booking\Seeders\ProductSeeder;
use RLI\Booking\Seeders\UserSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call( SellerCommissionSeeder::class);
    }
}

<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use RLI\Booking\Seeders\BuyerSeeder;
use RLI\Booking\Seeders\ContactSeeder;
use RLI\Booking\Seeders\ProductSeeder;
use RLI\Booking\Seeders\UserSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(ContactSeeder::class);
    }
}

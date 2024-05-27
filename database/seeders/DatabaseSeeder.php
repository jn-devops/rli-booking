<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use RLI\Booking\Seeders\OSReportSeeder;
use RLI\Booking\Seeders\SellerCommissionSeeder;
use RLI\Booking\Seeders\PermissionSeeder;
use RLI\Booking\Seeders\InventorySeeder;
use RLI\Booking\Seeders\ProductSeeder;
use RLI\Booking\Seeders\RoleSeeder;
use RLI\Booking\Seeders\UserSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(PermissionSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call( SellerCommissionSeeder::class);
        $this->call( InventorySeeder::class);
        $this->call( OSReportSeeder::class);
    }
}

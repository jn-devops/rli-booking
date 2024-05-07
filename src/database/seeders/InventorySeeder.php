<?php

namespace RLI\Booking\Seeders;

use RLI\Booking\Models\Inventory;
use Illuminate\Database\Seeder;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Inventory::factory(20)->create();
    }
}

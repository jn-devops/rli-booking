<?php

namespace RLI\Booking\Seeders;

use RLI\Booking\Imports\Cornerstone\InventoriesImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\Seeder;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        tap(documents_path('test_cornerstone_inventories.xlsx'), function ($path) {
            if (file_exists($path)) Excel::import(new InventoriesImport, $path);
        });
    }
}

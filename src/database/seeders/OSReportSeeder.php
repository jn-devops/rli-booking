<?php

namespace RLI\Booking\Seeders;

use RLI\Booking\Imports\Cornerstone\OSReportsImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\Seeder;

class OSReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        tap(documents_path('test_cornerstone_os_report.xlsx'), function ($path) {
            if (file_exists($path)) Excel::import(new OSReportsImport, $path);
        });
    }
}

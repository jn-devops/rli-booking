<?php

namespace RLI\Booking\Seeders;

use RLI\Booking\Actions\UploadProductsAction;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $path = documents_path('bulk_upload.xlsx');
        UploadProductsAction::run($path);
    }
}

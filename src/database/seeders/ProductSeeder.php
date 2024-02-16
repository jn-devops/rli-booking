<?php

namespace RLI\Booking\Seeders;

use RLI\Booking\Actions\UploadProductsAction;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        tap(documents_path('bulk_upload.xlsx'), function ($path) {
            if (file_exists($path)) UploadProductsAction::run($path);
        });
    }
}

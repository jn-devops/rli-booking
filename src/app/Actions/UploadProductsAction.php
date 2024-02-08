<?php

namespace RLI\Booking\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use RLI\Booking\Imports\ProductsImport;
use Maatwebsite\Excel\Facades\Excel;


class UploadProductsAction
{
    use AsAction;

    public function handle(string $path)
    {
        Excel::import(new ProductsImport, documents_path('bulk_upload.xlsx'));
    }
}

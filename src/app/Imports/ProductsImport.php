<?php

namespace RLI\Booking\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ProductsImport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new ProductSKUsSheetImport()
        ];
    }
}

<?php

namespace RLI\Booking\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ProductsImport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            'Product SKUs' => new ProductSKUsSheetImport(),
            'Inventory' => new InventorySheetImport(),
            'Digital Assets' => new DigitalAssetsSheetImport()
        ];
    }
}

<?php

namespace RLI\Booking\Imports;

use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\ToModel;
use RLI\Booking\Models\Product;

class ProductSKUsSheetImport implements ToModel, WithHeadingRow, WithUpserts
{
    public function model(array $row): Product
    {
        return new Product([
            'sku' => $row['sku'],
            'name' => $row['name'],
            'processing_fee' => $row['processing_fee'] ?: 0 ,
        ]);
    }

    public function uniqueBy(): string
    {
        return 'sku';
    }
}

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
            'type' => $row['type'],
            'name' => $row['name'],
            'processing_fee' => $row['processing_fee'] ?: 0 ,
            'category' => $row['category'],
            'status' => $row['status'],
            'brand' => $row['brand'],
            'price' => $row['price'] ?: 0 ,
            'location' => $row['location'],
            'floor_area' => $row['floor_area'] ?: 0 ,
            'lot_area' => $row['lot_area'] ?: 0 ,
            'unit_type' => $row['unit_type'],
        ]);
    }

    public function uniqueBy(): string
    {
        return 'sku';
    }
}

<?php

namespace RLI\Booking\Imports;

use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\ToModel;
use RLI\Booking\Models\Product;

class InventorySheetImport implements ToModel, WithHeadingRow, WithUpserts
{
    public function model(array $row): ?Product
    {
        $sku = $row['sku'];
        return tap(Product::where('sku', $sku)->first(), function (Product $product) use ($row) {
            $inventory_json = $row['product_codes'];
            $inventory = json_decode($inventory_json, false);
            $product->inventory = $inventory;
            $product->save();
        });
    }

    public function uniqueBy(): string
    {
        return 'sku';
    }
}

<?php

namespace RLI\Booking\Imports;

use Maatwebsite\Excel\Concerns\WithHeadingRow;
use RLI\Booking\Models\{Inventory, Product};
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\ToModel;

class InventorySheetImport implements ToModel, WithHeadingRow, WithUpserts
{
    public function model(array $row): ?Product
    {
        $sku = $row['sku'];
        return tap(Product::where('sku', $sku)->first(), function (Product $product) use ($row) {
            $inventory_json = $row['product_codes'];
            $inventory = json_decode($inventory_json, false);
            $product->inventory = $inventory;

            $inv = [];
            foreach (array_unique($inventory) as $value) {
//                $inv [] = ['property_code' => $value];
                try {
                    $product->inventories()->updateOrCreate(['property_code' => $value]);
                }
                catch (\Exception $exception) {

                }

            }

//            $product->inventories()->createMany($inv);
            $product->save();
        });
    }

    public function uniqueBy(): string
    {
        return 'sku';
    }
}

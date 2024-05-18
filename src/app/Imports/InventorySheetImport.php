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
        return tap(Product::where('sku', $sku)->first(), function (Product $product) use ($row, $sku) {
            $inventory_json = $row['product_codes'];
            $inventory_array = json_decode($inventory_json, false);

            $product->inventory = $inventory_array;//TODO: deprecate

            $non_unique_property_codes = [];
            foreach (array_unique($inventory_array) as $property_code) {
                $inventory =  new Inventory([
                    'sku' => $sku,
                    'property_code' => $property_code
                ]);
                try {
                    $product->inventories()->save($inventory);
                }
                catch (\Exception $exception) {
                    $non_unique_property_codes [] = $property_code;
                }
            }
            $product->save();
            if (count($non_unique_property_codes)>0) {
                logger('InventorySheetImport non-unique property codes');
                logger($non_unique_property_codes);
            }
        });
    }

    public function uniqueBy(): string
    {
        return 'sku';
    }
}

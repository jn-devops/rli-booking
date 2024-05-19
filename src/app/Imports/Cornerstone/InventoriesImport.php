<?php

namespace RLI\Booking\Imports\Cornerstone;

use Maatwebsite\Excel\Concerns\WithGroupedHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use RLI\Booking\Transformers\InventoryTransformer;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use RLI\Booking\Models\{Inventory, Product};
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\ToModel;
use Spatie\Fractalistic\Fractal;
use Illuminate\Support\Str;

HeadingRowFormatter::default('cornerstone-inventory-1');

class InventoriesImport implements ToModel, WithHeadingRow, WithUpserts, WithGroupedHeadingRow
{
    public function model(array $row): Inventory
    {
        $meta = Fractal::create()
            ->item($row)->transformWith(new InventoryTransformer)
            ->toArray();
        $project_code = $meta['data']['project_code'];
        $brand = config('booking.defaults.product.auto')[$project_code]['brand'];
        $unit_type = str_replace('W/', 'w/', Str::title($meta['data']['unit_type'][0]));
        $lot_area = $meta['data']['lot_area'];
        $floor_area = $meta['data']['floor_area'];
        $location = config('booking.defaults.product.auto')[$project_code]['location'];
        $product = app(Product::class)->firstOrCreate(['sku' => $meta['data']['sku']],[
            'type' => 'stand-alone',
            'name' => $brand . ' ' . $location . ' ' . $unit_type . ' ' . 'L' . $lot_area . ' ' . 'F' . $floor_area,
            'processing_fee' => config('booking.defaults.product.processing_fee'),
            'category' => config('booking.defaults.product.auto')[$project_code]['category'],
            'status' => 1,
            'brand' => $brand,
            'price' =>  $meta['data']['tcp'],
            'location' => $location,
            'floor_area' => $floor_area,
            'lot_area' => $lot_area,
            'unit_type' => $unit_type,
        ]);

//        $inventory = new Inventory([
//            'sku' =>  $product?->sku,
//            'property_code' => $row['property_code'],
//            'meta' => $meta,
//        ]);

        $inventory = app(Inventory::class)->firstOrNew([
            'property_code' => $row['property_code'],
        ], [
            'sku' =>  $product?->sku,
            'meta' => $meta,
        ]);

        $inventory->reserved = $row['property_status'] == 'RESERVED';
        $inventory->sold = $row['property_status'] == 'SOLD';

        return $inventory;
    }

    public function uniqueBy(): string
    {
        return 'property_code';
    }
}

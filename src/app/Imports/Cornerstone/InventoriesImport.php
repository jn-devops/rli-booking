<?php

namespace RLI\Booking\Imports\Cornerstone;

use Maatwebsite\Excel\Concerns\{ToModel, WithHeadingRow, WithUpserts};
use Maatwebsite\Excel\Concerns\WithGroupedHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use RLI\Booking\Transformers\InventoryTransformer;
use RLI\Booking\Actions\BuildProductAction;
use RLI\Booking\Models\Inventory;
use Spatie\Fractalistic\Fractal;
use Illuminate\Support\Str;

HeadingRowFormatter::default('cornerstone-inventory-1');

class InventoriesImport implements ToModel, WithHeadingRow, WithUpserts, WithGroupedHeadingRow
{
    public function model(array $row): ?Inventory
    {
        if (!isset($row['project_code'])) {
            return null;
        }
        $meta = Fractal::create()
            ->item($row)->transformWith(new InventoryTransformer)
            ->toArray();
        $project_code = $meta['data']['project_code'];
        $total_contract_price = $meta['data']['tcp'];
        $lot_area = $meta['data']['lot_area'];
        $floor_area = $meta['data']['floor_area'];
        $unit_type = str_replace('W/', 'w/', Str::title($meta['data']['unit_type'][0]));
        $product = app(BuildProductAction::class)
            ->run($project_code, $total_contract_price, $lot_area, $floor_area, $unit_type);
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

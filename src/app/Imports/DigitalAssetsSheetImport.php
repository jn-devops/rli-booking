<?php

namespace RLI\Booking\Imports;

use Maatwebsite\Excel\Concerns\{ToModel, WithHeadingRow, WithUpserts};
use RLI\Booking\Models\Product;

class DigitalAssetsSheetImport implements ToModel, WithHeadingRow, WithUpserts
{
    public function model(array $row): ?Product
    {
        if (!isset($row['sku'])) return null;
        $sku = $row['sku'];
        return tap(Product::where('sku', $sku)->first(), function (Product $product) use ($row) {
            $url_links_json = $row['url_links'];
            $url_links = json_decode($url_links_json, true);
            $product->url_links = $url_links;
            $product->save();
        });
    }

    public function uniqueBy(): string
    {
        return 'sku';
    }
}

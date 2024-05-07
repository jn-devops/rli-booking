<?php

namespace RLI\Booking\Data;

use Spatie\LaravelData\{Data, DataCollection, Optional};
use RLI\Booking\Models\Product;

class ProductData extends Data
{

    public function __construct(
        public string $sku,
        public string $type,
        public string $name,
        public int    $processing_fee,
        public string $category,
        public bool   $status,
        public string $unit_type,
        public string $brand,
        public int    $price,
        public string $location,
        public int    $floor_area,
        public int    $lot_area,
        /** @var InventoryData[] */
        public DataCollection|Optional $inventories,
    ) {}

    public static function fromModel(Product $product): self
    {
        return new self (
            sku: $product->sku,
            type: $product->type,
            name: $product->name,
            processing_fee: $product->processing_fee,
            category: $product->category,
            status: $product->status,
            unit_type: $product->unit_type,
            brand: $product->brand,
            price: $product->price,
            location: $product->location,
            floor_area: $product->floor_area,
            lot_area: $product->lot_area,
            inventories: new DataCollection(InventoryData::class, $product->inventories),
        );
    }
}

<?php

namespace RLI\Booking\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use RLI\Booking\Classes\{SKU, UnitType};
use RLI\Booking\Models\Product;

class BuildProductAction
{
    use AsAction;

    public function handle(string $project_code, float $total_contract_price, int $lot_area, int $floor_area, string $unit_type, float $processing_fee = null): Product
    {
        $type = 'simple';
        $sku = (new SKU([
            'project_code' => $project_code,
            'total_contract_price' => $total_contract_price,
            'lot_area' => $lot_area,
            'floor_area' => $floor_area,
            'unit_type' => (new UnitType($unit_type))->toModel()
        ]))->toCode();
        $location = config('booking.defaults.product.auto')[$project_code]['location'];
        $processing_fee  = $processing_fee ?: config('booking.defaults.product.processing_fee');
        $brand = config('booking.defaults.product.auto')[$project_code]['brand'];
        $name = $brand . ' ' . $unit_type . ' ' . 'L' . $lot_area . ' ' . 'F' . $floor_area;
        $category = config('booking.defaults.product.auto')[$project_code]['category'];

        return app(Product::class)->firstOrCreate(['sku' => $sku],[
            'type' => $type,
            'name' => $name,
            'processing_fee' => $processing_fee,
            'category' => $category,
            'status' => 1,
            'brand' => $brand,
            'price' =>  $total_contract_price,
            'location' => $location,
            'floor_area' => $floor_area,
            'lot_area' => $lot_area,
            'unit_type' => $unit_type,
        ]);
    }
}

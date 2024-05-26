<?php

namespace RLI\Booking\Transformers;

use RLI\Booking\Classes\{UnitType, SKU};
use League\Fractal\TransformerAbstract;

class InventoryTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected array $defaultIncludes = [
        //
    ];

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected array $availableIncludes = [
        //
    ];

    public function transform(array $resp): array
    {
        unset($resp['']);
        unset($resp['property_code']);
        $project_code = $resp['project_code'];
        $unit_type_name = $resp['unit_type'][0];
        $model = (new UnitType($unit_type_name))->toModel();
        $tcp =  $resp['tcp'];
        $lot_area = $resp['lot_area'];
        $floor_area = $resp['floor_area'];
        $resp['sku'] = (new SKU([
            'project_code' => $project_code,
            'total_contract_price' => $tcp,
            'lot_area' => $lot_area,
            'floor_area' => $floor_area,
            'unit_type' => $model
        ]))->toCode();

        return $resp;
    }
}

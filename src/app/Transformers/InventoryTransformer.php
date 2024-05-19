<?php

namespace RLI\Booking\Transformers;

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
        $array = explode(' ', $unit_type_name);
        $array = preg_replace("/[^A-Za-z0-9 ]/", '', $array);
        $model = '';
        foreach ($array as $word) {
            $word = match ($word) {
                'TOWNHOUSE' => 'TH',
                'FIREWALL' => 'FW',
                default => $word[0],
            };
            $model = $model . $word;
        }
        $unit_type_amount = $resp['unit_type'][1];
        $lot_area = $resp['lot_area'];
        $floor_area = $resp['floor_area'];
        $resp['sku'] = 'JN-' . $project_code . '-' . $lot_area . '-' . $floor_area . '-' . $unit_type_amount . '-' . $model;

        return $resp;
    }
}

<?php

namespace RLI\Booking\Data;

use RLI\Booking\Interfaces\CanHydrateFromModel;
use RLI\Booking\Models\Inventory;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\Computed;
use Spatie\LaravelData\Data;

class InventoryData extends Data implements CanHydrateFromModel
{
    #[Computed]
    public string $project_code;

    #[Computed]
    public int $phase;

    #[Computed]
    public int $block;

    #[Computed]
    public int $lot;

    protected array $output_array = [];

    public function __construct(
        #[MapInputName('id')]
        public int $inventory_id,
        public string $property_code
    )
    {
        if (preg_match('/(.*)-(.*)-(.*)-(.*)/', $this->property_code, $this->output_array)) {
            $this->project_code = $this->output_array[1];
            $this->phase = (int) $this->output_array[2];
            $this->block = (int) $this->output_array[3];
            $this->lot = (int) $this->output_array[4];
        };
    }


    public static function fromModel(object $model): self
    {
        $inventory = $model instanceof Inventory ? $model : new Inventory($model->toArray());

        return new self(
            inventory_id: $inventory->id,
            property_code: $model->property_code
        );
    }
}

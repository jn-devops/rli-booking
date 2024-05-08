<?php

namespace RLI\Booking\Data;

use RLI\Booking\Interfaces\CanHydrateFromModel;
use Spatie\LaravelData\Attributes\Computed;
use RLI\Booking\Traits\HydrateFromModel;
use Spatie\LaravelData\Data;

class InventoryData extends Data implements CanHydrateFromModel
{
    use HydrateFromModel;

    #[Computed]
    public string $project_code;

    #[Computed]
    public int $phase;

    #[Computed]
    public int $block;

    #[Computed]
    public int $lot;

    public function __construct(
        public string $property_code,
    ){
        $this->output_array = [];
        preg_match('/(.*)-(.*)-(.*)-(.*)/', $this->property_code, $this->output_array);
        $this->project_code = $this->output_array[1];
        $this->phase = (int) $this->output_array[2];
        $this->block = (int) $this->output_array[3];
        $this->lot = (int) $this->output_array[4];
    }
}

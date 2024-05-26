<?php

namespace RLI\Booking\Classes;

class UnitType
{
    protected string $unit_type;

    public function __construct(string $unit_type)
    {
        $this->unit_type = $unit_type;
    }

    public function toModel(): string
    {
        $array = explode(' ', $this->unit_type);
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

        return $model;
    }
}

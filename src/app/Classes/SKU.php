<?php

namespace RLI\Booking\Classes;

use Illuminate\Support\Facades\Validator;

class SKU
{
    protected string $prefix;

    protected array $attribs;

    public function __construct(array $attribs, string $prefix = 'JN')
    {
        $validated = Validator::validate($attribs, $this->rules());

        $this->attribs = $validated;
        $this->prefix = $prefix;
    }

    protected function rules(): array
    {
        return [
            'project_code' => ['required', 'string'],
            'total_contract_price' => ['required', 'numeric'],
            'lot_area' => ['required', 'numeric'],
            'floor_area' => ['required', 'numeric'],
            'unit_type' => ['required', 'string'],
        ];
    }

    public function toCode(): string
    {
        return implode('-', array_merge((array) $this->prefix, $this->attribs));
    }
}

<?php

namespace RLI\Booking\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use RLI\Booking\Data\PayloadData;
use Illuminate\Http\Request;

class PayloadResource extends JsonResource
{
    protected PayloadData $payloadData;

    public function __construct($resource)
    {
        parent::__construct($resource);

        $this->payloadData = PayloadData::fromVoucher($resource);
    }

    public function toArray(Request $request): array
    {
        return $this->payloadData->toArray();
    }

    public function with(Request $request): array
    {
        return [
            'json' => $this->payloadData->toJson()
        ];
    }
}

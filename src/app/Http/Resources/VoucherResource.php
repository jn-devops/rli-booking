<?php

namespace RLI\Booking\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use RLI\Booking\Data\VoucherData;
use Illuminate\Http\Request;

class VoucherResource extends JsonResource
{
    protected VoucherData $voucherData;

    public function __construct($resource)
    {
        parent::__construct($resource);

        $this->voucherData = VoucherData::fromModel($resource);
    }

    public function toArray(Request $request): array
    {
        return $this->voucherData->toArray();
    }

    public function with(Request $request): array
    {
        return [
            'json' => $this->voucherData->toJson()
        ];
    }
}

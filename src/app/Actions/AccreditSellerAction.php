<?php

namespace RLI\Booking\Actions;

use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;
use RLI\Booking\Models\Seller;
use Illuminate\Support\Arr;

class AccreditSellerAction
{
    use AsAction;

    public function handle(Seller $seller, bool $accredit = true): Seller
    {
        $seller->accredited = $accredit;
        $seller->save();

        return $seller;
    }

    public function rules(): array
    {
        return [
            'accredit' => ['nullable', 'bool'],
        ];
    }

    public function asController(ActionRequest $request): \Illuminate\Http\Response
    {
        $seller = Seller::from($request->user());
        $validated = $request->validated();
        $accredit = Arr::get($validated, 'accredit', true);
        $seller = $this->handle($seller, $accredit);

        return response($seller->toData(), 200);
    }
}

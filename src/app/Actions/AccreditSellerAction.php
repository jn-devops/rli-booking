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

    public function asController(ActionRequest $request, string $email, bool $accredit = true): \Illuminate\Http\Response
    {
        $seller = Seller::where('email', $email)->firstOrFail();
        $seller = $this->handle($seller, $accredit);

        return response($seller->toData(), 200);
    }
}

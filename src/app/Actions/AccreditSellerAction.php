<?php

namespace RLI\Booking\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Lorisleiva\Actions\ActionRequest;
use RLI\Booking\Models\Seller;

class AccreditSellerAction
{
    use AsAction;

    /**
     * @param Seller $seller
     * @param bool $accredit
     * @return Seller
     */
    public function handle(Seller $seller, bool $accredit = true): Seller
    {
        $seller->accredited = $accredit;
        $seller->save();

        return $seller;
    }

    /**
     * @param string $email
     * @param bool $accredit
     * @return \Illuminate\Http\Response
     */
    public function asController(string $email, bool $accredit = true): \Illuminate\Http\Response
    {
        $seller = Seller::where('email', $email)->firstOrFail();
        $seller = $this->handle($seller, $accredit);

        return response($seller->toData(), 200);
    }
}

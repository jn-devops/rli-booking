<?php

namespace RLI\Booking\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use RLI\Booking\Models\Seller;

class UpdateSellerMFilesIdAction
{
    use AsAction;

    /**
     * @param Seller $seller
     * @param int $mfiles_id
     * @return Seller
     */
    public function handle(Seller $seller, int $mfiles_id): Seller
    {
        $seller->mfiles_id = $mfiles_id;
        $seller->save();

        return $seller;
    }

    /**
     * @param string $email
     * @param int $mfiles_id
     * @return \Illuminate\Http\Response
     */
    public function asController(string $email, int $mfiles_id): \Illuminate\Http\Response
    {
        $seller = Seller::where('email', $email)->firstOrFail();
        $seller = $this->handle($seller, $mfiles_id);

        return response($seller->toData(), 200);
    }
}

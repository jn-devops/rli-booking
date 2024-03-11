<?php

namespace RLI\Booking\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use RLI\Booking\Models\Voucher;

class OfficialSaleAction
{
    use AsAction;

    /**
     * TODO: Test this
     *
     * @param string $code
     * @return Voucher
     */
    public function handle(string $code): Voucher
    {
        return Voucher::where('code', $code)->firstOrFail();
    }

    /**
     * @param string $code
     * @return array
     */
    public function asController(string $code): array
    {
        return $this->handle($code)->getOrder()->toData();
    }
}

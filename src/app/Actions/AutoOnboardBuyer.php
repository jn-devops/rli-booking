<?php

namespace RLI\Booking\Actions;

use RLI\Booking\Models\Buyer;
use RLI\Booking\Models\Voucher;

class AutoOnboardBuyer extends ProcessBuyerAction
{
    protected function afterCreatingBuyerProcessing(Buyer $buyer, array $validated): Voucher
    {
        $voucher = GenerateVoucherAction::run([
            'sku' => 'JN-AGM-CL-HLDUS-GRN',
        ]);

        return $voucher;
    }
}

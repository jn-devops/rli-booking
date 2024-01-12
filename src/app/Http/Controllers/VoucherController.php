<?php

namespace RLI\Booking\Http\Controllers;

use App\Http\Controllers\Controller;
use RLI\Booking\Models\Voucher;
use Inertia\Inertia;

class VoucherController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(Voucher $voucher): \Inertia\Response
    {
        $order = $voucher->getOrder();
        $order->load(['seller', 'product']);

        return Inertia::render('Order/Update', [
            'voucher' => $voucher,
            'order' => $order
        ]);
    }
}

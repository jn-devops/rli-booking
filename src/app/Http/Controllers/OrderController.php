<?php

namespace RLI\Booking\Http\Controllers;

use RLI\Booking\Models\{Order, Voucher};
use App\Http\Controllers\Controller;
use Inertia\Inertia;

class OrderController extends Controller
{
    /**
     * @param Voucher $voucher
     * @param Order $order
     * @return \Inertia\Response
     */
    public function edit(Voucher $voucher, Order $order, string $property_code = null): \Inertia\Response
    {
        $order->load(['product', 'seller']);

        return Inertia::render('Order/Edit', [
            'voucherCode' => $voucher->code,
            'order' => $order,
            'property_code' => $property_code
        ]);
    }
}

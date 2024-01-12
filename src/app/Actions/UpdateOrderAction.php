<?php

namespace RLI\Booking\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use RLI\Booking\Models\Order;
use Illuminate\Support\Arr;

class UpdateOrderAction
{
    use AsAction;

    public function handle(Order $order, array $attribs): Order
    {
        $order->property_code = Arr::get($attribs, 'property_code');
        $order->dp_percent = Arr::get($attribs, 'dp_percent');
        $order->dp_months = Arr::get($attribs, 'dp_months');
        $order->save();

        return $order;
    }
}

<?php

namespace RLI\Booking\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use RLI\Booking\Models\Order;

class SendOrderAction
{
    use AsAction;

    public function handle(Order $order)
    {

    }
}

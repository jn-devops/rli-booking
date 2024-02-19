<?php

namespace RLI\Booking\Actions;

use Illuminate\Support\Arr;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;
use RLI\Booking\Classes\State\PaidPendingFulfillment;
use RLI\Booking\Events\PaymentAcknowledged;
use RLI\Booking\Http\Resources\PayloadResource;
use RLI\Booking\Models\Voucher;
//use RLI\Booking\Traits\ValidateHandle;

class AcknowledgePaymentAction
{
//    use ValidateHandle;
    use AsAction;

    protected function acknowledge(Voucher $voucher): Voucher
    {
        $order = $voucher->getOrder();
        $order->state->transitionTo(PaidPendingFulfillment::class);
        PaymentAcknowledged::dispatch($voucher);

        return $voucher->fresh();
    }

    public function handle(array $validated): Voucher
    {
        $voucher = $this->getVoucher($validated);

        return $this->acknowledge($voucher);
    }

    public function rules(): array
    {
        return [
            'reference_code' => ['required', 'string', 'min:2'],
        ];
    }

    public function asController(ActionRequest $request):  \Illuminate\Http\JsonResponse
    {
        $voucher = $this->getVoucher($request->validated());
        $voucher = $this->acknowledge($voucher);
        $order = $voucher->getOrder();

        return (new PayloadResource($voucher))
            ->additional(['paid-using' => $order->meta->get('payment')])
            ->response()->setStatusCode(302);
    }
    private function getVoucher(array $validated): Voucher
    {
        $code = Arr::get($validated, 'reference_code');

        return Voucher::where('code', $code)->firstOrFail();
    }


}

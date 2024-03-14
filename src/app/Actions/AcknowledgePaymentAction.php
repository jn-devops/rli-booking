<?php

namespace RLI\Booking\Actions;

use RLI\Booking\Notifications\PaymentConfirmedBuyerNotification;
use RLI\Booking\Notifications\PaymentConfirmedNotification;
use RLI\Booking\Classes\State\PaidPendingFulfillment;
use RLI\Booking\Http\Resources\PayloadResource;
use RLI\Booking\Events\PaymentAcknowledged;
use Lorisleiva\Actions\Concerns\AsAction;
use RLI\Booking\Traits\ValidateHandle;
use Lorisleiva\Actions\ActionRequest;
use RLI\Booking\Models\Voucher;
use Illuminate\Support\Arr;

class AcknowledgePaymentAction
{
    use ValidateHandle;
    use AsAction;

    protected function acknowledge(Voucher $voucher, string $payment_id): Voucher
    {
        $order = $voucher->getOrder();
        $order->payment_id = $payment_id;
        $order->save();  
        $order->state->transitionTo(PaidPendingFulfillment::class);  
        $order->buyer->notify(new PaymentConfirmedBuyerNotification($voucher, $payment_id));            
        $order->seller->notify(new PaymentConfirmedNotification($voucher, $payment_id));
        PaymentAcknowledged::dispatch($voucher);

        return $voucher->fresh();
    }

    public function handle(array $validated): Voucher
    {
        $voucher = $this->getVoucher($validated);
        $payment_id = Arr::get($validated, 'payment_id');

        return $this->acknowledge($voucher, $payment_id);
    }

    public function rules(): array
    {
        return [
            'reference_code' => ['required', 'string', 'min:2', 'exists:vouchers,code'],
            'payment_id' => ['required', 'string'],
        ];
    }

    public function asController(ActionRequest $request):  \Illuminate\Http\JsonResponse
    {
        $voucher = $this->getVoucher($validated = $request->validated());
        $payment_id = Arr::get($validated, 'payment_id');
        $voucher = $this->acknowledge($voucher, $payment_id);
        $order = $voucher->getOrder();

        return (new PayloadResource($voucher))
            ->additional(['paid-using' => $order->meta->get('receipt')])
            ->response()->setStatusCode(200);
    }
    private function getVoucher(array $validated): Voucher
    {
        $code = Arr::get($validated, 'reference_code');

        return Voucher::where('code', $code)->firstOrFail();
    }
}

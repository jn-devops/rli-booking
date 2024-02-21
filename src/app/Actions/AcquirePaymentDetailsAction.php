<?php

namespace RLI\Booking\Actions;

use RLI\Booking\Http\Resources\PayloadResource;
use RLI\Booking\Events\PaymentDetailsAcquired;
use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Support\Facades\Validator;
use Lorisleiva\Actions\ActionRequest;
use RLI\Booking\Models\Voucher;
use Illuminate\Support\Arr;

class AcquirePaymentDetailsAction
{
    use AsAction;

    /**
     * @param array $attributes
     * @return Voucher
     */
    protected function acquirePaymentDetails(array $attributes): Voucher
    {
        $validated = Validator::validate($attributes, $this->rules());
        $voucher = $this->getVoucher($validated);
        $order = $voucher->getOrder();
        $order->code_url = Arr::get($validated, 'code_url');
        $order->code_img_url = Arr::get($validated, 'code_img_url');
        $order->expiration_date = Arr::get($validated, 'expiration_date');
        $order->save();
        PaymentDetailsAcquired::dispatch($voucher);

        return $voucher;
    }

    /**
     * @param array $attributes
     * @return Voucher
     */
    public function handle(array $attributes): Voucher
    {
        return $this->acquirePaymentDetails($attributes);
    }

    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            'reference_code' => ['required', 'string', 'exists:vouchers,code'],
            'code_url' => ['required', 'string'],
            'code_img_url' => ['required', 'string'],
            'expiration_date' => ['required', 'string'],
        ];
    }

    /**
     * @param ActionRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function asController(ActionRequest $request): \Illuminate\Http\JsonResponse
    {
        $voucher = $this->acquirePaymentDetails($request->validated());
        $order = $voucher->getOrder();

        return (new PayloadResource($voucher))
            ->additional(['pay-using' => $order->meta->get('payment')])
            ->response()->setStatusCode(200);
    }

    /**
     * TODO: refactor this to an action
     *
     * @param array $attributes
     * @return Voucher
     */
    private function getVoucher(array $attributes): Voucher
    {
        $code = Arr::get($attributes, 'reference_code');

        return Voucher::where('code', $code)->firstOrFail();
    }
}

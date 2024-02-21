<?php

namespace RLI\Booking\Actions;

use RLI\Booking\Classes\State\UpdatedPendingProcessing;
use Lorisleiva\Actions\Concerns\AsAction;
use RLI\Booking\Models\{Order, Voucher};
use Lorisleiva\Actions\ActionRequest;

class UpdateOrderAction
{
    use AsAction;

    /**
     * @param Voucher $voucher
     * @param array $orderUpdates
     * @return void
     * @throws \Spatie\ModelStates\Exceptions\CouldNotPerformTransition
     */
    public function handle(Voucher $voucher, array $orderUpdates): void
    {
        tap($voucher->getOrder(), function (Order $order) use ($orderUpdates) {
            $order->update($orderUpdates);
            $order->state->transitionTo(UpdatedPendingProcessing::class);
            $order->save();
        });
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'property_code' => ['required', 'string', 'min:5'],
            'dp_percent' => ['required', 'integer'],
            'dp_months' => ['required', 'integer'],
        ];
    }

    /**
     * @param Voucher $voucher
     * @param ActionRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Spatie\ModelStates\Exceptions\CouldNotPerformTransition
     */
    public function asController(Voucher $voucher, ActionRequest $request): \Illuminate\Http\RedirectResponse
    {
        $this->handle($voucher, $request->validated());

        return redirect()->route('references.show', [
            'voucher' => $voucher->code
        ]);
    }
}

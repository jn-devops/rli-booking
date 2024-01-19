<?php

namespace RLI\Booking\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use RLI\Booking\Models\{Order, Voucher};
use Lorisleiva\Actions\ActionRequest;
use Illuminate\Validation\Rule;
class UpdateOrderAction
{
    use AsAction;

    protected array $propertyCodes = [
        'PC-001',
        'PC-002',
        'PC-003',
        'PC-004',
        'PC-005',
    ];

    /**
     * @param Voucher $voucher
     * @param array $orderUpdates
     * @return void
     */
    public function handle(Voucher $voucher, array $orderUpdates): void
    {
        tap($voucher->getOrder(), function (Order $order) use ($orderUpdates) {
            $order->update($orderUpdates);
            $order->save();
        });
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'property_code' => ['required', 'string', Rule::in($this->propertyCodes)],
            'dp_percent' => ['required', 'integer'],
            'dp_months' => ['required', 'integer'],
        ];
    }

    /**
     * @param Voucher $voucher
     * @param ActionRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function asController(Voucher $voucher, ActionRequest $request): \Illuminate\Http\RedirectResponse
    {
        $this->handle($voucher, $request->validated());

        return redirect()->route('references.show', [
            'voucher' => $voucher->code
        ]);
    }
}

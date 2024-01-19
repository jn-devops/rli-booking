<?php

namespace RLI\Booking\Actions;

use Illuminate\Support\{Arr, Facades\Validator, Str};
use FrittenKeeZ\Vouchers\Facades\Vouchers;
use Lorisleiva\Actions\Concerns\AsAction;
use FrittenKeeZ\Vouchers\Models\Voucher;
use RLI\Booking\Models\{Order, Product};
use Lorisleiva\Actions\ActionRequest;
use App\Models\User;

class GenerateVoucherAction
{
    use AsAction;

    const VOUCHER_PREFIX = 'JN';
    const VOUCHER_MASK = '******';

    /**
     * @param array $validated
     * @return Order
     */
    protected function createOrder(array $validated): Order
    {
        $seller = User::where('email', Arr::get($validated,'email'))->first();
        $product = Product::where('sku', Arr::get($validated,'sku'))->first();
        $order = new Order;
        $order->reference = Str::uuid()->toString();
        $order->seller()->associate($seller);
        $order->product()->associate($product);
        $order->callback_url = Arr::get($validated, 'callback_url');
        $order->save();

        return $order;
    }

    /**
     * @param array $attributes
     * @return Order
     */
    public function handle(array $attributes): Order
    {
        $validated = Validator::validate($attributes, $this->rules());

        return $this->createOrder($validated);
    }

    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'exists:users'],
            'sku' => ['required', 'exists:products'],
            'callback_url' => ['required', 'url:https'],
            'discount' => ['integer', 'min:0', 'max:100'],
        ];
    }

    /**
     * @param ActionRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function asController(ActionRequest $request): \Illuminate\Http\RedirectResponse
    {
        $order = $this->createOrder($request->validated());
        $voucher = $this->generateVoucher($order);

        return redirect()->route('edit-order', [
            'voucher' => $voucher->code,
            'order' => $order->id
        ]);
    }

    /**
     * @param Order $order
     * @return Voucher
     */
    protected function generateVoucher(Order $order): Voucher
    {
        $metadata = [
            'author' => 'RLI'
        ];

         return Vouchers::withPrefix(self::VOUCHER_PREFIX)
             ->withMask(self::VOUCHER_MASK)
             ->withOwner($order->seller)
             ->withEntities($order)
             ->withMetadata($metadata)
             ->create();
    }
}

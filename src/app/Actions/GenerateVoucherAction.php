<?php

namespace RLI\Booking\Actions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use RLI\Booking\Models\{Order, Product, Voucher};
use Illuminate\Support\{Arr, Facades\Validator};
use FrittenKeeZ\Vouchers\Facades\Vouchers;
use Lorisleiva\Actions\Concerns\AsAction;
use Lorisleiva\Actions\ActionRequest;
use App\Models\User;

class GenerateVoucherAction
{
    use AsAction;

    const VOUCHER_PREFIX = 'JN';
    const VOUCHER_MASK = '******';

    /**
     * @param array $validated
     * @return Voucher
     */
    protected function createVoucherOrder(array $validated): Voucher
    {
        $order = $this->createOrder($validated);

        return $this->generateVoucher($order);
    }

    /**
     * @param array $attributes
     * @return Voucher
     */
    public function handle(array $attributes): Voucher
    {
        $validated = Validator::validate($attributes, $this->rules());

        return $this->createVoucherOrder($validated);
    }

    /**
     * TODO: replace callback_url to transaction_id
     * @return array[]
     */
    public function rules(): array
    {
        return [
            'discount' => ['nullable', 'integer', 'min:0', 'max:100'],
            'email' => ['nullable', 'email', 'exists:users'],
            'sku' => ['required', 'exists:products'],
            'transaction_id' => ['nullable', 'string', 'min:2'],
        ];
    }

    /**
     * @param ActionRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function asController(ActionRequest $request): \Illuminate\Http\RedirectResponse
    {
        $voucher = $this->handle($request->validated());
        $order = $voucher->getOrder();

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

         $voucher = Vouchers::withPrefix(self::VOUCHER_PREFIX)
             ->withMask(self::VOUCHER_MASK)
             ->withOwner($order->seller)
             ->withEntities($order)
             ->withMetadata($metadata)
             ->create();

         return Voucher::from($voucher);
    }

    protected function createOrder(array $validated): Order
    {
        try {
            $seller = User::where('email', Arr::pull($validated,'email'))->firstOrFail();
        }
        catch (ModelNotFoundException $e) {
            $default_seller_email = config('booking.defaults.seller.email');
            $seller = User::where('email', $default_seller_email)->first();
        }
        $product = Product::where('sku', Arr::pull($validated,'sku'))->first();
        $transaction_id = Arr::pull($validated, 'transaction_id');

        return tap(new Order, function ($order) use ($seller, $product, $transaction_id) {
            $order->seller()->associate($seller);
            $order->product()->associate($product);
            $order->transaction_id = $transaction_id;
            $order->save();
        });
    }
}

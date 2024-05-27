<?php

namespace RLI\Booking\Actions;

use RLI\Booking\Models\{Contact, Order, Product, Seller, Voucher};
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\{Arr, Facades\Validator};
use FrittenKeeZ\Vouchers\Facades\Vouchers;
use Lorisleiva\Actions\Concerns\AsAction;
use Lorisleiva\Actions\ActionRequest;

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
        $contact = $this->getContact($validated);

        return $this->generateVoucher($order, $contact);
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
            'property_code' => ['nullable', 'string', 'min:2'],
            'contact_uid' => ['nullable', 'string', 'min:2'],
        ];
    }

    /**
     * @param ActionRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function asController(ActionRequest $request): \Illuminate\Http\RedirectResponse
    {
        $voucher = $this->createVoucherOrder($request->validated());
        $order = $voucher->getOrder();

        $params = [
            'voucher' => $voucher->code,
            'order' => $order->id
        ];

        return redirect()->route('edit-order', $params)
            ->with('params', $params);
    }

    /**
     * @param Order $order
     * @param Contact|null $contact
     * @return Voucher
     */
    protected function generateVoucher(Order $order, Contact $contact = null): Voucher
    {
        $metadata = [
            'author' => '537'
        ];

        $entities = array_filter(compact('order', 'contact'));

         $voucher = Vouchers::withPrefix(self::VOUCHER_PREFIX)
             ->withMask(self::VOUCHER_MASK)
             ->withOwner($order->seller)
             ->withEntities(...$entities)
             ->withMetadata($metadata)
             ->create();

         if (isset($contact)) {
             $contact->reference_code = $voucher->code;
             $contact->save();
         }

         return Voucher::from($voucher);
    }

    /**
     * @param array $validated
     * @return Order
     */
    protected function createOrder(array $validated): Order
    {
        try {
            $seller = Seller::where('email', Arr::pull($validated,'email'))->firstOrFail();
        }
        catch (ModelNotFoundException $e) {
            $default_seller_email = config('booking.defaults.seller.email');
            $seller = Seller::where('email', $default_seller_email)->first();
        }
        $product = Product::where('sku', Arr::pull($validated,'sku'))->first();
        $transaction_id = Arr::get($validated, 'transaction_id');
        $property_code = Arr::get($validated, 'property_code');

        return tap(new Order, function ($order) use ($seller, $product, $transaction_id, $property_code) {
            $order->seller()->associate($seller);
            $order->product()->associate($product);
            $order->property_code = $property_code;
            $order->transaction_id = $transaction_id;
            $order->save();
        });
    }


    /**
     * @param array $validated
     * @return Contact|null
     */
    public function getContact(array $validated): ?Contact
    {
        $contact = null;
        if ($contact_uid = Arr::get($validated, 'contact_uid'))
            $contact = Contact::where('uid', $contact_uid)->first();
        return $contact;
    }
}

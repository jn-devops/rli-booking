<?php

namespace RLI\Booking\Actions;

use FrittenKeeZ\Vouchers\Facades\Vouchers;
use Lorisleiva\Actions\Concerns\AsAction;
use RLI\Booking\Models\{Order, Product};
use Lorisleiva\Actions\ActionRequest;
use Illuminate\Support\{Arr, Str};
use Illuminate\Routing\Router;
use App\Models\User;

class GenerateVoucherAction
{
    use AsAction;

    public static function routes(Router $router): void
    {
        $router->post('generate-voucher', static::class)
            ->name('generate-voucher');

    }

    public function handle(array $attributes): Order
    {
        $seller = User::where('email', Arr::get($attributes,'email'))->first();
        $product = Product::where('sku', Arr::get($attributes,'sku'))->first();
        $order = new Order;
        $order->reference = Str::uuid()->toString();
        $order->seller()->associate($seller);
        $order->product()->associate($product);
        $order->save();

        return $order;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'sku' => ['required', 'string'],
            'discount' => ['integer', 'min:0', 'max:100'],
        ];
    }

    public function asController(ActionRequest $request): \Illuminate\Http\RedirectResponse
    {
        $order = $this->handle($request->validated());

        $prefix = 'JN';
        $mask = '*****';
        $metadata = [
            'author' => 'RLI'
        ];
        $voucher = Vouchers::withPrefix($prefix)
            ->withMask($mask)
            ->withOwner($order->seller)
            ->withEntities($order)
            ->withMetadata($metadata)
            ->create();

        return redirect()->route('refs.show', [
            'voucher' => $voucher->code,
        ]);
    }
}

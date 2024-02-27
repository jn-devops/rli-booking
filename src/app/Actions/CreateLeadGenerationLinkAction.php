<?php

namespace RLI\Booking\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use RLI\Booking\Models\{Product, Seller};
use Lorisleiva\Actions\ActionRequest;

class CreateLeadGenerationLinkAction
{
    use AsAction;

    /**
     * @param Seller $seller
     * @param Product $product
     * @return string
     */
    public function handle(Seller $seller, Product $product): string
    {
        $longUrl = route('affiliate-reserve', [
            'email' => $seller->email,
            'sku' => $product->sku
        ]);

        return ShortenURLAction::run($longUrl);
    }

    /**
     * @param ActionRequest $request
     * @param string $sku
     * @return \Illuminate\Http\RedirectResponse
     */
    public function asController(ActionRequest $request, string $sku): \Illuminate\Http\RedirectResponse
    {
        $product = Product::where('sku', $sku)->firstOrFail();
        $user = $request->user();
        $seller = $user instanceof Seller ? $user : Seller::from($user);
        $url = $this->handle($seller, $product);

        return back()->with('event', [
            'name' => 'link.created',
            'data' => [
                'url' => $url
            ],
        ]);
    }
}

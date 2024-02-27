<?php

namespace RLI\Booking\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use RLI\Booking\Models\{Product, Seller};
use Lorisleiva\Actions\ActionRequest;
use RLI\Booking\Classes\Bitly;
use RLI\Booking\Data\BitlyResponseData;
use Illuminate\Support\Facades\Http;

class CreateLeadGenerationLinkAction
{
    use AsAction;

    public function __construct(protected ShortenURLAction $shortener, protected Bitly $bitly){}

    /**
     * @param Seller $seller
     * @param Product $product
     * @param string $title
     * @return false|BitlyResponseData
     */
    public function handle(Seller $seller, Product $product, string $title = 'Test Title From Laravel'): bool|BitlyResponseData
    {
        $longUrl = route('affiliate-reserve', [
            'email' => $seller->email,
            'sku' => $product->sku
        ]);

        $response = $this->shortener->run($longUrl);
        $this->bitly->setResponse($response)->getUpdateEndPoint();

        $body = $this->bitly->setTitle($title)->getUpdateBody();
        $response = Http::withHeaders($this->bitly->getHeaders())
            ->patch($this->bitly->getUpdateEndPoint(), $body);

        return $response->successful() ? BitlyResponseData::from($response->json()) : false;
    }

    /**
     * @param ActionRequest $request
     * @param string $sku
     * @return \Illuminate\Http\RedirectResponse
     */
    public function asController(ActionRequest $request, string $sku, string $title): \Illuminate\Http\RedirectResponse
    {
        $product = Product::where('sku', $sku)->firstOrFail();
        $user = $request->user();
        $seller = $user instanceof Seller ? $user : Seller::from($user);
        $response = $this->handle($seller, $product, $title);

        return back()->with('event', [
            'name' => 'link.created',
            'data' => $response->toArray(),
        ]);
    }
}

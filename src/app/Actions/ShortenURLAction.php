<?php

namespace RLI\Booking\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Illuminate\Support\Facades\Http;
use RLI\Booking\Classes\Bitly;

class ShortenURLAction
{
    use AsAction;

    public function __construct(protected Bitly $bitly){}

    /**
     * @param string $longUrl
     * @return string|bool
     */
    public function handle(string $longUrl): string|bool
    {
        $body = $this->bitly->setLongUrl($longUrl)->getBody();
        $response = Http::withHeaders($this->bitly->getHeaders())
            ->post($this->bitly->getEndPoint(), $body);

        return $response->successful() ? $response->json('link') : false;
    }
}

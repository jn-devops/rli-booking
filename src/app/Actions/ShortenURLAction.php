<?php

namespace RLI\Booking\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Lorisleiva\Actions\ActionRequest;
use Illuminate\Support\Facades\Http;
use RLI\Booking\Classes\Bitly;
use Illuminate\Support\Arr;

class ShortenURLAction
{
    use AsAction;


    public function __construct(protected Bitly $bitly){}

    public function handle(string $longUrl): string|bool
    {
        $body = $this->bitly->setLongUrl($longUrl)->getBody();
        $response = Http::withHeaders($this->bitly->getHeaders())
            ->post($this->bitly->getEndPoint(), $body);

        return $response->successful() ? $response->json('link') : false;
    }

    public function rules(): array
    {
        return [
            'longUrl' => ['required', 'string', 'url:http,https']
        ];
    }

    public function AsController(ActionRequest $request): string
    {
        $longUrl = Arr::get($request->validated(), 'longUrl');

        return $this->handle($longUrl);
    }
}

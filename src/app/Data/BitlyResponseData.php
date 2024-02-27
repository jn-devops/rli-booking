<?php

namespace RLI\Booking\Data;

use Spatie\LaravelData\{Data, Optional};

class BitlyResponseData extends Data
{
    public function __construct(
        public string $created_at,
        public string $id,
        public string $link,
        public array $custom_bitlinks,
        public string $long_url,
        public string|Optional $title,
        public bool $archived,
        public string|Optional $client_id,
        public array $tags,
        public array $deeplinks,
        public array $references,
    ) {}
}

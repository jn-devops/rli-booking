<?php

namespace RLI\Booking\Classes;

class Bitly
{
    static public string $client_token;

    static public string $client_group_guid;

    static public string $client_domain;

    protected string $longUrl = '';

    public function getHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . static::$client_token
        ];
    }

    public function getEndPoint(): string
    {
        return config('booking.bitly.server.shorten_end_point');
    }

    public function setLongUrl(string $value): static
    {
        $this->longUrl = $value;

        return $this;
    }

    public function getBody(): array
    {
        return [
            'long_url' => $this->longUrl,
            'domain' => self::$client_domain,
            'group_guid' => self::$client_group_guid
        ];
    }
}

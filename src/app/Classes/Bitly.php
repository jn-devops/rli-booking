<?php

namespace RLI\Booking\Classes;

use RLI\Booking\Data\BitlyResponseData;

class Bitly
{
    static public string $client_token;

    static public string $client_group_guid;

    static public string $client_domain;

    protected string $longUrl = '';

    protected BitlyResponseData $response;

    protected string $title = '';

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

    public function setResponse(BitlyResponseData $value): static
    {
        $this->response = $value;

        return $this;
    }

    public function setTitle(string $value): static
    {
        $this->title = $value;

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

    public function getUpdateEndPoint(): string
    {
        $id = $this->response->id;

        return trans(config('booking.bitly.server.update_end_point'), ['id' => $id]);
    }

    public function getUpdateBody(): array
    {
        return [
            'title' => $this->title,
        ];
    }
}

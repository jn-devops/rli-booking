<?php

use Illuminate\Foundation\Testing\{RefreshDatabase, WithFaker};
use RLI\Booking\Actions\ShortenURLAction;
use RLI\Booking\Data\BitlyResponseData;

uses(RefreshDatabase::class, WithFaker::class);

test('shorten url action works', function () {
    $longUrl = 'https://book-dev.enclaves.ph/affiliate-reserve/celine.beltran@enclaves.ph/JN-AGM-CL-HLDUS-YEL';
    $action = app(ShortenURLAction::class);
    $response = $action->run($longUrl);

    expect($response)->toBeInstanceOf(BitlyResponseData::class);
});

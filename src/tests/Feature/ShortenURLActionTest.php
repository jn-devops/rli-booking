<?php

use Illuminate\Foundation\Testing\{RefreshDatabase, WithFaker};
use RLI\Booking\Actions\ShortenURLAction;

uses(RefreshDatabase::class, WithFaker::class);

test('shorten url action works', function () {
    $longUrl = 'https://book-dev.enclaves.ph/affiliate-reserve/celine.beltran@enclaves.ph/JN-AGM-CL-HLDUS-YEL';
    $action = app(ShortenURLAction::class);
    $shortUrl = $action->run($longUrl);
    expect($shortUrl)->toBeUrl();
});

//test('shorten url action has end point', function () {
//    $longUrl = 'https://book-dev.enclaves.ph/affiliate-reserve/celine.beltran@enclaves.ph/JN-AGM-CL-HLDUS-GRN';
//
//    $response = $this->post(route('shorten-url'), [
//        'longUrl' => $longUrl,
//    ]);
//    $response->assertStatus(200);
//    expect($response->getContent())->toBeUrl();
//});

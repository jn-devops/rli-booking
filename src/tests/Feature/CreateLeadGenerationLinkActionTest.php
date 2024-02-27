<?php

use Illuminate\Foundation\Testing\{RefreshDatabase, WithFaker};
use RLI\Booking\Actions\CreateLeadGenerationLinkAction;
use RLI\Booking\Models\{Product, Seller};
use RLI\Booking\Data\BitlyResponseData;
use App\Models\User;

uses(RefreshDatabase::class, WithFaker::class);

test('create lead generation action works', function () {
    $seller = Seller::factory()->create();
    $product = Product::factory()->create();
    $action = app(CreateLeadGenerationLinkAction::class);
    $title = $this->faker->sentence();
    $response = $action->run($seller, $product, $title);
    expect($response)->toBeInstanceOf(BitlyResponseData::class);
});

test('create lead generation action has end point', function () {
    $user = User::factory()->create();
    $product = Product::factory()->create();
    $title = $this->faker->sentence();
    $response = $this->actingAs($user)->post(route('create-link', ['sku' => $product->sku, 'title' => $title]));
    $response->assertStatus(302);
    $this->followRedirects($response)->assertSee('link.created');
});

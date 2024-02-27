<?php

use Illuminate\Foundation\Testing\{RefreshDatabase, WithFaker};
use RLI\Booking\Actions\CreateLeadGenerationLinkAction;
use RLI\Booking\Models\{Product, Seller};
use App\Models\User;

uses(RefreshDatabase::class, WithFaker::class);

test('create lead generation action works', function () {
    $seller = Seller::factory()->create();
    $product = Product::factory()->create();
    $action = app(CreateLeadGenerationLinkAction::class);
    $url = $action->run($seller, $product);
    expect($url)->toBeUrl();
});

test('create lead generation action has end point', function () {
    $user = User::factory()->create();
    $product = Product::factory()->create();
    $response = $this->actingAs($user)->post(route('create-link', ['sku' => $product->sku]));
    $response->assertStatus(302);
    $this->followRedirects($response)->assertSee('link.created');
});

<?php

use Illuminate\Foundation\Testing\{RefreshDatabase, WithFaker};
use RLI\Booking\Actions\UploadProductsAction;
use RLI\Booking\Models\Product;

uses(RefreshDatabase::class, WithFaker::class);

beforeEach(function() {
    $this->faker = $this->makeFaker('en_PH');
});

test('upload products action requires an excel file', function () {
    $path = documents_path('bulk_upload.xlsx');
    expect(file_exists($path))->toBeTrue();
    expect(Product::all()->count())->toBe(0);
    UploadProductsAction::run($path);
    UploadProductsAction::run($path);
    expect(Product::all()->count() > 0)->toBeTrue();
});

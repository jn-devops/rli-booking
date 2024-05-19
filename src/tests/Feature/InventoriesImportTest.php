<?php
use Illuminate\Foundation\Testing\{RefreshDatabase, WithFaker};
use RLI\Booking\Imports\Cornerstone\InventoriesImport;
use RLI\Booking\Models\{Inventory, Product};
use Maatwebsite\Excel\Facades\Excel;

uses(RefreshDatabase::class, WithFaker::class);

beforeEach(function() {
    $this->faker = $this->makeFaker('en_PH');
});

test('inventory import works', function () {
    expect(Inventory::count())->toBe(0);
    expect(Product::count())->toBe(0);
    $path = "/Users/devops/Downloads/Pasinaya Homes Encoding/test_upload.xlsx";
    Excel::import(new InventoriesImport, $path);
    expect(Inventory::count() > 0)->toBeTrue();
    expect(Product::count() > 0)->toBeTrue();
})->skip();


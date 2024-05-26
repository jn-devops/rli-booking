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
    $path = documents_path('test_cornerstone_inventories.xlsx');
    Excel::import(new InventoriesImport, $path);
    expect(Inventory::count() > 0)->toBeTrue();
    expect(Product::count() > 0)->toBeTrue();
});


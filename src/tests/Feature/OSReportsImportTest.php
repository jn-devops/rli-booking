<?php
use Illuminate\Foundation\Testing\{RefreshDatabase, WithFaker};
use RLI\Booking\Seeders\{InventorySeeder, UserSeeder};
use RLI\Booking\Imports\Cornerstone\OSReportsImport;
use RLI\Booking\Models\{Contact, Order, Voucher};
use Maatwebsite\Excel\Facades\Excel;

uses(RefreshDatabase::class, WithFaker::class);

beforeEach(function() {
    $this->faker = $this->makeFaker('en_PH');
    $this->seed(UserSeeder::class);
    $this->seed(InventorySeeder::class);
});

test('os reports import works', function () {
    expect(Contact::count())->toBe(0);
    expect(Voucher::count())->toBe(0);
    expect(Order::count())->toBe(0);
    $path = documents_path('test_cornerstone_os_report.xlsx');
    Excel::import(new OSReportsImport, $path);
    expect(Contact::count() > 0)->toBeTrue();
    expect(Voucher::count() > 0)->toBeTrue();
    expect(Order::count() > 0)->toBeTrue();
});


<?php

namespace RLI\Booking\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'sku' => 'ABC-123',
                'name' => 'Product 123',
                'processing_fee' => 1000.00
            ],
            [
                'sku' => 'DEF-456',
                'name' => 'Product 456',
                'processing_fee' => 2000.00
            ],
        ]);
    }
}

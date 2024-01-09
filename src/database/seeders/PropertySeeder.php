<?php

namespace RLI\Booking\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class PropertySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('properties')->insert([
            [
                'code' => 'A1',
                'sku' => 'ABC-123',
            ],
            [
                'code' => 'A2',
                'sku' => 'DEF-456',
            ],
        ]);
    }
}

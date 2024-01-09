<?php

namespace RLI\Booking\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class BuyerSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('buyers')->insert([
            [
                'name' => 'John Doe',
                'address' => '111 JP Rizal St., Barangay Poblacion 1, Currimao, Ilocos Norte ',
                'birthdate' => '01/01/1999',
                'mobile' => '09171234567',
                'id_type' => 'driver_license',
                'id_number' => '11111111',
                'id_image_url' => 'https://jn-img.imagekit.io/id-image1.jpg',
                'selfie_image_url' => 'https://jn-img.imagekit.io/selfie-image1.jpg',
                'id_mark_url' => 'https://jn-img.imagekit.io/id-mark1.jpg',
            ],
            [
                'name' => 'Jane Doe',
                'address' => '222 JP Rizal St., Barangay Poblacion 2, Currimao, Ilocos Norte ',
                'birthdate' => '02/02/1999',
                'mobile' => '09187654321',
                'id_type' => 'passport',
                'id_number' => '22222222',
                'id_image_url' => 'https://jn-img.imagekit.io/id-image2.jpg',
                'selfie_image_url' => 'https://jn-img.imagekit.io/selfie-image2.jpg',
                'id_mark_url' => 'https://jn-img.imagekit.io/id-mark2.jpg',
            ],
        ]);
    }
}

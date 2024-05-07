<?php

namespace RLI\Booking\Seeders;

use App\Actions\Fortify\CreateNewUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        app(CreateNewUser::class)->create([
            'name' => 'Lester Hurtado',
            'email' => 'devops@joy-nostalg.com',
            'mobile' => '09173011987',
            'password' => '#Password1',
            'password_confirmation' => '#Password1',
        ]);
        app(CreateNewUser::class)->create([
            'name' => 'In-house Sales',
            'email' => config('booking.defaults.seller.email'),
            'mobile' => config('booking.defaults.seller.mobile'),
            'password' => '#Password1',
            'password_confirmation' => '#Password1',
        ]);
    }
}

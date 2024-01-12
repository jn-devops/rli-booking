<?php

namespace RLI\Booking\Seeders;

use App\Actions\Fortify\CreateNewUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        app(CreateNewUser::class)->create([
            'name' => 'Lester Hurtado',
            'email' => 'devops@joy-nostalg.com',
            'password' => '#Password1',
            'password_confirmation' => '#Password1',
        ]);
    }
}

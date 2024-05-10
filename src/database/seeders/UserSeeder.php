<?php

namespace RLI\Booking\Seeders;

use App\Actions\Fortify\CreateNewUser;
use RLI\Booking\Enums\SellerRolesEnum;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use RLI\Booking\Models\Seller;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        tap(app(CreateNewUser::class)->create(config('booking.seeds.sellers.admin')), function (Seller $admin) {
            if (app(Role::class)->find(SellerRolesEnum::ADMIN->value, 'web'))
                $admin->assignRole(SellerRolesEnum::ADMIN);
        });
//        app(CreateNewUser::class)->create([
//            'name' => 'Lester Hurtado',
//            'email' => 'devops@joy-nostalg.com',
//            'mobile' => '09173011987',
//            'password' => '#Password1',
//            'password_confirmation' => '#Password1',
//        ]);
        app(CreateNewUser::class)->create([
            'name' => 'In-house Sales',
            'email' => config('booking.defaults.seller.email'),
            'mobile' => config('booking.defaults.seller.mobile'),
            'password' => '#Password1',
            'password_confirmation' => '#Password1',
        ]);
    }
}

<?php

namespace RLI\Booking\Seeders;

use RLI\Booking\Enums\{PermissionsEnum, SellerRolesEnum};
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = app(Role::class)
            ->findOrCreate(SellerRolesEnum::ADMIN->value, 'web');
        $brokerRole = app(Role::class)
            ->findOrCreate(SellerRolesEnum::BROKER->value, 'web');
        $managerRole = app(Role::class)
            ->findOrCreate(SellerRolesEnum::MANAGER->value, 'web');
        $agentRole = app(Role::class)
            ->findOrCreate(SellerRolesEnum::AGENT->value, 'web');

        $brokerRole->givePermissionTo([
            PermissionsEnum::CREATE_CONTACTS,
            PermissionsEnum::VIEW_CONTACTS,
            PermissionsEnum::EDIT_CONTACTS,
            PermissionsEnum::DELETE_CONTACTS
        ]);
        $brokerRole->givePermissionTo([
            PermissionsEnum::CREATE_CONTACTS,
            PermissionsEnum::VIEW_CONTACTS,
            PermissionsEnum::EDIT_CONTACTS,
            PermissionsEnum::ASSIGN_CONTACTS,
        ]);
        $managerRole->givePermissionTo([
            PermissionsEnum::VIEW_CONTACTS,
            PermissionsEnum::EDIT_CONTACTS
        ]);
        $agentRole->givePermissionTo([
            PermissionsEnum::VIEW_CONTACTS
        ]);
    }
}

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
        $editorRole = app(Role::class)
            ->findOrCreate(SellerRolesEnum::EDITOR->value, 'web');

        $adminRole->givePermissionTo([
            PermissionsEnum::CREATE_CONTACTS,
            PermissionsEnum::VIEW_CONTACTS,
            PermissionsEnum::EDIT_CONTACTS,
            PermissionsEnum::DELETE_CONTACTS,
            PermissionsEnum::ASSIGN_CONTACTS,
            PermissionsEnum::CREATE_INVENTORY,
            PermissionsEnum::VIEW_INVENTORY,
            PermissionsEnum::EDIT_INVENTORY,
            PermissionsEnum::DELETE_INVENTORY,

        ]);
        $editorRole->givePermissionTo([
            PermissionsEnum::VIEW_CONTACTS,
            PermissionsEnum::EDIT_CONTACTS,
            PermissionsEnum::ASSIGN_CONTACTS,
            PermissionsEnum::VIEW_INVENTORY,
            PermissionsEnum::EDIT_INVENTORY,
        ]);
    }
}

<?php

namespace RLI\Booking\Seeders;

use Spatie\Permission\Models\Permission;
use RLI\Booking\Enums\PermissionsEnum;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app(Permission::class)->findOrCreate(PermissionsEnum::CREATE_CONTACTS->value, 'web');
        app(Permission::class)->findOrCreate(PermissionsEnum::VIEW_CONTACTS->value, 'web');
        app(Permission::class)->findOrCreate(PermissionsEnum::EDIT_CONTACTS->value, 'web');
        app(Permission::class)->findOrCreate(PermissionsEnum::ASSIGN_CONTACTS->value, 'web');
        app(Permission::class)->findOrCreate(PermissionsEnum::DELETE_CONTACTS->value, 'web');
        app(Permission::class)->findOrCreate(PermissionsEnum::CREATE_INVENTORY->value, 'web');
        app(Permission::class)->findOrCreate(PermissionsEnum::VIEW_INVENTORY->value, 'web');
        app(Permission::class)->findOrCreate(PermissionsEnum::EDIT_INVENTORY->value, 'web');
        app(Permission::class)->findOrCreate(PermissionsEnum::ASSIGN_INVENTORY->value, 'web');
        app(Permission::class)->findOrCreate(PermissionsEnum::DELETE_INVENTORY->value, 'web');
    }
}

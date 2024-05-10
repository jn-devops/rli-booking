<?php

namespace RLI\Booking\Enums;

enum SellerRolesEnum: string
{
    case ADMIN = 'admin';
    case EDITOR = 'editor';
    case MANAGER = 'manager';

    public function label(): string
    {
        return match ($this) {
            SellerRolesEnum::ADMIN => 'Administrators',
            SellerRolesEnum::EDITOR => 'Editors',
        };
    }
}

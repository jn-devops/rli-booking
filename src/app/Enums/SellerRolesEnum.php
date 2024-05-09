<?php

namespace RLI\Booking\Enums;

enum SellerRolesEnum: string
{
    case ADMIN = 'admin';
    case BROKER = 'broker';
    case MANAGER = 'manager';
    case AGENT = 'agent';

    public function label(): string
    {
        return match ($this) {
            SellerRolesEnum::ADMIN => 'Administrators',
            SellerRolesEnum::BROKER => 'Brokers',
            SellerRolesEnum::MANAGER => 'Managers',
            SellerRolesEnum::AGENT => 'Agents',
        };
    }
}

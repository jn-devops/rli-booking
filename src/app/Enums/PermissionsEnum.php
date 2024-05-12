<?php

namespace RLI\Booking\Enums;

enum PermissionsEnum: string
{
    case CREATE_CONTACTS = 'create contacts';
    case VIEW_CONTACTS = 'view contacts';
    case EDIT_CONTACTS = 'edit contacts';
    case ASSIGN_CONTACTS = 'assign contacts';
    case DELETE_CONTACTS = 'delete contacts';

    case CREATE_INVENTORY = 'create inventory';
    case VIEW_INVENTORY = 'view inventory';
    case EDIT_INVENTORY = 'edit inventory';
    case ASSIGN_INVENTORY = 'assign inventory';
    case DELETE_INVENTORY = 'delete inventory';
}

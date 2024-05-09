<?php

namespace RLI\Booking\Enums;

enum PermissionsEnum: string
{
    case CREATE_CONTACTS = 'create contacts';
    case VIEW_CONTACTS = 'view contacts';
    case EDIT_CONTACTS = 'edit contacts';

    case ASSIGN_CONTACTS = 'assign contacts';
    case DELETE_CONTACTS = 'delete contacts';
}

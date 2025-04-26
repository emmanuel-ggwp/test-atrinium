<?php

namespace App\Enums;

enum PermissionEnum: string
{
    case VIEW_USER = 'view-user';
    case VIEW_ANY_USERS = 'view-users';
    case CREATE_USER = 'create-user';
    case UPDATE_USER = 'update-user';
    case DELETE_USER = 'delete-user';

    public static function all(): array
    {
        return array_column(self::cases(), 'value');
    }
}
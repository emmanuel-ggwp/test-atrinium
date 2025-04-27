<?php

namespace App\Enums;

enum RoleEnum: string
{
    case SUPER_ADMIN = 'super-admin';
    case ADMIN = 'admin';

    case USER = 'user';

    public function label(): string
    {
        return match ($this) {
            static::SUPER_ADMIN => 'Super Admin',
            static::ADMIN => 'Admin',
            static::USER => 'User',
        };
    }

    public function defaultPermissions(): array
    {
        return match ($this) {
            self::SUPER_ADMIN => PermissionEnum::all(),
            self::ADMIN => [
                PermissionEnum::VIEW_USER->value,
                PermissionEnum::VIEW_ANY_USERS->value,
                PermissionEnum::CREATE_USER->value,
                PermissionEnum::UPDATE_USER->value,
                PermissionEnum::ASSIGN_ROLES_USER->value,
                PermissionEnum::RESOLVE_ROLE_APPEAL->value,
            ],
            default => [],
        };
    }
}
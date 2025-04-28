<?php

namespace App\Enums;

enum RoleEnum: string
{
    case SUPER_ADMIN = 'super-admin';
    case ADMIN = 'admin';

    case USER = 'user';
    case COMPANY_MANAGER = 'company-manager';

    public function label(): string
    {
        return match ($this) {
            static::SUPER_ADMIN => 'Super Admin',
            static::ADMIN => 'Admin',
            static::COMPANY_MANAGER => 'Company manager',
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
                PermissionEnum::VIEW_COMPANY->value,
                PermissionEnum::VIEW_ANY_COMPANIES->value,
                PermissionEnum::CREATE_COMPANY->value,
                PermissionEnum::UPDATE_COMPANY->value,
                PermissionEnum::DELETE_COMPANY->value,
                PermissionEnum::VIEW_ANY_ACTIVITY_TYPE_POLICY->value,
                PermissionEnum::VIEW_ACTIVITY_TYPE_POLICY->value,
                PermissionEnum::CREATE_ACTIVITY_TYPE_POLICY->value,
            ],
            self::COMPANY_MANAGER => [
                PermissionEnum::CREATE_COMPANY->value,
                PermissionEnum::VIEW_ANY_ACTIVITY_TYPE_POLICY->value,
                PermissionEnum::VIEW_ACTIVITY_TYPE_POLICY->value,
                PermissionEnum::CREATE_ACTIVITY_TYPE_POLICY->value,
            ],
            default => [],
        };
    }
}
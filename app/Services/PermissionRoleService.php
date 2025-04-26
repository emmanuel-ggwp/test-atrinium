<?php

namespace App\Services;

use App\Enums\PermissionEnum;
use App\Enums\RoleEnum;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionRoleService
{
    public static function setup(): void
    {
        self::createPermissions();
        self::createRoles();
    }

    public static function createPermissions(): void
    {
        foreach (PermissionEnum::cases() as $permission) {
            Permission::firstOrCreate(['name' => $permission->value]);
        }
    }

    public static function createRoles(): void
    {
        foreach (RoleEnum::cases() as $role) {
            $roleModel = Role::firstOrCreate(['name' => $role->value]);
            $roleModel->syncPermissions($role->defaultPermissions());
        }
    }
}
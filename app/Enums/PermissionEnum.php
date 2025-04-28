<?php

namespace App\Enums;

enum PermissionEnum: string
{
    case VIEW_USER = 'view-user';
    case VIEW_ANY_USERS = 'view-users';
    case CREATE_USER = 'create-user';
    case UPDATE_USER = 'update-user';
    case DELETE_USER = 'delete-user';
    case ASSIGN_ROLES_USER = 'assign-roles-user';
    case RESOLVE_ROLE_APPEAL = 'resolve-role-appeal';
    case VIEW_COMPANY = 'view-company';
    case VIEW_ANY_COMPANIES = 'view-companies';
    case CREATE_COMPANY = 'create-company';
    case UPDATE_COMPANY = 'update-company';
    case DELETE_COMPANY = 'delete-company';
    case VIEW_ACTIVITY_TYPE_POLICY = 'view-activity-type';
    case VIEW_ANY_ACTIVITY_TYPE_POLICY = 'view-activity-types';
    case CREATE_ACTIVITY_TYPE_POLICY = 'create-activity-type';

    public static function all(): array
    {
        return array_column(self::cases(), 'value');
    }
}
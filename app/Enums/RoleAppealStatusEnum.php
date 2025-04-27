<?php

namespace App\Enums;

enum RoleAppealStatusEnum: string
{
    case STATUS_PENDING = 'pending';
    case STATUS_ACEPTED = 'acepted';
    case STATUS_DECLINED = 'declined';

    public static function all(): array
    {
        return array_column(self::cases(), 'value');
    }
}
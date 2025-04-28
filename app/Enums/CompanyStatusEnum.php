<?php

namespace App\Enums;

enum CompanyStatusEnum: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';

    public static function all(): array
    {
        return array_column(self::cases(), 'value');
    }
}
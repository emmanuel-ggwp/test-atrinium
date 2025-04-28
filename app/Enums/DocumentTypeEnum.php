<?php

namespace App\Enums;

enum DocumentTypeEnum: string
{
    case DNI = 'dni';
    case CIF = 'cif';
    case NIE = 'nie';
    case NIF = 'nif';
    case PASSPORT = 'passport';
    case OTHER = 'other';

    public static function all(): array
    {
        return array_column(self::cases(), 'value');
    }
}
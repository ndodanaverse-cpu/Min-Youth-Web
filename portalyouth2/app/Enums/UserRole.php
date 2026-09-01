<?php

namespace App\Enums;

enum UserRole: string
{
    case Youth = 'youth';
    case Admin = 'admin';
    case ContentEditor = 'content-editor';

    public function label(): string
    {
        return match ($this) {
            self::Youth => 'Youth',
            self::Admin => 'Administrator',
            self::ContentEditor => 'Content Editor',
        };
    }

    public static function names(): array
    {
        return array_column(self::cases(), 'value');
    }
}

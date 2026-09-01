<?php

namespace App\Filament\Support\Concerns;

use Filament\Models\Contracts\FilamentUser;

trait YouthViewableManageable
{
    public static function canViewAny(): bool
    {
        return auth()->check();
    }

    public static function canView($record = null): bool
    {
        return auth()->check();
    }

    public static function canCreate(): bool
    {
        return self::canManage();
    }

    public static function canEdit($record = null): bool
    {
        return self::canManage();
    }

    public static function canDelete($record = null): bool
    {
        return self::canManage();
    }

    public static function canDeleteAny(): bool
    {
        return self::canManage();
    }

    public static function canForceDelete($record = null): bool
    {
        return self::canManage();
    }

    public static function canForceDeleteAny(): bool
    {
        return self::canManage();
    }

    public static function canRestore($record = null): bool
    {
        return self::canManage();
    }

    public static function canRestoreAny(): bool
    {
        return self::canManage();
    }

    protected static function canManage(): bool
    {
        $user = auth()->user();

        return $user instanceof FilamentUser && $user->isBackOfficeUser();
    }
}

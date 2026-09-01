<?php

namespace App\Filament\Support\Concerns;

use Filament\Models\Contracts\FilamentUser;

trait BackOfficeManageable
{
    public static function canViewAny(): bool
    {
        $user = auth()->user();

        return $user instanceof FilamentUser && $user->isBackOfficeUser();
    }

    public static function canCreate(): bool
    {
        return self::canViewAny();
    }

    public static function canEdit($record = null): bool
    {
        return self::canViewAny();
    }

    public static function canDelete($record = null): bool
    {
        return self::canViewAny();
    }

    public static function canDeleteAny(): bool
    {
        return self::canViewAny();
    }

    public static function canForceDelete($record = null): bool
    {
        return self::canViewAny();
    }

    public static function canForceDeleteAny(): bool
    {
        return self::canViewAny();
    }

    public static function canRestore($record = null): bool
    {
        return self::canViewAny();
    }

    public static function canRestoreAny(): bool
    {
        return self::canViewAny();
    }

    public static function canView($record = null): bool
    {
        return true;
    }
}

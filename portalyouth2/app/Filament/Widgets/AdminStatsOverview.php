<?php

namespace App\Filament\Widgets;

use App\Models\News;
use App\Models\Opportunity;
use App\Models\OpportunityApplication;
use App\Models\Programme;
use App\Models\User;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminStatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected ?string $pollingInterval = '30s';

    protected function getStats(): array
    {
        return [
            Stat::make('Registered Users', User::count())
                ->icon(Heroicon::OutlinedUsers)
                ->color('primary'),
            Stat::make('Programmes', Programme::count())
                ->icon(Heroicon::OutlinedAcademicCap)
                ->color('info'),
            Stat::make('Opportunities', Opportunity::count())
                ->icon(Heroicon::OutlinedBriefcase)
                ->color('warning'),
            Stat::make('Applications', OpportunityApplication::count())
                ->icon(Heroicon::OutlinedClipboardDocumentCheck)
                ->color('success'),
            Stat::make('News Stories', News::count())
                ->icon(Heroicon::OutlinedNewspaper)
                ->color('info'),
        ];
    }

    public static function canView(): bool
    {
        return auth()->user()?->isBackOfficeUser() ?? false;
    }
}

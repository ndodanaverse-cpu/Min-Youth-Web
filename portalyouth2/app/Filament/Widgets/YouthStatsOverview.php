<?php

namespace App\Filament\Widgets;

use App\Models\Opportunity;
use App\Models\Programme;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class YouthStatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected ?string $pollingInterval = '30s';

    protected function getStats(): array
    {
        $user = auth()->user();

        $openOpportunities = Opportunity::query()
            ->published()
            ->where(fn ($query) => $query
                ->whereNull('deadline_at')
                ->orWhere('deadline_at', '>', now()))
            ->count();

        return [
            Stat::make('My Applications', $user?->applications()->count() ?? 0)
                ->icon(Heroicon::OutlinedClipboardDocumentCheck)
                ->color('primary'),
            Stat::make('Open Opportunities', $openOpportunities)
                ->icon(Heroicon::OutlinedBriefcase)
                ->color('warning'),
            Stat::make('Available Programmes', Programme::published()->count())
                ->icon(Heroicon::OutlinedAcademicCap)
                ->color('info'),
        ];
    }

    public static function canView(): bool
    {
        return auth()->check() && ! (auth()->user()?->isBackOfficeUser() ?? false);
    }
}

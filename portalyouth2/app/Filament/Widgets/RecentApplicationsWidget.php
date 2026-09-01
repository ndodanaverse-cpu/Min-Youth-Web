<?php

namespace App\Filament\Widgets;

use App\Enums\ApplicationStatus;
use App\Models\OpportunityApplication;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class RecentApplicationsWidget extends TableWidget
{
    protected static ?int $sort = 2;

    protected ?string $pollingInterval = '30s';

    protected function getTableQuery(): Builder
    {
        return OpportunityApplication::query()
            ->with(['opportunity', 'user'])
            ->latest('submitted_at');
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading('Recent Applications')
            ->defaultPaginationPageOption(5)
            ->columns([
                TextColumn::make('user.name')
                    ->label('Applicant')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('opportunity.title')
                    ->label('Opportunity')
                    ->searchable()
                    ->limit(40),
                TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn (ApplicationStatus $state): string => $state->label())
                    ->color(fn (ApplicationStatus $state): string => $state->color())
                    ->sortable(),
                TextColumn::make('submitted_at')
                    ->dateTime()
                    ->sortable(),
            ]);
    }

    public static function canView(): bool
    {
        return auth()->user()?->isBackOfficeUser() ?? false;
    }
}

<?php

namespace App\Filament\Widgets;

use App\Enums\ApplicationStatus;
use App\Models\OpportunityApplication;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class YouthRecentApplicationsWidget extends TableWidget
{
    protected static ?int $sort = 2;

    protected ?string $pollingInterval = '30s';

    protected function getTableQuery(): Builder
    {
        return OpportunityApplication::query()
            ->where('user_id', auth()->id())
            ->with(['opportunity'])
            ->latest('submitted_at');
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading('My Recent Applications')
            ->defaultPaginationPageOption(5)
            ->columns([
                TextColumn::make('opportunity.title')
                    ->label('Opportunity')
                    ->searchable()
                    ->limit(50),
                TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn (ApplicationStatus $state): string => $state->label())
                    ->color(fn (ApplicationStatus $state): string => $state->color()),
                TextColumn::make('submitted_at')
                    ->dateTime()
                    ->sortable(),
            ]);
    }

    public static function canView(): bool
    {
        return auth()->check() && ! (auth()->user()?->isBackOfficeUser() ?? false);
    }
}

<?php

namespace App\Filament\Resources\OpportunityApplications;

use App\Filament\Resources\OpportunityApplications\Pages\CreateOpportunityApplication;
use App\Filament\Resources\OpportunityApplications\Pages\EditOpportunityApplication;
use App\Filament\Resources\OpportunityApplications\Pages\ListOpportunityApplications;
use App\Filament\Resources\OpportunityApplications\Schemas\OpportunityApplicationForm;
use App\Filament\Resources\OpportunityApplications\Tables\OpportunityApplicationsTable;
use App\Filament\Support\Concerns\YouthViewableManageable;
use App\Models\OpportunityApplication;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class OpportunityApplicationResource extends Resource
{
    use YouthViewableManageable;

    protected static ?string $model = OpportunityApplication::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentCheck;

    public static function getNavigationLabel(): string
    {
        return auth()->user()?->isBackOfficeUser() ? 'Applications' : 'My Applications';
    }

    public static function getNavigationGroup(): ?string
    {
        return auth()->user()?->isBackOfficeUser() ? 'Content' : 'My Youth';
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->when(
                ! auth()->user()?->isBackOfficeUser(),
                fn (Builder $query) => $query->where('user_id', auth()->id()),
            );
    }

    public static function form(Schema $schema): Schema
    {
        return OpportunityApplicationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return OpportunityApplicationsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListOpportunityApplications::route('/'),
            'create' => CreateOpportunityApplication::route('/create'),
            'edit' => EditOpportunityApplication::route('/{record}/edit'),
        ];
    }
}

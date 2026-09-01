<?php

namespace App\Filament\Resources\SuccessStories;

use App\Filament\Resources\SuccessStories\Pages\CreateSuccessStory;
use App\Filament\Resources\SuccessStories\Pages\EditSuccessStory;
use App\Filament\Resources\SuccessStories\Pages\ListSuccessStories;
use App\Filament\Resources\SuccessStories\Schemas\SuccessStoryForm;
use App\Filament\Resources\SuccessStories\Tables\SuccessStoriesTable;
use App\Models\SuccessStory;
use App\Filament\Support\Concerns\ManageableByBackOffice;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SuccessStoryResource extends Resource
{
    use ManageableByBackOffice;

    protected static ?string $model = SuccessStory::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSparkles;

    public static function getNavigationLabel(): string
    {
        return 'Success Stories';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Content';
    }

    public static function form(Schema $schema): Schema
    {
        return SuccessStoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SuccessStoriesTable::configure($table);
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
            'index' => ListSuccessStories::route('/'),
            'create' => CreateSuccessStory::route('/create'),
            'edit' => EditSuccessStory::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}

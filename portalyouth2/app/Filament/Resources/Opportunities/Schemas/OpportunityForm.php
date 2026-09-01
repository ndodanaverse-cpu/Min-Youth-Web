<?php

namespace App\Filament\Resources\Opportunities\Schemas;

use App\Enums\ContentStatus;
use App\Enums\OpportunityCategory;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class OpportunityForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                Select::make('category')
                    ->options(OpportunityCategory::class)
                    ->required(),
                Textarea::make('summary')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('eligibility')
                    ->columnSpanFull(),
                TextInput::make('funding_amount'),
                TextInput::make('organizer'),
                Select::make('province_id')
                    ->relationship('province', 'name'),
                Select::make('district_id')
                    ->relationship('district', 'name'),
                FileUpload::make('image_url')
                    ->image(),
                TextInput::make('apply_url')
                    ->url(),
                DateTimePicker::make('deadline_at'),
                Select::make('status')
                    ->options(ContentStatus::class)
                    ->default(ContentStatus::Draft->value)
                    ->required(),
                Toggle::make('is_featured')
                    ->required(),
                TextInput::make('created_by')
                    ->default(fn () => auth()->id())
                    ->disabled(fn (string $operation): bool => $operation === 'edit')
                    ->dehydrated()
                    ->label('Created by'),
                DateTimePicker::make('published_at'),
            ]);
    }
}

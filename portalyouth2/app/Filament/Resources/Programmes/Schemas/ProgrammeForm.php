<?php

namespace App\Filament\Resources\Programmes\Schemas;

use App\Enums\ContentStatus;
use App\Enums\ProgrammeCategory;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ProgrammeForm
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
                    ->options(ProgrammeCategory::class)
                    ->required(),
                Textarea::make('summary')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('description')
                    ->columnSpanFull(),
                TextInput::make('icon'),
                FileUpload::make('image_url')
                    ->image(),
                Select::make('status')
                    ->options(ContentStatus::class)
                    ->default(ContentStatus::Draft->value)
                    ->required(),
                Toggle::make('is_featured')
                    ->required(),
                TextInput::make('sort_order')
                    ->required()
                    ->numeric()
                    ->default(0),
                DateTimePicker::make('published_at'),
            ]);
    }
}

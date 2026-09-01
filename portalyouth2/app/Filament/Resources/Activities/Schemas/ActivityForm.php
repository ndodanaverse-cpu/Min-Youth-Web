<?php

namespace App\Filament\Resources\Activities\Schemas;

use App\Enums\ActivityType;
use App\Enums\ContentStatus;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ActivityForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                Select::make('type')
                    ->options(ActivityType::class)
                    ->required(),
                Textarea::make('summary')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('description')
                    ->columnSpanFull(),
                TextInput::make('venue'),
                TextInput::make('location'),
                Select::make('province_id')
                    ->relationship('province', 'name'),
                DateTimePicker::make('starts_at'),
                DateTimePicker::make('ends_at'),
                TextInput::make('capacity')
                    ->numeric(),
                FileUpload::make('image_url')
                    ->image(),
                Select::make('status')
                    ->options(ContentStatus::class)
                    ->default(ContentStatus::Draft->value)
                    ->required(),
                Toggle::make('is_featured')
                    ->required(),
            ]);
    }
}

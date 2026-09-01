<?php

namespace App\Filament\Resources\SuccessStories\Schemas;

use App\Enums\ContentStatus;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class SuccessStoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('age')
                    ->numeric(),
                Select::make('province_id')
                    ->relationship('province', 'name'),
                Select::make('programme_id')
                    ->relationship('programme', 'title'),
                TextInput::make('role'),
                TextInput::make('photo'),
                Textarea::make('testimonial')
                    ->required()
                    ->columnSpanFull(),
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

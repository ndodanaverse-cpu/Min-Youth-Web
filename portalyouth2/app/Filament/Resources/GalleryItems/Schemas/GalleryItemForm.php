<?php

namespace App\Filament\Resources\GalleryItems\Schemas;

use App\Enums\ContentStatus;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class GalleryItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('caption'),
                FileUpload::make('image_url')
                    ->image(),
                Select::make('status')
                    ->options(ContentStatus::class)
                    ->default(ContentStatus::Draft->value)
                    ->required(),
                TextInput::make('sort_order')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}

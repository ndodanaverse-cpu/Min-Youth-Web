<?php

namespace App\Filament\Resources\Campaigns\Schemas;

use App\Enums\CampaignType;
use App\Enums\ContentStatus;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CampaignForm
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
                    ->options(CampaignType::class)
                    ->required(),
                Toggle::make('is_flagship')
                    ->required(),
                Textarea::make('summary')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('content')
                    ->columnSpanFull(),
                FileUpload::make('hero_image')
                    ->image(),
                Repeater::make('stats')
                    ->label('Key stats')
                    ->schema([
                        TextInput::make('label')->required(),
                        TextInput::make('value')->required(),
                    ])
                    ->default([])
                    ->addActionLabel('Add stat')
                    ->columnSpanFull(),
                Repeater::make('videos')
                    ->schema([
                        TextInput::make('title')->required(),
                        TextInput::make('url')->url()->required(),
                    ])
                    ->default([])
                    ->addActionLabel('Add video')
                    ->columnSpanFull(),
                Repeater::make('support_services')
                    ->schema([
                        TextInput::make('name')->required(),
                        Textarea::make('description'),
                        TextInput::make('phone'),
                    ])
                    ->default([])
                    ->addActionLabel('Add service')
                    ->columnSpanFull(),
                Repeater::make('emergency_contacts')
                    ->schema([
                        TextInput::make('name')->default('Helpline'),
                        TextInput::make('number')->required(),
                    ])
                    ->default([])
                    ->addActionLabel('Add contact')
                    ->columnSpanFull(),
                Select::make('status')
                    ->options(ContentStatus::class)
                    ->default(ContentStatus::Draft->value)
                    ->required(),
                TextInput::make('sort_order')
                    ->required()
                    ->numeric()
                    ->default(0),
                DateTimePicker::make('published_at'),
            ]);
    }
}

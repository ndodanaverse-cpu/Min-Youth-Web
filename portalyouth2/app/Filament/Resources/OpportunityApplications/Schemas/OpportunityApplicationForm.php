<?php

namespace App\Filament\Resources\OpportunityApplications\Schemas;

use App\Enums\ApplicationStatus;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class OpportunityApplicationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('opportunity_id')
                    ->relationship('opportunity', 'title')
                    ->required(),
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Select::make('status')
                    ->options(ApplicationStatus::class)
                    ->default('submitted')
                    ->required(),
                Textarea::make('cover_note')
                    ->columnSpanFull(),
                DateTimePicker::make('submitted_at'),
                Select::make('reviewed_by')
                    ->relationship('reviewer', 'name')
                    ->label('Reviewed by'),
                DateTimePicker::make('reviewed_at'),
                Textarea::make('admin_notes')
                    ->columnSpanFull(),
            ]);
    }
}

<?php

namespace App\Filament\Resources\OpportunityApplications\Pages;

use App\Filament\Resources\OpportunityApplications\OpportunityApplicationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListOpportunityApplications extends ListRecords
{
    protected static string $resource = OpportunityApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

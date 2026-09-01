<?php

namespace App\Filament\Resources\OpportunityApplications\Pages;

use App\Filament\Resources\OpportunityApplications\OpportunityApplicationResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditOpportunityApplication extends EditRecord
{
    protected static string $resource = OpportunityApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}

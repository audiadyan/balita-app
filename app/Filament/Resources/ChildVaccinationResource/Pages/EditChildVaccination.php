<?php

namespace App\Filament\Resources\ChildVaccinationResource\Pages;

use App\Filament\Resources\ChildVaccinationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditChildVaccination extends EditRecord
{
    protected static string $resource = ChildVaccinationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

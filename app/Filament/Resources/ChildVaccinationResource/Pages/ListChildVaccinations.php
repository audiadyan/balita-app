<?php

namespace App\Filament\Resources\ChildVaccinationResource\Pages;

use App\Filament\Resources\ChildVaccinationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListChildVaccinations extends ListRecords
{
    protected static string $resource = ChildVaccinationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Resources\PosyanduScheduleResource\Pages;

use App\Filament\Resources\PosyanduScheduleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPosyanduSchedules extends ListRecords
{
    protected static string $resource = PosyanduScheduleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

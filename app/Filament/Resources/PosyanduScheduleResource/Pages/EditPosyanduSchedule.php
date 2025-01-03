<?php

namespace App\Filament\Resources\PosyanduScheduleResource\Pages;

use App\Filament\Resources\PosyanduScheduleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPosyanduSchedule extends EditRecord
{
    protected static string $resource = PosyanduScheduleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

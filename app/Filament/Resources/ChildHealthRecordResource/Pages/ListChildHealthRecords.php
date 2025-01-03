<?php

namespace App\Filament\Resources\ChildHealthRecordResource\Pages;

use App\Filament\Resources\ChildHealthRecordResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListChildHealthRecords extends ListRecords
{
    protected static string $resource = ChildHealthRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

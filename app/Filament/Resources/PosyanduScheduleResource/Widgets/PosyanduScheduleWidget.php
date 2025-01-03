<?php

namespace App\Filament\Resources\PosyanduScheduleResource\Widgets;

use App\Models\PosyanduSchedule;
use Carbon\Carbon;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class PosyanduScheduleWidget extends BaseWidget
{
    protected static ?string $heading = 'Jadwal Posyandu Yang Akan Datang';

    protected static ?string $description = 'Lihat jadwal posyandu yang akan datang.';

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                PosyanduSchedule::query()
                    ->where('schedule_date', '>=', Carbon::today())
                    ->orderBy('schedule_date', 'asc')
                    ->orderBy('schedule_time', 'asc')
                    ->take(10)
            )
            ->columns([
                TextColumn::make('schedule_date')
                    ->label('Tanggal Posyandu')
                    ->date(),

                TextColumn::make('schedule_time')
                    ->label('Jam')
                    ->time(),

                TextColumn::make('vaccine.name')
                    ->label('Jenis Vaksin'),

                TextColumn::make('location')
                    ->label('Lokasi'),

                TextColumn::make('description')
                    ->label('Deskripsi')
                    ->limit(30)
                    ->tooltip(fn ($record) => $record->description)
            ])
            ->paginated(false);
    }
}

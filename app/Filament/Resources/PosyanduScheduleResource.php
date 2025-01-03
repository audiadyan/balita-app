<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PosyanduScheduleResource\Pages;
use App\Filament\Resources\PosyanduScheduleResource\RelationManagers;
use App\Models\PosyanduSchedule;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PosyanduScheduleResource extends Resource
{
    protected static ?string $model = PosyanduSchedule::class;

    protected static ?string $navigationGroup = 'Data';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                DatePicker::make('schedule_date')
                    ->required()
                    ->label('Tanggal')
                    ->default(Carbon::today())
                    ->minDate(Carbon::today()),

                TimePicker::make('schedule_time')
                    ->required()
                    ->label('Jam'),

                Select::make('vaccine_id')
                    ->required()
                    ->label('Jenis Vaksin')
                    ->relationship(name: 'vaccine', titleAttribute: 'name')
                    ->searchable()
                    ->preload(),

                TextInput::make('location')
                    ->required()
                    ->label('Lokasi')
                    ->placeholder('Masukkan Lokasi Posyandu'),

                Textarea::make('description')
                    ->label('Deskripsi')
                    ->placeholder('Opsional'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('schedule_date')
                    ->label('Tanggal Posyandu')
                    ->date()
                    ->sortable(),

                TextColumn::make('schedule_time')
                    ->label('Jam')
                    ->time()
                    ->sortable(),

                TextColumn::make('vaccine.name')
                    ->label('Jenis Vaksin')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('location')
                    ->label('Lokasi')
                    ->searchable(),

                TextColumn::make('description')
                    ->label('Deskripsi')
                    ->limit(30)
                    ->tooltip(fn ($record) => $record->description),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosyanduSchedules::route('/'),
            'create' => Pages\CreatePosyanduSchedule::route('/create'),
            'edit' => Pages\EditPosyanduSchedule::route('/{record}/edit'),
        ];
    }

    public static function getLabel(): string
    {
        return "Posyandu";
    }
}

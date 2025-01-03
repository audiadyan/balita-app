<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ChildVaccinationResource\Pages;
use App\Filament\Resources\ChildVaccinationResource\RelationManagers;
use App\Models\ChildVaccination;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ChildVaccinationResource extends Resource
{
    protected static ?string $model = ChildVaccination::class;

    protected static ?string $navigationGroup = 'Data';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('child_id')
                    ->required()
                    ->label('Balita')
                    ->relationship(name: 'child', titleAttribute: 'name')
                    ->searchable(['name'])
                    ->preload(),

                Select::make('vaccine_id')
                    ->required()
                    ->label('Jenis Vaksin')
                    ->relationship(name: 'vaccine', titleAttribute: 'name')
                    ->searchable()
                    ->preload(),

                DatePicker::make('vaccine_date')
                    ->required()
                    ->label('Tanggal Vaksin')
                    ->placeholder('Pilih tanggal lahir')
                    ->default(Carbon::today())
                    ->maxDate(Carbon::today()),

                Textarea::make('notes')
                    ->label('Keterangan')
                    ->placeholder('Opsional'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('child.name')
                    ->label('Nama Balita')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('vaccine_date')
                    ->label('Tanggal Vaksin')
                    ->date()
                    ->sortable(),

                TextColumn::make('vaccine.name')
                    ->label('Jenis Vaksin')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('notes')
                    ->label('Deskripsi')
                    ->limit(50)
                    ->tooltip(fn ($record) => $record->description)
                    ->searchable(),
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
            'index' => Pages\ListChildVaccinations::route('/'),
            'create' => Pages\CreateChildVaccination::route('/create'),
            'edit' => Pages\EditChildVaccination::route('/{record}/edit'),
        ];
    }

    public static function getLabel(): string
    {
        return "Vaksinasi";
    }
}

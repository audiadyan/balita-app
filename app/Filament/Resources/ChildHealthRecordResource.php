<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ChildHealthRecordResource\Pages;
use App\Filament\Resources\ChildHealthRecordResource\RelationManagers;
use App\Models\ChildHealthRecord;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ChildHealthRecordResource extends Resource
{
    protected static ?string $model = ChildHealthRecord::class;

    protected static ?string $navigationGroup = 'Data';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        function calculateBmi(callable $get, callable $set): void
        {
            $weight = $get('weight'); // Ambil nilai berat badan
            $height = $get('height'); // Ambil nilai tinggi badan

            if (!$weight || !$height || $height <= 0) {
                $set('bmi', null); // Jika nilai tidak valid, kosongkan BMI
                return;
            }

            $heightInMeters = $height / 100; // Konversi tinggi ke meter
            $bmi = $weight / ($heightInMeters * $heightInMeters); // Rumus BMI

            $set('bmi', round($bmi, 2)); // Set nilai BMI dengan 2 desimal
        }

        return $form
            ->schema([
                Select::make('child_id')
                    ->required()
                    ->label('Balita')
                    ->relationship(name: 'child', titleAttribute: 'name')
                    ->searchable(['name'])
                    ->preload(),

                DatePicker::make('record_date')
                    ->required()
                    ->label('Tanggal')
                    ->default(Carbon::today())
                    ->maxDate(Carbon::today()),

                TextInput::make('weight')
                    ->required()
                    ->label('Berat (Kg)')
                    ->numeric()
                    ->minValue(0)
                    ->placeholder("Berat badan dalam Kg")
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        return calculateBmi($get, $set);
                    }),

                TextInput::make('height')
                    ->required()
                    ->label('Tinggi (Cm)')
                    ->numeric()
                    ->minValue(0)
                    ->placeholder("Tinggi badan dalam Cm")
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        return calculateBmi($get, $set);
                    }),

                TextInput::make('bmi')
                    ->required()
                    ->label('Indeks Masa Tubuh')
                    ->readOnly()
                    ->placeholder("Indeks Masa Tubuh"),

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

                TextColumn::make('child.age')
                    ->label('Usia (Bulan)'),

                TextColumn::make('child.birth_date')
                    ->label('Tanggal')
                    ->date(),

                TextColumn::make('weight')
                    ->label('Berat (Kg)'),

                TextColumn::make('height')
                    ->label('Tinggi (Cm)'),

                TextColumn::make('bmi')
                    ->label('IMT'),

                TextColumn::make('bmiStatus')
                    ->label('Status Gizi'),

                TextColumn::make('child.guardian.name')
                    ->label('Orang Tua')
                    ->sortable()
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
            'index' => Pages\ListChildHealthRecords::route('/'),
            'create' => Pages\CreateChildHealthRecord::route('/create'),
            'edit' => Pages\EditChildHealthRecord::route('/{record}/edit'),
        ];
    }

    public static function getLabel(): string
    {
        return "Indeks Masa Tubuh (IMT)";
    }
}

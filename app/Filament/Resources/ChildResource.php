<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ChildResource\Pages;
use App\Filament\Resources\ChildResource\RelationManagers;
use App\Models\Child;
use App\Models\Guardian;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Button;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ChildResource extends Resource
{
    protected static ?string $model = Child::class;

    protected static ?string $navigationGroup = 'Data';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getFormSchema(): array
    {
        return [
            // Input untuk nama
            TextInput::make('name')
                ->required() // Menandakan bahwa input ini wajib diisi
                ->label('Nama') // Label untuk input
                ->placeholder('Masukkan nama lengkap'), // Placeholder

            // Input untuk tanggal lahir
            DatePicker::make('birth_date')
                ->required() // Menandakan bahwa input ini wajib diisi
                ->label('Tanggal Lahir') // Label untuk input
                ->placeholder('Pilih tanggal lahir') // Placeholder
                ->maxDate(Carbon::today()), // Maksimal tanggal adalah hari ini

            // Pilihan untuk jenis kelamin
            Select::make('gender')
                ->required() // Menandakan bahwa input ini wajib diisi
                ->label('Jenis Kelamin') // Label untuk input
                ->options([
                    true => 'Laki-laki', // Pilihan untuk laki-laki
                    false => 'Perempuan', // Pilihan untuk perempuan
                ])
                ->placeholder('Pilih jenis kelamin'), // Placeholder
        ];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Grup untuk data orang tua
                Fieldset::make('Orang Tua')
                ->schema([
                    // Select untuk mencari ibu berdasarkan NIK atau Nama
                    Select::make('mother_id')
                        ->required()
                        ->label('Ibu')
                        ->relationship(name: 'mother', titleAttribute: 'name')
                        ->preload()
                        ->getOptionLabelFromRecordUsing(fn (Guardian $record) => "{$record->nik} - {$record->name}")
                        ->searchable(['name', 'nik'])
                        ->createOptionForm(static function () {
                            return GuardianResource::getFormSchema(false);
                        })
                        ->editOptionForm(static function () {
                            return GuardianResource::getFormSchema(false);
                        }),

                    // Select untuk mencari ayah berdasarkan NIK atau Nama
                    Select::make('father_id')
                        ->label('Ayah')
                        ->relationship(name: 'father', titleAttribute: 'name')
                        ->preload()
                        ->getOptionLabelFromRecordUsing(fn (Guardian $record) => "{$record->nik} - {$record->name}")
                        ->searchable(['name', 'nik'])
                        ->createOptionForm(static function () {
                            return GuardianResource::getFormSchema(true);
                        })
                        ->editOptionForm(static function () {
                            return GuardianResource::getFormSchema(true);
                        }),
                ]),

                // Grup untuk data balita
                Fieldset::make('Data Balita')
                ->schema(static::getFormSchema()),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Bayi')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('birth_date')
                    ->label('Tanggal Lahir')
                    ->date()
                    ->sortable(),

                TextColumn::make('age')
                    ->label('Usia (Bulan)'),

                TextColumn::make('gender')
                    ->label('Gender')
                    ->formatStateUsing(fn ($state) => $state ? 'Laki-laki' : 'Perempuan'),

                TextColumn::make('mother.name')
                    ->label('Nama Ibu'),

                TextColumn::make('father.name')
                    ->label('Nama Ayah'),
            ])
            ->filters([
                // Filter berdasarkan gender
                SelectFilter::make('gender')
                    ->label('Filter Gender')
                    ->options([
                        true => 'Laki-laki',
                        false => 'Perempuan',
                    ])
                    ->placeholder('Pilih Gender'),
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
            'index' => Pages\ListChildren::route('/'),
            'create' => Pages\CreateChild::route('/create'),
            'edit' => Pages\EditChild::route('/{record}/edit'),
        ];
    }

    public static function getLabel(): string
    {
        return "Balita";
    }
}

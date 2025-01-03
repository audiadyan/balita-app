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

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Select untuk mencari orang tua berdasarkan NIK atau Nama
                Select::make('guardian_id')
                    ->required()
                    ->label('Orang Tua')
                    ->relationship(name: 'guardian', titleAttribute: 'name')
                    ->preload()
                    ->getOptionLabelFromRecordUsing(fn (Guardian $record) => "{$record->nik} - {$record->name}")
                    ->searchable(['name', 'nik'])
                    ->createOptionForm([
                        TextInput::make('nik')
                            ->label('NIK')
                            ->placeholder('Masukkan NIK')
                            ->required(),

                        TextInput::make('name')
                            ->label('Nama')
                            ->placeholder('Masukkan Nama Orang Tua')
                            ->required(),

                        Textarea::make('address')
                            ->label('Alamat')
                            ->placeholder('Masukkan Alamat Orang Tua'),

                        TextInput::make('phone_number')
                            ->label('No. Telepon')
                            ->placeholder('Masukkan No. Telepon'),
                    ])
                    ->editOptionForm([
                        TextInput::make('nik')
                            ->label('NIK')
                            ->placeholder('Masukkan NIK')
                            ->required(),

                        TextInput::make('name')
                            ->label('Nama')
                            ->placeholder('Masukkan Nama Orang Tua')
                            ->required(),

                        Textarea::make('address')
                            ->label('Alamat')
                            ->placeholder('Masukkan Alamat Orang Tua'),

                        TextInput::make('phone_number')
                            ->label('No. Telepon')
                            ->placeholder('Masukkan No. Telepon'),
                    ]),


                // Grup untuk data balita
                Fieldset::make('Data Balita')
                ->schema([
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
                ]),
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

                TextColumn::make('guardian.name')
                    ->label('Nama Orang Tua'),
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

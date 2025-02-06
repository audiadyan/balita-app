<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GuardianResource\Pages;
use App\Filament\Resources\GuardianResource\RelationManagers;
use App\Filament\Resources\GuardianResource\RelationManagers\ChildrenRelationManager;
use App\Models\Guardian;
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

class GuardianResource extends Resource
{
    protected static ?string $model = Guardian::class;

    protected static ?string $navigationGroup = 'Data Lainnya';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getFormSchema($defaultGender = null): array
    {
        return [
            TextInput::make('nik')
                ->label('NIK')
                ->placeholder('Masukkan NIK')
                ->required(),

            TextInput::make('name')
                ->label('Nama')
                ->placeholder('Masukkan Nama')
                ->required(),

            DatePicker::make('birth_date')
                ->label('Tanggal Lahir')
                ->placeholder('Opsional')
                ->maxDate(Carbon::today()),

            Select::make('gender')
                ->required()
                ->label('Jenis Kelamin')
                ->options([
                    true => 'Laki-laki',
                    false => 'Perempuan',
                ])
                ->placeholder('Pilih jenis kelamin')
                ->default($defaultGender)
                ->disabled(fn () => $defaultGender !== null)
                ->dehydrated(fn ($state) => $state !== null),

            Select::make('income')
                ->required()
                ->label('Penghasilan')
                ->options([
                    1 => 'Di bawah 1 juta',
                    2 => '1 - 4 juta',
                    3 => 'Di atas 4 juta',
                ])
                ->placeholder('Pilih salah satu'),

            TextInput::make('occupation')
                ->label('Pekerjaan')
                ->placeholder('Opsional'),

            TextInput::make('education')
                ->label('Pendidikan Terakhir')
                ->placeholder('Opsional'),

            TextInput::make('phone_number')
                ->label('No. Telepon')
                ->placeholder('Opsional'),

            Textarea::make('address')
                ->label('Alamat')
                ->placeholder('Masukkan Alamat')
                ->autosize(),
        ];
    }

    public static function form(Form $form): Form
    {
        return $form->schema(static::getFormSchema());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nik')
                    ->label('NIK')
                    ->searchable(),

                TextColumn::make('name')
                    ->label('Nama')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('age')
                    ->label('Usia (Tahun)'),

                TextColumn::make('gender')
                    ->label('Gender')
                    ->formatStateUsing(fn ($state) => $state ? 'Laki-laki' : 'Perempuan'),

                TextColumn::make('phone_number')
                    ->label('Telepon')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            ChildrenRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGuardians::route('/'),
            'create' => Pages\CreateGuardian::route('/create'),
            'edit' => Pages\EditGuardian::route('/{record}/edit'),
        ];
    }

    public static function getLabel(): string
    {
        return "Orang Tua";
    }
}

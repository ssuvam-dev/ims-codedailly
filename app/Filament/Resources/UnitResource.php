<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UnitResource\Pages;
use App\Filament\Resources\UnitResource\RelationManagers;
use App\Models\Unit;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UnitResource extends Resource
{
    protected static ?string $model = Unit::class;

    public static function getNavigationLabel(): string
    {
        return __("Manage Product Units");
    }

    protected static ?string $navigationGroup = 'Product Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        
                        Forms\Components\TextInput::make('name')
                            ->label(__("Unit Name"))
                            ->helperText(__("Kilogram, gram, meter"))
                            ->required(),

                        Forms\Components\TextInput::make("key")
                            ->label(__("Short Unit"))
                            ->helperText(__("Units in short form: Kg, g, m"))
                            ->required()
                            ->unique(ignoreRecord:true),

                        Forms\Components\KeyValue::make('data')
                            ->label(__("Extra Attributes"))
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make("key")
                    ->label(__("Key"))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make("name")
                    ->label(__("Name"))
                    ->searchable()
                    ->sortable(),
                
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUnits::route('/'),
            'create' => Pages\CreateUnit::route('/create'),
            'edit' => Pages\EditUnit::route('/{record}/edit'),
        ];
    }
}

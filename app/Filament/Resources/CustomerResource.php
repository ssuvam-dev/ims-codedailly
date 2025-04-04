<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Filament\Reusbales\CustomerForm;
use App\Models\Customer;
use App\Traits\CustomerForm as TraitsCustomerForm;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CustomerResource extends Resource
{
    use TraitsCustomerForm;
    protected static ?string $model = Customer::class;

    public static function getNavigationLabel(): string
    {
        return __("Customers");
    }

    protected static ?string $navigationGroup = 'Entities';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->columns(2)
                    ->schema(
                        self::getCustomerForm()
                    )
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make("name")
                    ->label(__("Customer Name"))
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make("email")
                    ->label(__("Email"))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make("contact")
                    ->label(__("Contact"))
                    ->searchable(),

                Tables\Columns\TextColumn::make("address")
                    ->label(__("Address"))
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }

    public static function getCustomerFormSchema()
    {
        return [
                Forms\Components\TextInput::make("name")
                    ->label(__("Name"))
                    ->required(),

                Forms\Components\TextInput::make("email")
                    ->label(__("Email"))
                    ->email(),

                Forms\Components\TextInput::make("contact")
                    ->label(__("Contact"))
                    ->required(),

                Forms\Components\TextInput::make("address")
                    ->label(__("Address")),

                Forms\Components\KeyValue::make("data")
                    ->label(__("Extra Details")),

        ];
    }
}

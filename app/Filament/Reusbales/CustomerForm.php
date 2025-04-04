<?php
namespace App\Filament\Reusbales;
use Filament\Forms;

class CustomerForm
{
    public static function make(): array
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
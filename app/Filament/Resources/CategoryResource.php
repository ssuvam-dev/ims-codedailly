<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    public static function getNavigationLabel(): string
    {
        return __("Manage Category");
    }

    protected static ?string $navigationGroup = 'Product Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                        ->label(__("Category Name"))
                        ->required()
                        ->reactive()
                        ->live(onBlur:true)
                        ->afterStateUpdated(function(Set $set,$state){
                            $slug = Str::slug($state);
                            $set('slug',$slug);
                        }),

                        Forms\Components\TextInput::make('slug')
                            ->label(__("Slug")),
    
                        Forms\Components\Textarea::make("description")
                            ->label(__("Description")),
        
                        Forms\Components\KeyValue::make("data")
                        ->label(__("Extra Attributes"))
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('order')
            ->defaultSort('order','asc')
            ->columns([
                Tables\Columns\TextColumn::make("name")
                    ->label(__("Name"))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('slug')
                    ->label(__('Slug'))
                    ->default('-'),

                Tables\Columns\TextColumn::make("created_at")
                    ->label(__("Created Date"))
                    ->sortable()
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}

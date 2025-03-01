<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Category;
use App\Models\Product;
use App\Models\Unit;
use App\Rules\UniqueProductInCategory;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\Indicator;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    public static function getNavigationLabel(): string
    {
        return __("Manage Products");
    }

    protected static ?string $navigationGroup = 'Product Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(self::getProductForm());
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('name')
                    ->label(__("Product Name"))
                    ->searchable()
                    ->sortable(),


                Tables\Columns\TextColumn::make('quantity')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('price')
                    ->label(__("Price"))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('safety_stock')
                    ->searchable()
                    ->sortable(),

            ])
            ->filters([                  
                Filter::make('price_range_filter')
                    ->form([
                        TextInput::make('from_price')
                            ->label(__("From Price"))
                            ->numeric(),

                        TextInput::make('to_price')
                            ->label(__("To Price"))
                            ->numeric()
                    ])
                    ->indicateUsing(function (array $data): array {
                        $indicators = [];
                 
                        if ($data['from_price'] ?? null) {
                            $indicators[] = Indicator::make('From Price '. $data['from_price'])
                                ->removeField('from_price')
                                ->removable(true);
                        }
                 
                        if ($data['to_price'] ?? null) {
                            $indicators[] = Indicator::make('To Price '. $data['to_price'])
                                ->removeField('to_price');
                        }
                 
                        return $indicators;
                    })
                    ->query(function(Builder $query, array $data):Builder{
                        return $query
                                ->when(
                                    $data['from_price'],
                                    fn(Builder $query, $price) :Builder=>$query->where('price','>=',$price)
                                )
                                ->when(
                                    $data['to_price'],
                                    fn(Builder $query, $price) :Builder=>$query->where('price','<=',$price)
                                );
                    })
                ],FiltersLayout::Modal)
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }

    public static function getProductForm()
    {
        return [
            Forms\Components\Section::make()
                        ->schema([
                            Forms\Components\TextInput::make("name")
                                ->label(__("Name"))
                                ->required()
                                ->rules(function(callable $get){
                                    return [
                                        new UniqueProductInCategory($get('category_id'))
                                    ];
                                }),

                            Forms\Components\TextInput::make('code')
                                ->label(__("Code"))
                                ->required(),

                            Forms\Components\Select::make("category_id")
                                ->searchable()
                                ->options(function(){
                                    $categories  = Category::pluck('name','id')->toArray();
                                    $createArr =  ["create_new"=> "Add New Category"];
                                    return $createArr + $categories;
                                })
                                ->dehydrated(function($state){
                                    return $state != "create_new";
                                })
                                ->reactive(),

                            Forms\Components\TextInput::make('category_name')
                                ->label(__("Category Name"))
                                ->visible(function(callable $get){
                                    return $get('category_id') == "create_new";
                                })
                                ->requiredIf('category_id','create_new'),
                                


                            Forms\Components\Select::make("unit_id")
                                ->options(Unit::pluck("name",'id')->toArray())
                                ->searchable()
                                ->required(),

                            Forms\Components\TextInput::make("price")
                                ->label(__("Price"))
                                ->required()
                                ->numeric(),

                            Forms\Components\TextInput::make("quantity")
                                ->label(__("Quantity"))
                                ->required()
                                ->numeric(),

                            Forms\Components\TextInput::make("safety_stock")
                                ->label(__("Safety Stock"))
                                ->helperText(__("Minimum stock to be stored."))
                                ->numeric()
                                ->required(),

                            Forms\Components\Textarea::make("description")
                                ->label(__("Description")),

                            Forms\Components\KeyValue::make("data")
                                ->label(__("Extra Properties")),
                            

                            
                        ])
                        ];
    }
}

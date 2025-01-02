<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PurchaseResource\Pages;
use App\Filament\Resources\PurchaseResource\RelationManagers;
use App\Filament\Resources\PurchaseResource\RelationManagers\ProductsRelationManager;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Unit;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Livewire\Component as Livewire;
use phpDocumentor\Reflection\Types\Callable_;

class PurchaseResource extends Resource
{
    protected static ?string $model = Purchase::class;

    protected static ?string $navigationIcon = 'heroicon-o-bolt';

    protected static ?string $navigationGroup = "Transactions";
    public static function getNavigationLabel(): string
    {
        return __("Purchase");
    }
    public static function form(Form $form): Form
    {
        /**
         * we will have 3 parts.
         * 1. about providers.
         * 2. Multiple products.
         * 3. Total and subtotal.
         */
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->columns(3)
                    ->heading("Provider Details")
                    ->schema([
                        Forms\Components\Select::make("provider_id")
                            ->relationship("provider", 'name')
                            ->createOptionForm(function () {
                                $tenantField = [
                                    Forms\Components\Hidden::make("tenant_id")
                                        ->default(Filament::getTenant()->id)
                                        ->label(__("Tenant"))
                                ];
                                return array_merge(CustomerResource::getCustomerFormSchema(), $tenantField);
                            })
                            ->required(),

                        Forms\Components\TextInput::make("invoice_no")
                            ->required(),

                        Forms\Components\DatePicker::make("purchase_date")
                            ->required()
                    ]),

                Forms\Components\Section::make()
                    ->heading("Prodcut Details")
                    ->schema([
                        Forms\Components\Repeater::make("product")
                            ->columns(4)
                            ->collapsible()
                            ->schema([
                                Forms\Components\Select::make("product_id")
                                    ->label(__("Product"))
                                    ->options(Product::pluck('name', 'id')->toArray())
                                    ->searchable()
                                    ->required()
                                    ->createOptionForm(function () {
                                        $tenantField = [
                                            Forms\Components\Hidden::make("tenant_id")
                                                ->default(Filament::getTenant()->id)
                                                ->label(__("Tenant"))
                                        ];
                                        return array_merge(ProductResource::getProductForm(), $tenantField);
                                    })
                                    ->createOptionUsing(function (array $data) {
                                        $product = Product::create($data);
                                        return $product->id;
                                    }),

                                Forms\Components\TextInput::make("price")
                                    ->required()
                                    ->numeric()
                                    ->reactive()
                                    ->afterStateUpdated(fn(Callable $get,Set $set)=>self::updateFormData($get,$set)),

                                Forms\Components\TextInput::make("quantity")
                                    ->required()
                                    ->numeric()
                                    ->reactive()
                                    ->afterStateUpdated(fn(Callable $get,Set $set)=>self::updateFormData($get,$set)),            

                                Forms\Components\TextInput::make("total")
                                    ->required()
                                    ->numeric()
                                    ->disabled()
                            ])
                    ]),

                Forms\Components\Section::make()
                    ->heading(__("Total Details"))
                    ->columns(3)
                    ->schema([
                        Forms\Components\TextInput::make("total_amount")
                            ->label(__("Sub Total"))
                            ->required()
                            ->numeric()
                            ,            
                            

                        Forms\Components\TextInput::make("discount")
                            ->label(__("Discount"))
                            ->default(0)
                            ->prefix("$")
                            ->required()
                            ->reactive()
                            ->numeric()
                            ->afterStateUpdated(function(callable $get,Set $set){
                                $discount = intval($get('discount')) ?? 0;
                                $totalAmount = intval($get("total_amount")) ?? 0;
                                $set('net_total',$totalAmount - $discount);
                            }),

                        Forms\Components\TextInput::make("net_total")
                            ->label(__("Net Total"))
                            ->required()
                        
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make("invoice_no")
                    ->label(__("Invoice No.")),

                Tables\Columns\TextColumn::make("provider.name")
                    ->label(__("Provider"))
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
            ProductsRelationManager::make()
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPurchases::route('/'),
            'create' => Pages\CreatePurchase::route('/create'),
            'edit' => Pages\EditPurchase::route('/{record}/edit'),
        ];
    }

    public static function updateFormData($get,$set)
    {
        // lets get all the form components..
        $formData = $get("../../");
        $allProdcuts = $formData['product'] ?? [];
        $grandTotal = 0;
        foreach($allProdcuts as $product)
        {
            $price = $product['price'] ?? 0;
            $quantity = $product['quantity'] ?? 0;
            $total = $price * $quantity;
            $grandTotal += $total;
        }
        $price  = $get("price");
        $quantity = $get("quantity");
        $total = $price * $quantity;
        $set('total', $total);
        $set("../../total_amount",$grandTotal);
        $discount = $get('../../discount');
        $set("../../net_total",$grandTotal - $discount);
    }
}

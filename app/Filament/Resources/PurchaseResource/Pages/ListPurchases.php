<?php

namespace App\Filament\Resources\PurchaseResource\Pages;

use App\Filament\Resources\PurchaseResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Resources\Pages\ListRecords;
use Filament\Forms;
class ListPurchases extends ListRecords
{
    protected static string $resource = PurchaseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Action::make('print')
                ->label('Print')
                ->icon('heroicon-o-printer')
                ->form([
                    Forms\Components\Section::make()
                    ->columns(2)
                    ->schema([
                        Forms\Components\DatePicker::make('start_date')
                            ->label('Start Date')
                            ->required(),
                    Forms\Components\DatePicker::make('end_date')
                        ->label('End Date')
                        ->required(),
                    ]),
                ])
                ->action(function(array $data){
                    return redirect()->route('PRINT_PDF',[
                        'tenant'=>Filament::getTenant()->id,
                        'start_date'=>$data['start_date'],
                        'end_date' => $data['end_date']
                    ]);
                })
        ];
    }
}

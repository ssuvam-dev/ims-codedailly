<?php

namespace App\Http\Controllers;

use App\Models\InvoiceRecord;
use App\Models\Purchase;
use Barryvdh\DomPDF\PDF;
use Filament\Notifications\Notification;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * records printing information and prints the invoice
     * @param $id
     */
    public function printPurchaseInvoice($id)
    {
        $purchase = Purchase::with(['provider','products'])->find($id);
        if($purchase)
        {
            // we will store printing records at first.
            InvoiceRecord::create([
                "user_id" => auth()->user()->id,
                'purchase_id'=>$id
            ]);

            // now for pdf..
            $pdf = \PDF::loadView('pdf.purchase_invoice',compact('purchase'));
            return $pdf->stream();
        }
        else
        {
            Notification::make()
                ->title("No Purchase Record Found..")
                ->danger()
                ->send();
            return redirect()->back();
        }
        
    }
}

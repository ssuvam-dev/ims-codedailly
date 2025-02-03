<?php

use App\Http\Controllers\InvoiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('{tenant}/print-invoice/{id}',[InvoiceController::class,'printPurchaseInvoice'])->name("PRINT.PURCHASE_INVOICE");
Route::get('/{tenant}/print_records',function(Request $request,$tenant){
    dd($request->all());
})->name('PRINT_PDF');
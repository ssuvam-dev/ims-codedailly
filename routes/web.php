<?php

use App\Http\Controllers\InvoiceController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('{tenant}/print-invoice/{id}',[InvoiceController::class,'printPurchaseInvoice'])->name("PRINT.PURCHASE_INVOICE");
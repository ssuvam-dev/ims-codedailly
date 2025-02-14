<?php

use App\Http\Controllers\InvoiceController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('{tenant}/print-invoice/{id}',[InvoiceController::class,'printPurchaseInvoice'])->name("PRINT.PURCHASE_INVOICE");
Route::get('/{tenant}/print_records',function(Request $request,$tenant){
    dd($request->all());
})->name('PRINT_PDF');

Route::get('check-answer', function() {
//    $user =User::orderBy('created_at', 'desc')->skip(1)->first();
//    $user = User::latest()->offset(2)->first();
//    $user = User::orderBy('created_at')->limit(2)->get()->last();
    // $user = User::orderByDesc('created_at')->take(2)->first();
    // dd($user);
});

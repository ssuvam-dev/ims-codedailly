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
    $data = User::withCount('posts')->orderByDesc('posts_count')->first();
    // $data= User::join('posts', 'users.id', '=', 'posts.user_id')->count();
    // $data = User::whereHas('posts')->orderBy('posts_count')->first();
    // $data = User::with('posts')->get()->max(fn($user) => $user->posts);
    dd($data);
});

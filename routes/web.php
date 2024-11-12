<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionController;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', [TransactionController::class, 'showForm'])->name('transactions.show');
Route::post('/transactions', [TransactionController::class, 'createTransaction'])->name('transactions.create');
Route::get('/fedapay/callback', [TransactionController::class, 'callback'])->name('fedapay.callback');

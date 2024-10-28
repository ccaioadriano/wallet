<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/transacoes', [App\Http\Controllers\TransacaoController::class, 'index'])->name('transacao-index');
Route::post('/transacoes', [App\Http\Controllers\TransacaoController::class, 'store'])->name('transacao-store');

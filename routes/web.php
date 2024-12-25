<?php

use App\Http\Controllers\TransacaoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ConfiguracaoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

// Rotas de Transações
Route::prefix('transacoes')->name('transacao-')->group(function () {
    Route::get('/', [TransacaoController::class, 'index'])->name('index');
    Route::post('/', [TransacaoController::class, 'store'])->name('store');
    Route::get('/{transacaoId}/edit', [TransacaoController::class, 'edit'])->name('edit');
    Route::put('/{transacaoId}/update', [TransacaoController::class, 'update'])->name('update');
    Route::delete('/{transacaoId}/delete', [TransacaoController::class, 'delete'])->name('delete');
});

// Rotas de Configurações
Route::prefix('configuracoes')->name('configuracao-')->group(function () {
    Route::get('/', [ConfiguracaoController::class, 'index'])->name('index');
    Route::post('/updateProfileImage', [ConfiguracaoController::class, 'updateProfileImage'])->name('atualiza-foto-perfil');
    Route::post('/adicionar-categoria', [ConfiguracaoController::class, 'addCategoria'])->name('adiciona-categoria');
});

// Rotas para JS
Route::post('recupera-informacao-grafico', [HomeController::class, 'recuperaInformacaoGrafico'])->name('recupera-informacao-grafico');

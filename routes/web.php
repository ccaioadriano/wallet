<?php

use App\Http\Controllers\TransacaoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/transacoes', [App\Http\Controllers\TransacaoController::class, 'index'])->name('transacao-index');
Route::post('/transacoes', [App\Http\Controllers\TransacaoController::class, 'store'])->name('transacao-store');

Route::get('/configuracoes', [App\Http\Controllers\ConfiguracaoController::class, 'index'])->name('configuracao-index');
Route::post('/configuracoes/updateProfileImage', [App\Http\Controllers\ConfiguracaoController::class, 'updateProfileImage'])->name('atualiza-foto-perfil');

Route::post('/adicionar-categoria', [App\Http\Controllers\ConfiguracaoController::class, 'addCategoria'])->name('adiciona-categoria');


Route::get('/transacoes/{transacaoId}/edit', [TransacaoController::class, 'edit'])->name('transacao-edit');
Route::put('/transacoes/{transacaoId}/update', [TransacaoController::class, 'update'])->name('transacao-update');
Route::delete('/transacoes/{transacaoId}/delete', [TransacaoController::class, 'delete'])->name('transacao-delete');

//rotas para js
Route::post("recupera-informacao-grafico", [App\Http\Controllers\HomeController::class, "recuperaInformacaoGrafico"])->name('recupera-informacao-grafico');

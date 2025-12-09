<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GerenciamentoDeFilaController;

Route::get('/filas', [GerenciamentoDeFilaController::class ,'index']);
Route::post('/filas/adicionarpedido', [GerenciamentoDeFilaController::class, 'adicionarpedido']);
Route::get('/filas/listarFila', [GerenciamentoDeFilaController::class, 'listarFila']);
Route::post('/filas/processarProximo', [GerenciamentoDeFilaController::class, 'processarPróximo']);


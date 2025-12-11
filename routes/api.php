<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GerenciamentoDeFilaController;
use App\Http\Controllers\UserController;

Route::get('/filas', [GerenciamentoDeFilaController::class ,'index']);
Route::post('/filas/adicionarpedido', [GerenciamentoDeFilaController::class, 'adicionarpedido']);
Route::get('/filas/listarFila', [GerenciamentoDeFilaController::class, 'listarFila']);
Route::post('/filas/processarProximo', [GerenciamentoDeFilaController::class, 'processarPróximo']);


Route::post('/usuario/criar', [UserController::class, 'criarusuario']);
Route::get('/usuario/listar', [App\Http\Controllers\UserController::class, 'listarUsuarios']);  



Route::post('/admin/criar', [App\Http\Controllers\UserController::class, 'criarAdmin']);

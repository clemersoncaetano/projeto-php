<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GerenciamentoDeFilaController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\ProdutoController;
use App\Http\Controllers\Admincontroller;

Route::post('/usuario/criar', [AdminController::class, 'criarUsuario']);
Route::get('/usuarios', [AdminController::class, 'listarUsuarios']);
Route::get('/usuario/{id}', [AdminController::class, 'mostrarUsuario']);
Route::put('/usuario/{id}', [AdminController::class, 'atualizarUsuario']);
Route::delete('/usuario/{id}', [AdminController::class, 'deletarUsuario']);

Route::post('/login', [AdminController::class, 'loginUsuario']);

// Admin
Route::post('/admin/criar', [AdminController::class, 'criarAdmin']);
Route::get('/admins', [AdminController::class, 'listarAdmins']);
Route::put('/admin/{id}', [AdminController::class, 'atualizarAdmin']);
Route::delete('/admin/{id}', [AdminController::class, 'deletarAdmin']);

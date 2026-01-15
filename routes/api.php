<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GerenciamentoDeCompraController;
use App\Http\Controllers\GerenciamentoDeFilaController;
use App\Http\Controllers\PagamentoController;


Route::post('/usuario/criar', [AdminController::class, 'criarUsuario']);
Route::post('/login', [AdminController::class, 'loginUsuario']);


Route::middleware('auth:sanctum')->group(function () {


    Route::get('/usuarios', [AdminController::class, 'listarUsuarios']);
    Route::get('/usuario/{id}', [AdminController::class, 'mostrarUsuario']);
    Route::put('/usuario/{id}', [AdminController::class, 'atualizarUsuario']);
    Route::delete('/usuario/{id}', [AdminController::class, 'deletarUsuario']);

    Route::post('/admin/criar', [AdminController::class, 'criarAdmin']);
    Route::get('/admins', [AdminController::class, 'listarAdmins']);
    Route::put('/admin/{id}', [AdminController::class, 'atualizarAdmin']);
    Route::delete('/admin/{id}', [AdminController::class, 'deletarAdmin']);


    Route::post('/compras', [GerenciamentoDeCompraController::class, 'criarCompra']);
    Route::get('/compras', [GerenciamentoDeCompraController::class, 'listarCompra']);
    Route::get('/compras/{id}', [GerenciamentoDeCompraController::class, 'mostrarCompra']);
    Route::delete('/compras/{id}', [GerenciamentoDeCompraController::class, 'deletarCompra']);
    Route::post('/compras/registrar', [GerenciamentoDeCompraController::class, 'registrarCompra']);

    Route::prefix('fila')->group(function () {
        Route::post('/', [GerenciamentoDeFilaController::class, 'adicionarNaFila']);
        Route::get('/', [GerenciamentoDeFilaController::class, 'listarFila']);
        Route::post('/proximo', [GerenciamentoDeFilaController::class, 'processarProximo']);
        Route::delete('/{id}', [GerenciamentoDeFilaController::class, 'remover']);
    });


Route::middleware('auth:sanctum')->group(function () {

    Route::post('/pagamentos', [PagamentoController::class, 'criar']);
    Route::post('/pagamentos/{id}/confirmar', [PagamentoController::class, 'confirmar']);

});

});

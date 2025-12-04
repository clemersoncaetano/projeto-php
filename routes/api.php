<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GerenciamentoDeFilaController;

Route::apiResource('/filas', GerenciamentoDeFilaController::class);

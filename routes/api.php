<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\CartaoFidelidadeController;

Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::get('validaToken', [AuthController::class, 'validaToken']);

    Route::get('clientes', [ClienteController::class, 'index']);
    Route::post('clientes/store', [ClienteController::class, 'store']);

    Route::get('empresas', [EmpresaController::class, 'index']);
    Route::post('empresas/store', [EmpresaController::class, 'store']);

    Route::post('cartoes/carimbar', [CartaoFidelidadeController::class, 'carimbar']);
});


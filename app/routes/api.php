<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ArticuloController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\AuthController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Rutas públicas
Route::post('login', [AuthController::class, 'login']);

// Rutas protegidas
Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);

    // Rutas de usuario SOLO para admin
    Route::middleware('admin')->group(function () {
        Route::get('usuario', [UsuarioController::class, 'index']);
        Route::get('usuario/{id}', [UsuarioController::class, 'show']);
        Route::post('usuario', [UsuarioController::class, 'store']);
        Route::put('usuario/{id}', [UsuarioController::class, 'update']);
        Route::delete('usuario/{id}', [UsuarioController::class, 'destroy']);
        Route::apiResource('usuarios', UsuarioController::class);
    });

    // Rutas de clientes, facturas, pedidos y artículos para cualquier usuario autenticado
    Route::apiResource('clientes', ClienteController::class);
    Route::apiResource('facturas', FacturaController::class);
    Route::apiResource('pedidos', PedidoController::class);
    Route::apiResource('articulos', ArticuloController::class);
});

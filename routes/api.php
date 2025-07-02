<?php

use Illuminate\Http\Request;
use Spatie\Permission\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

// Rota pública para login
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rotas protegidas para todos os usuários autenticados
Route::middleware('auth:api')->group(function () {
    Route::get('/teste', function (Request $request) {
        return response()->json(['message' => 'Rota protegida acessada com sucesso!', 'request' => request()->all()]);
    });
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Rotas que SÓ o admin pode acessar
    Route::middleware([RoleMiddleware::class.':admin'])->prefix('admin')->group(function () {
        Route::apiResource('users', UserController::class);
    });
});

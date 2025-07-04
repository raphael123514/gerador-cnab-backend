<?php

use App\Enums\ProfileEnum;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CNABController;
use App\Http\Controllers\FundController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Middleware\RoleMiddleware;

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth:api')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('funds', [FundController::class, 'index']);

    Route::controller(CNABController::class)->prefix('/cnab')->group(function () {
        Route::get('/', 'index');
        Route::get('/{processing}/download/{type}', 'download')
            ->where('type', 'excel|cnab');
    });

    Route::middleware([RoleMiddleware::class.':'.ProfileEnum::ADMIN->value])
        ->prefix('admin')
        ->group(function () {

            Route::apiResource('users', UserController::class);

            Route::controller(CNABController::class)->prefix('cnab')->group(function () {
                Route::post('/upload', 'upload');
            });
        });
});

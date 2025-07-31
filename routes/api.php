<?php

use App\Http\Controllers\Api\TokenAuthenticationController;
use App\Http\Controllers\Api\V1\ProfileController;
use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest'])->post('/login', [TokenAuthenticationController::class, 'store']);
Route::middleware(['auth:sanctum'])->post('/logout', [TokenAuthenticationController::class, 'destroy']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('v1')->group(function () {
        Route::namespace('App\Http\Controllers\Api\V1')->group(function () {
            Route::apiResource('users', UserController::class);
            Route::controller(ProfileController::class)->group(function () {
                Route::get('me', 'index')->middleware('verified');
                Route::put('me', 'update');
                Route::patch('me', 'update');
            });
        });
    });
});

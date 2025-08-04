<?php

use App\Http\Controllers\Api\V1\Auth\AuthenticationController;
use App\Http\Controllers\Api\V1\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Api\V1\Auth\NewPasswordController;
use App\Http\Controllers\Api\V1\Auth\PasswordResetLinkController;
use App\Http\Controllers\Api\V1\Auth\RegistrationController;
use App\Http\Controllers\Api\V1\Auth\VerifyEmailController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\PermissionController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\ProfileController;
use App\Http\Controllers\Api\V1\RoleController;
use App\Http\Controllers\Api\V1\TagController;
use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    // Guest Routes
    Route::middleware('guest')->group(function () {
        Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
        Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.store');
        Route::post('/register', [RegistrationController::class, 'store']);
        Route::post('/login', [AuthenticationController::class, 'store']);
    });

    // Authenticated Routes
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)
            ->middleware(['signed', 'throttle:6,1'])
            ->name('verification.verify');
        Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
            ->middleware(['throttle:6,1'])
            ->name('verification.send');

        // Logout Route
        Route::post('/logout', [AuthenticationController::class, 'destroy']);

        // Users Routes
        Route::apiResource('users', UserController::class);

        // Profile Routes
        Route::controller(ProfileController::class)->group(function () {
            Route::get('me', 'index')->middleware('verified');
            Route::put('me', 'update');
            Route::patch('me', 'update');
        });

        // Roles Routes
        Route::apiResource('roles', RoleController::class);
        Route::post('roles/{role}/assign', [RoleController::class, 'assignPermissions']);
        Route::post('roles/{role}/revoke', [RoleController::class, 'revokePermissions']);

        // Permissions Routes
        Route::apiResource('permissions', PermissionController::class);

        // Categories Routes
        Route::apiResource('categories', CategoryController::class);

        // Tags Routes
        Route::apiResource('tags', TagController::class);

        // Products Routes
        Route::apiResource('products', ProductController::class);
    });
});

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| All authentication endpoints use JavaScript/AJAX instead of traditional PHP POST
|
*/

Route::prefix('auth')->group(function () {
    // Authentication API Endpoints
    Route::post('/login', [AuthController::class, 'login'])->name('api.login');
    Route::post('/register', [AuthController::class, 'register'])->name('api.register');
    Route::post('/logout', [AuthController::class, 'logout'])->name('api.logout');
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('api.forgot-password');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('api.reset-password');

    // User info endpoint
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', [AuthController::class, 'user'])->name('api.user');
        Route::put('/update-profile', [AuthController::class, 'updateProfile'])->name('api.update-profile');
    });
});

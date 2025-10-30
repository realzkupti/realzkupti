<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\StickyNoteController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| All authentication endpoints use fetch API instead of traditional PHP POST
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

// Sticky Notes API (Protected)
Route::middleware('auth')->prefix('sticky-notes')->group(function () {
    Route::get('/', [StickyNoteController::class, 'index'])->name('api.sticky-notes.index');
    Route::post('/', [StickyNoteController::class, 'store'])->name('api.sticky-notes.store');
    Route::put('/{id}', [StickyNoteController::class, 'update'])->name('api.sticky-notes.update');
    Route::delete('/{id}', [StickyNoteController::class, 'destroy'])->name('api.sticky-notes.destroy');
    Route::post('/{id}/restore', [StickyNoteController::class, 'restore'])->name('api.sticky-notes.restore');
    Route::post('/bulk-update', [StickyNoteController::class, 'bulkUpdate'])->name('api.sticky-notes.bulk-update');
});

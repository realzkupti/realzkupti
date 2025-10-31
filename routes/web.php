<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\PermissionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Authentication Routes (Pages)
Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('forgot-password');
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot-password.post');
});

// Protected Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::put('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');

    // Admin Routes
    Route::prefix('admin')->name('admin.')->group(function () {
        // Users
        Route::get('/users', [UserController::class, 'index'])->name('users');
        Route::get('/users/list', [UserController::class, 'list'])->name('users.list');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
        Route::post('/users/{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');

        // Menus
        Route::get('/menus', [MenuController::class, 'index'])->name('menus');
        Route::get('/menus/list', [MenuController::class, 'list'])->name('menus.list');
        Route::get('/menus/list-flat', [MenuController::class, 'listFlat'])->name('menus.list-flat');
        Route::post('/menus', [MenuController::class, 'store'])->name('menus.store');
        Route::put('/menus/{id}', [MenuController::class, 'update'])->name('menus.update');
        Route::delete('/menus/{id}', [MenuController::class, 'destroy'])->name('menus.destroy');
        Route::post('/menus/{id}/toggle-status', [MenuController::class, 'toggleStatus'])->name('menus.toggle-status');
        Route::post('/menus/reorder', [MenuController::class, 'reorder'])->name('menus.reorder');

        // Departments
        Route::get('/departments', [DepartmentController::class, 'index'])->name('departments');
        Route::get('/departments/list', [DepartmentController::class, 'list'])->name('departments.list');
        Route::post('/departments', [DepartmentController::class, 'store'])->name('departments.store');
        Route::put('/departments/{id}', [DepartmentController::class, 'update'])->name('departments.update');
        Route::delete('/departments/{id}', [DepartmentController::class, 'destroy'])->name('departments.destroy');

        // Permissions
        Route::get('/permissions/departments', [PermissionController::class, 'departmentIndex'])->name('permissions.departments');
        Route::get('/permissions/departments/{id}', [PermissionController::class, 'getDepartmentPermissions'])->name('permissions.departments.get');
        Route::post('/permissions/departments/{id}', [PermissionController::class, 'saveDepartmentPermissions'])->name('permissions.departments.save');

        Route::get('/permissions/users', [PermissionController::class, 'userIndex'])->name('permissions.users');
        Route::get('/permissions/users/{id}', [PermissionController::class, 'getUserPermissions'])->name('permissions.users.get');
        Route::post('/permissions/users/{id}', [PermissionController::class, 'saveUserPermissions'])->name('permissions.users.save');
    });
});

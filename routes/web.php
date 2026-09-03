<?php

use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\ProfileController as UserProfileController;
use Illuminate\Support\Facades\Route;

// Public Root Redirect
Route::get('/', function () {
    return redirect()->route('login');
});

// ----------------------------------------------------
// Normal User Authentication & Registration Routes
// ----------------------------------------------------
Route::middleware('guest')->group(function () {
    Route::get('/login', [UserAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [UserAuthController::class, 'login']);

    Route::get('/register', [UserAuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [UserAuthController::class, 'register']);
});

Route::post('/logout', [UserAuthController::class, 'logout'])->name('logout')->middleware('auth');

// ----------------------------------------------------
// Admin Authentication Routes
// ----------------------------------------------------
Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login']);
    });

    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout')->middleware('auth');
});

// ----------------------------------------------------
// Normal User Protected Routes (IsUser Middleware)
// ----------------------------------------------------
Route::middleware(['auth', 'isUser'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [UserProfileController::class, 'show'])->name('profile');
    Route::put('/profile', [UserProfileController::class, 'update'])->name('profile.update');
    Route::put('/change-password', [UserProfileController::class, 'changePassword'])->name('password.change');
});

// Impersonate Leave Route (accessible while logged in as normal user)
Route::middleware('auth')->get('/admin/impersonate/leave', [AdminUserController::class, 'leaveImpersonate'])->name('admin.impersonate.leave');

// ----------------------------------------------------
// Admin Panel Protected Routes (IsAdmin Middleware)
// ----------------------------------------------------
Route::middleware(['isAdmin'])->prefix('admin')->name('admin.')->group(function () {
    // Admin Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Impersonation
    Route::get('/users/{user}/impersonate', [AdminUserController::class, 'impersonate'])->name('users.impersonate');

    // Status Toggle & Soft Delete/Restore
    Route::patch('/users/{user}/toggle-status', [AdminUserController::class, 'toggleStatus'])->name('users.toggle-status');
    Route::post('/users/{id}/restore', [AdminUserController::class, 'restore'])->name('users.restore');
    Route::delete('/users/{id}/force-delete', [AdminUserController::class, 'forceDelete'])->name('users.force-delete');

    // Users Resource (CRUD)
    Route::resource('users', AdminUserController::class);

    // Activity Logs
    Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');
});

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;

// Redirect root to dashboard or login
Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('login');
});

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Protected Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', function () {
        return view('profile');
    })->name('profile');
    
    // Transfer routes
    Route::get('/transfers', [\App\Http\Controllers\TransferController::class, 'index'])->name('transfers.index');
    Route::get('/transfers/create', [\App\Http\Controllers\TransferController::class, 'create'])->name('transfers.create');
    Route::post('/transfers', [\App\Http\Controllers\TransferController::class, 'store'])->name('transfers.store');
    Route::get('/transfers/{transfer}', [\App\Http\Controllers\TransferController::class, 'show'])->name('transfers.show');
    Route::get('/transfers/{transfer}/pdf', [\App\Http\Controllers\TransferController::class, 'generatePdf'])->name('transfers.pdf');
    Route::post('/transfers/{transfer}/return', [\App\Http\Controllers\TransferController::class, 'return'])->name('transfers.return');
    
    // Height Equipment routes
    Route::resource('height-equipment', \App\Http\Controllers\HeightEquipmentController::class);
    
    // IT Equipment routes
    Route::resource('it-equipment', \App\Http\Controllers\ITEquipmentController::class);
    
    // Employee routes
    Route::resource('employees', \App\Http\Controllers\EmployeeController::class);
    
    // Tools routes
    Route::resource('tools', \App\Http\Controllers\ToolController::class);
});

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/modules', [\App\Http\Controllers\Admin\AdminController::class, 'modules'])->name('modules');
    Route::put('/modules/{module}', [\App\Http\Controllers\Admin\AdminController::class, 'updateModule'])->name('modules.update');
    Route::get('/data-management', [\App\Http\Controllers\Admin\AdminController::class, 'dataManagement'])->name('data-management');
    Route::post('/clear-data', [\App\Http\Controllers\Admin\AdminController::class, 'clearData'])->name('clear-data');
    Route::get('/system-info', [\App\Http\Controllers\Admin\AdminController::class, 'systemInfo'])->name('system-info');
});

// Install Routes
Route::prefix('install')->name('install.')->group(function () {
    Route::get('/', [\App\Http\Controllers\InstallController::class, 'index'])->name('index');
    Route::get('/requirements', [\App\Http\Controllers\InstallController::class, 'requirements'])->name('requirements');
    Route::get('/database', [\App\Http\Controllers\InstallController::class, 'database'])->name('database');
    Route::post('/test-database', [\App\Http\Controllers\InstallController::class, 'testDatabase'])->name('test-database');
    Route::get('/admin', [\App\Http\Controllers\InstallController::class, 'admin'])->name('admin');
    Route::post('/install', [\App\Http\Controllers\InstallController::class, 'install'])->name('install');
});

// Password reset routes (placeholder)
Route::get('/password/request', function () {
    return view('auth.passwords.email');
})->name('password.request');

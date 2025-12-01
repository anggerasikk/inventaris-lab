<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Authentication Routes
Auth::routes();

// Public Routes
Route::get('/', function () {
    return Auth::check() ? redirect('/home') : view('welcome');
});

// Authenticated Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    // Dashboard Admin (IL-010)
     Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

});
    // Peminjaman untuk semua user
    Route::prefix('borrowings')->group(function () {
        Route::get('/create', [BorrowingController::class, 'create'])->name('borrowings.create');
        Route::post('/', [BorrowingController::class, 'store'])->name('borrowings.store');
        Route::get('/history', [BorrowingController::class, 'history'])->name('borrowings.history');
    });

    // Admin Only Routes
    Route::middleware(['admin'])->group(function () {
        // Items Management
        Route::resource('items', ItemController::class);
        
        // Borrowings Management
        Route::prefix('borrowings')->group(function () {
            Route::get('/', [BorrowingController::class, 'index'])->name('borrowings.index');
            Route::post('/{id}/approve', [BorrowingController::class, 'approve'])->name('borrowings.approve');
            Route::post('/{id}/reject', [BorrowingController::class, 'reject'])->name('borrowings.reject');
            Route::post('/{id}/mark-returned', [BorrowingController::class, 'markReturned'])->name('borrowings.mark-returned');
        });

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // Reports
        Route::prefix('reports')->group(function () {
            Route::get('/', [ReportController::class, 'index'])->name('reports.index');
            Route::post('/export', [ReportController::class, 'export'])->name('reports.export');
        });
    });
});
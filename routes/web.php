<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\AdminAuth;

// Authentication Routes
Auth::routes();

// Public Routes
Route::get('/', function () {
    return Auth::check() ? redirect('/home') : view('welcome');
});

// Authenticated Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    // Peminjaman untuk semua user
    Route::prefix('borrowings')->group(function () {
        Route::get('/create', [BorrowingController::class, 'create'])->name('borrowings.create');
        Route::post('/', [BorrowingController::class, 'store'])->name('borrowings.store');
        Route::get('/history', [BorrowingController::class, 'history'])->name('borrowings.history');
    });

    // Admin Only Routes
    Route::middleware([AdminAuth::class])->group(function () {
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
        
        // ========== TAMBAHAN ROUTE UNTUK ADMIN PANEL ==========
        // Route untuk admin dengan prefix /admin
        Route::prefix('admin')->group(function () {
            // Dashboard Admin khusus
            Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
            
            // Laporan Admin
            Route::get('/reports', [ReportController::class, 'adminIndex'])->name('admin.reports.index');
            Route::get('/reports/export', [ReportController::class, 'adminExport'])->name('admin.reports.export');
            
            // Borrowings khusus admin view
            Route::get('/borrowings', [BorrowingController::class, 'adminIndex'])->name('admin.borrowings.index');
            Route::get('/borrowings/history', [BorrowingController::class, 'adminHistory'])->name('admin.borrowings.history');
        });
        // ========== END TAMBAHAN ==========
    });
});
<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ThemeController;
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
    
    // Theme Routes
    Route::post('/api/theme/toggle', [ThemeController::class, 'toggle']);
    Route::get('/api/theme/preference', [ThemeController::class, 'getPreference']);

    // Lihat Barang untuk semua user (READ-ONLY)
    Route::get('/items', [ItemController::class, 'list'])->name('items.list');
    Route::get('/items/{item}', [ItemController::class, 'show'])->name('items.show');

    // Peminjaman untuk semua user
    Route::prefix('borrowings')->group(function () {
        Route::get('/create', [BorrowingController::class, 'create'])->name('borrowings.create');
        Route::post('/', [BorrowingController::class, 'store'])->name('borrowings.store');
        Route::get('/history', [BorrowingController::class, 'history'])->name('borrowings.history');
    });

    // Admin Only Routes
    Route::middleware([AdminAuth::class])->group(function () {
        // ========== SEMUA ROUTE ADMIN DENGAN PREFIX DAN NAME PREFIX ==========
        Route::prefix('admin')->name('admin.')->group(function () {
            // Dashboard Admin
            Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
            
            // Items Management (CRUD only for admin)
            Route::resource('items', ItemController::class)->except(['show']);
            // Ini akan membuat: admin.items.index, admin.items.create, admin.items.store, dll.
            
            // Borrowings khusus admin view
            Route::get('/borrowings', [BorrowingController::class, 'adminIndex'])->name('borrowings.index');
            Route::get('/borrowings/history', [BorrowingController::class, 'adminHistory'])->name('borrowings.history');
            
            // Laporan Admin
            Route::get('/reports', [ReportController::class, 'adminIndex'])->name('reports.index');
            Route::get('/reports/export', [ReportController::class, 'adminExport'])->name('reports.export');
        });
        
        // ========== ROUTE ADMIN TANPA PREFIX 'admin' ==========
        // Borrowings Management (tanpa prefix 'admin' di URL, tapi masih untuk admin)
        Route::prefix('borrowings')->group(function () {
            Route::get('/', [BorrowingController::class, 'index'])->name('borrowings.index');
            Route::post('/{id}/approve', [BorrowingController::class, 'approve'])->name('borrowings.approve');
            Route::post('/{id}/reject', [BorrowingController::class, 'reject'])->name('borrowings.reject');
            Route::post('/{id}/mark-returned', [BorrowingController::class, 'markReturned'])->name('borrowings.mark-returned');
        });

        // Dashboard umum (tanpa prefix 'admin')
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // Reports umum (tanpa prefix 'admin')
        Route::prefix('reports')->group(function () {
            Route::get('/', [ReportController::class, 'index'])->name('reports.index');
            Route::post('/export', [ReportController::class, 'export'])->name('reports.export');
        });
    });
});
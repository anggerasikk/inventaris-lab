<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Borrowing;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalItems = Item::count();
        $totalBorrowings = Borrowing::count();
        $pendingBorrowings = Borrowing::where('status', 'pending')->count();
        $approvedBorrowings = Borrowing::where('status', 'approved')->count();
        
        // Recent borrowings
        $recentBorrowings = Borrowing::with('item')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        // Borrowings by month (for chart)
        $borrowingsByMonth = Borrowing::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('count', 'month');
        
        // Low stock items
        $lowStockItems = Item::where('stock', '<', 5)
            ->orderBy('stock', 'asc')
            ->limit(5)
            ->get();
        
        return view('admin.dashboard', compact(
            'totalItems',
            'totalBorrowings',
            'pendingBorrowings',
            'approvedBorrowings',
            'recentBorrowings',
            'borrowingsByMonth',
            'lowStockItems'
        ));
    }
}
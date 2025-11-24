<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Borrowing;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_items' => Item::count(),
            'total_borrowings' => Borrowing::count(),
            'pending_borrowings' => Borrowing::pending()->count(),
            'active_users' => User::where('role', '!=', 'admin')->count(),
        ];

        // Chart data - peminjaman per bulan
        $monthlyBorrowings = Borrowing::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as count')
            )
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Recent activities
        $recentBorrowings = Borrowing::with(['user', 'item'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $borrowings = Borrowing::all();

        return view('dashboard.index', compact('stats', 'monthlyBorrowings', 'recentBorrowings', 'borrowings'));
    }
}
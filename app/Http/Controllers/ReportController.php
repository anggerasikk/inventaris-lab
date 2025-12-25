<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Item;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Borrowing::with(['user', 'item']);

        // Filter by date range
        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Filter by borrower type
        if ($request->has('borrower_type') && $request->borrower_type) {
            $query->where('borrower_type', $request->borrower_type);
        }

        $borrowings = $query->orderBy('created_at', 'desc')->get();

        return view('reports.index', compact('borrowings'));
    }

    public function export(Request $request)
    {
        // Logic untuk export PDF/Excel bisa ditambahkan di sini
        return back()->with('success', 'Fitur export akan segera tersedia.');
    }
}
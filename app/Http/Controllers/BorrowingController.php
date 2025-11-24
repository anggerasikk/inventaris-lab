<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BorrowingController extends Controller
{
    // Form peminjaman untuk mahasiswa/dosen
    public function create()
    {
        $items = Item::where('is_available', true)->get();
        return view('borrowings.create', compact('items'));
    }

    // Simpan peminjaman
    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_id' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:1',
            'purpose' => 'required|string|max:500',
            'borrow_date' => 'required|date|after_or_equal:today',
            'return_date' => 'required|date|after:borrow_date',
            'phone_number' => 'required|string|max:15'
        ]);

        $item = Item::findOrFail($request->item_id);

        // Cek ketersediaan
        if (!$item->canBeBorrowed($request->quantity)) {
            return back()->with('error', 'Item tidak tersedia atau stok tidak mencukupi.');
        }

        Borrowing::create([
            'user_id' => Auth::id(),
            'item_id' => $request->item_id,
            'quantity' => $request->quantity,
            'purpose' => $request->purpose,
            'borrow_date' => $request->borrow_date,
            'return_date' => $request->return_date,
            'borrower_type' => Auth::user()->isMahasiswa() ? 'mahasiswa' : 'dosen',
            'phone_number' => $request->phone_number,
            'status' => 'pending'
        ]);

        return redirect()->route('borrowings.history')
            ->with('success', 'Permohonan peminjaman berhasil diajukan!');
    }

    // Riwayat peminjaman user
    public function history()
    {
        $borrowings = Borrowing::where('user_id', Auth::id())
            ->with('item')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('borrowings.history', compact('borrowings'));
    }

    // ADMIN: List semua peminjaman
    public function index()
    {
        $borrowings = Borrowing::with(['user', 'item'])
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('borrowings.index', compact('borrowings'));
    }

    // ADMIN: Approve peminjaman
    public function approve($id)
    {
        $borrowing = Borrowing::findOrFail($id);
        $borrowing->update(['status' => 'approved']);

        return back()->with('success', 'Peminjaman disetujui!');
    }

    // ADMIN: Reject peminjaman
    public function reject(Request $request, $id)
    {
        $request->validate(['admin_notes' => 'required|string|max:500']);
        
        $borrowing = Borrowing::findOrFail($id);
        $borrowing->update([
            'status' => 'rejected',
            'admin_notes' => $request->admin_notes
        ]);

        return back()->with('success', 'Peminjaman ditolak!');
    }

    // ADMIN: Mark as returned
    public function markReturned($id)
    {
        $borrowing = Borrowing::findOrFail($id);
        $borrowing->update([
            'status' => 'returned',
            'actual_return_date' => now()
        ]);

        return back()->with('success', 'Item telah dikembalikan!');
    }
}
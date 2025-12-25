<?php

namespace App\Observers;

use App\Models\Borrowing;

class BorrowingObserver
{
    /**
     * Handle the Borrowing "updated" event.
     */
    public function updated(Borrowing $borrowing): void
    {
        // Jika status berubah menjadi 'approved', kurangi stok item
        if ($borrowing->isDirty('status') && $borrowing->status === 'approved') {
            $item = $borrowing->item;
            $item->decrement('quantity', $borrowing->quantity);
        }

        // Jika status berubah menjadi 'returned', tambah stok item
        if ($borrowing->isDirty('status') && $borrowing->status === 'returned') {
            $item = $borrowing->item;
            $item->increment('quantity', $borrowing->quantity);
        }

        // Jika status berubah menjadi 'rejected' atau 'cancelled', 
        // pastikan stok tidak berubah (karena belum dikurangi di awal)
    }
}

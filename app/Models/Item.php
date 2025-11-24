<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'quantity', 'category', 
        'location', 'condition', 'is_available'
    ];

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }

    // Cek apakah item bisa dipinjam
    public function canBeBorrowed($quantity = 1)
    {
        return $this->is_available && $this->quantity >= $quantity;
    }

    // Get available quantity
    public function getAvailableQuantityAttribute()
    {
        $borrowed = $this->borrowings()->whereIn('status', ['approved', 'pending'])->sum('quantity');
        return $this->quantity - $borrowed;
    }
}
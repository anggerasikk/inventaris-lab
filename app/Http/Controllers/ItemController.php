<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of all items for users (READ-ONLY)
     */
    public function list()
    {
        $items = Item::where('is_available', true)->get();
        return view('items.list', compact('items'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Item::all();
        return view('items.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('items.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|min:3',
            'description' => 'nullable|string|max:500',
            'quantity' => 'required|integer|min:0|max:10000',
            'category' => 'required|string|in:elektronik,alat,bahan,perkakas,lainnya',
            'location' => 'required|string|max:100|min:2',
            'condition' => 'required|in:good,damaged,broken'
        ], [
            'name.required' => 'Nama barang wajib diisi',
            'name.min' => 'Nama barang minimal 3 karakter',
            'quantity.required' => 'Jumlah barang wajib diisi',
            'quantity.min' => 'Jumlah barang tidak boleh negatif',
            'category.required' => 'Kategori wajib dipilih',
            'location.required' => 'Lokasi wajib diisi',
            'condition.required' => 'Kondisi wajib dipilih'
        ]);

        Item::create($validated);

        return redirect()->route('admin.items.index')
            ->with('success', 'Item berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        return view('items.show', compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        return view('items.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|min:3',
            'description' => 'nullable|string|max:500',
            'quantity' => 'required|integer|min:0|max:10000',
            'category' => 'required|string|in:elektronik,alat,bahan,perkakas,lainnya',
            'location' => 'required|string|max:100|min:2',
            'condition' => 'required|in:good,damaged,broken'
        ], [
            'name.required' => 'Nama barang wajib diisi',
            'name.min' => 'Nama barang minimal 3 karakter',
            'quantity.required' => 'Jumlah barang wajib diisi',
            'quantity.min' => 'Jumlah barang tidak boleh negatif',
            'category.required' => 'Kategori wajib dipilih',
            'location.required' => 'Lokasi wajib diisi',
            'condition.required' => 'Kondisi wajib dipilih'
        ]);

        $item->update($validated);

        return redirect()->route('admin.items.index')
            ->with('success', 'Item berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        try {
            $item->delete();
            return redirect()->route('admin.items.index')
                ->with('success', 'Item berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('admin.items.index')
                ->with('error', 'Gagal menghapus item: ' . $e->getMessage());
        }
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    // 1. Tampilkan Daftar Alat
    public function index(Request $request)
    {
        $categories = \App\Models\Category::all();

        $items = Item::with('category')
            ->when($request->search, function ($query) use ($request) {
                $query->where(function($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('inventory_code', 'like', '%' . $request->search . '%');
                });
            })
            ->when($request->category_id, function ($query) use ($request) {
             $query->where('category_id', $request->category_id); // Logika filter kategori
            })
            ->latest()
            ->get();

        return view('items.index', compact('items', 'categories'));
    }

    // 2. Form Tambah Alat
    public function create()
    {
        $categories = Category::all();
        return view('items.create', compact('categories'));
    }

    // 3. Simpan Alat Baru (Support Gambar, Kondisi, & Generate Kode Otomatis)
    public function store(Request $request)
    {
        // PERBAIKAN 1: 'inventory_code' dihapus dari sini karena akan digenerate otomatis
        $request->validate([
            'name'           => 'required|string|max:255',
            'category_id'    => 'required|exists:categories,id',
            'status'         => 'required',
            'condition'      => 'required', 
            'condition_note' => 'nullable|string', 
            'image'          => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except('inventory_code'); // Ambil semua data kecuali inventory_code jika ada

        // Logika generate kode alat otomatis
        $category = Category::findOrFail($request->category_id);
        $prefix = $category->code ?? strtoupper(substr($category->name, 0, 3)); // Pakai kode kategori atau ambil 3 huruf depan
        $year = date('Y');

        // Cari item terakhir dari kategori & tahun yang sama
        $lastItem = Item::where('inventory_code', 'LIKE', "$prefix-$year-%")
                        ->latest('id')
                        ->first();

        if ($lastItem) {
            // Ambil nomor urut terakhir (3 digit terakhir) dan tambah 1
            $lastNumber = explode('-', $lastItem->inventory_code);
            $nextNumber = (int)end($lastNumber) + 1;
        } else {
            $nextNumber = 1;
        }

        // Gabungkan jadi: CAM-2026-001 (Misal tahun ini 2026)
        $data['inventory_code'] = $prefix . '-' . $year . '-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        // PERBAIKAN 2: Upload Gambar (Duplikasi dihapus, cukup 1 kali saja)
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('items', 'public');
            $data['image_url'] = $path;
        }
        
        Item::create($data);

        return redirect()->route('items.index')->with('success', 'Alat berhasil ditambahkan dengan kode: ' . $data['inventory_code']);
    }

    // 4. Form Edit Alat
    public function edit(Item $item)
    {
        $categories = Category::all();
        return view('items.edit', compact('item', 'categories'));
    }

    // 5. Update Alat (Support Ganti Gambar & Kondisi)
    public function update(Request $request, Item $item)
    {
        // PERBAIKAN 3: 'inventory_code' dihapus dari validasi update agar tidak error jika di-disabled di form edit
        $request->validate([
            'name'           => 'required|string|max:255',
            'category_id'    => 'required|exists:categories,id',
            'status'         => 'required',
            'condition'      => 'required', 
            'condition_note' => 'nullable|string', 
            'image'          => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Cegah perubahan inventory_code secara manual saat proses update
        $data = $request->except(['inventory_code']);

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($item->image_url && Storage::disk('public')->exists($item->image_url)) {
                Storage::disk('public')->delete($item->image_url);
            }
            // Simpan gambar baru
            $path = $request->file('image')->store('items', 'public');
            $data['image_url'] = $path;
        }

        $item->update($data);

        return redirect()->route('items.index')->with('success', 'Data alat berhasil diperbarui!');
    }

    // 6. Hapus Alat
    public function destroy(Item $item)
    {
        if ($item->image_url && Storage::disk('public')->exists($item->image_url)) {
            Storage::disk('public')->delete($item->image_url);
        }
        $item->delete();
        return redirect()->route('items.index')->with('success', 'Alat berhasil dihapus.');
    }
}
@extends('layouts.app')

@section('title', 'Tambah Alat Baru - UPMD')

@section('content')
<div class="max-w-4xl mx-auto pb-12">
    <div class="flex items-center justify-between mb-8 px-2">
        <div class="flex items-center gap-3">
            <div class="bg-[#003d79] p-2.5 rounded-xl shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-extrabold text-[#003d79] tracking-tight">Tambah Alat Baru</h1>
                <p class="text-gray-500 text-sm">Daftarkan aset inventaris baru ke dalam sistem</p>
            </div>
        </div>
        <a href="{{ route('items.index') }}" class="flex items-center gap-2 text-gray-500 hover:text-[#003d79] font-semibold transition-all group text-sm bg-white px-5 py-2.5 rounded-xl shadow-sm border border-gray-100">
            <span class="group-hover:-translate-x-1 transition-transform">←</span> Kembali
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
        <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data" class="divide-y divide-gray-100">
            @csrf
            @if ($errors->any())
        <div class="m-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r-xl shadow-sm">
            <div class="flex items-center gap-2 mb-2 font-bold uppercase text-xs tracking-widest">
                <span>⚠️</span> Gagal Menyimpan Alat:
            </div>
            <ul class="list-disc list-inside text-xs space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
            
            <div class="p-6 md:p-8">
                <div class="flex items-center gap-2 mb-6">
                    <span class="w-1 h-6 bg-[#003d79] rounded-full"></span>
                    <h3 class="font-bold text-gray-800 uppercase text-xs tracking-widest">Informasi Dasar</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-gray-700 font-bold text-sm ml-1">Nama Alat</label>
                        <input type="text" name="name" value="{{ old('name') }}" 
                            class="w-full border-gray-200 bg-gray-50 border p-3 rounded-xl focus:ring-2 focus:ring-[#003d79] focus:bg-white outline-none transition-all shadow-sm" 
                            placeholder="Contoh: Kamera Sony A7III" required>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-gray-700 font-bold text-sm ml-1">Kode Inventaris</label>
                        <input type="text" name="inventory_code" value="{{ old('inventory_code') }}" 
                            class="w-full border-gray-200 bg-gray-50 border p-3 rounded-xl focus:ring-2 focus:ring-[#003d79] focus:bg-white outline-none transition-all shadow-sm font-mono text-sm" 
                            placeholder="Otomatis di generate sistem" disabled>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-gray-700 font-bold text-sm ml-1">Kategori</label>
                        <div class="relative">
                            <select name="category_id" class="w-full border-gray-200 bg-gray-50 border p-3 rounded-xl focus:ring-2 focus:ring-[#003d79] focus:bg-white outline-none transition-all shadow-sm appearance-none cursor-pointer">
                                <option value="" disabled selected>Pilih Kategori...</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-gray-700 font-bold text-sm ml-1">Deskripsi / Spesifikasi</label>
                        <textarea name="description" rows="1" 
                            class="w-full border-gray-200 bg-gray-50 border p-3 rounded-xl focus:ring-2 focus:ring-[#003d79] focus:bg-white outline-none transition-all shadow-sm"
                            placeholder="Contoh: Resolusi 24MP, 4K Video...">{{ old('description') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="p-6 md:p-8 bg-gray-50/50">
                <div class="flex items-center gap-2 mb-6">
                    <span class="w-1 h-6 bg-orange-500 rounded-full"></span>
                    <h3 class="font-bold text-gray-800 uppercase text-xs tracking-widest">Status & Kondisi Awal</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-gray-700 font-bold text-sm ml-1">Status Ketersediaan</label>
                        <select name="status" class="w-full border-gray-200 bg-white border p-3 rounded-xl focus:ring-2 focus:ring-[#003d79] outline-none transition-all shadow-sm cursor-pointer font-semibold text-[#003d79]">
                            <option value="ready" {{ old('status') == 'ready' ? 'selected' : '' }}>● Ready (Bisa Dipinjam)</option>
                            <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>● Maintenance</option>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-gray-700 font-bold text-sm ml-1">Kondisi Fisik Alat</label>
                        <select name="condition" class="w-full border-gray-200 bg-white border p-3 rounded-xl focus:ring-2 focus:ring-[#003d79] outline-none transition-all shadow-sm cursor-pointer">
                            <option value="sehat" {{ old('condition') == 'sehat' ? 'selected' : '' }}>🟢 Sehat (Normal)</option>
                            <option value="rusak_sebagian" {{ old('condition') == 'rusak_sebagian' ? 'selected' : '' }}>🟡 Rusak Sebagian</option>
                            <option value="rusak_total" {{ old('condition') == 'rusak_total' ? 'selected' : '' }}>🔴 Rusak Total</option>
                            <option value="perbaikan" {{ old('condition') == 'perbaikan' ? 'selected' : '' }}>🔵 Dalam Perbaikan</option>
                        </select>
                    </div>

                    <div class="md:col-span-2 space-y-2">
                        <label class="block text-gray-700 font-bold text-sm ml-1">Catatan Kondisi (Opsional)</label>
                        <textarea name="condition_note" rows="2" 
                            class="w-full border-gray-200 bg-white border p-3 rounded-xl focus:ring-2 focus:ring-[#003d79] focus:bg-white outline-none transition-all shadow-sm" 
                            placeholder="Misal: Body lecet halus, kabel sedikit terkelupas...">{{ old('condition_note') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="p-6 md:p-8">
                <div class="flex items-center gap-2 mb-6">
                    <span class="w-1 h-6 bg-green-500 rounded-full"></span>
                    <h3 class="font-bold text-gray-800 uppercase text-xs tracking-widest">Media Foto</h3>
                </div>
                
                <div class="space-y-2">
                    <label class="block text-gray-700 font-bold text-sm ml-1">Unggah Foto Alat</label>
                    <label class="flex flex-col items-center justify-center w-full h-48 border-2 border-gray-200 border-dashed rounded-2xl cursor-pointer bg-gray-50 hover:bg-gray-100 transition-all group overflow-hidden relative">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-10 h-10 mb-3 text-gray-400 group-hover:text-[#003d79] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            <p class="text-sm text-gray-500 font-bold group-hover:text-[#003d79]">Klik untuk pilih gambar alat</p>
                            <p class="text-xs text-gray-400 mt-1">PNG, JPG atau JPEG (Maks. 2MB)</p>
                        </div>
                        <input type="file" name="image" class="hidden" id="imageInput" onchange="previewImage(event)">
                        <div id="newPreviewContainer" class="absolute inset-0 bg-white hidden">
                            <img id="newPreview" class="w-full h-full object-contain p-4">
                            <div class="absolute top-4 right-4 bg-[#003d79] text-white p-1.5 rounded-full shadow-lg">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"></path></svg>
                            </div>
                        </div>
                    </label>
                </div>
            </div>

            <div class="p-6 md:p-8 bg-gray-50 flex flex-col md:flex-row justify-end gap-3">
                <a href="{{ route('items.index') }}" class="order-2 md:order-1 px-8 py-3.5 text-gray-600 hover:bg-gray-200 rounded-xl font-bold text-sm transition-all text-center">
                    Batal
                </a>
                <button type="submit" class="order-1 md:order-2 px-10 py-3.5 bg-[#003d79] text-white rounded-xl hover:bg-blue-900 transition-all shadow-lg shadow-blue-900/20 font-extrabold text-sm active:scale-95 transform">
                    Simpan Alat Baru
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function previewImage(event) {
        const input = event.target;
        const container = document.getElementById('newPreviewContainer');
        const preview = document.getElementById('newPreview');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                container.classList.remove('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
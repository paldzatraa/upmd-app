@extends('layouts.app')

@section('title', 'Edit Alat - UPMD')

@section('content')
<div class="max-w-4xl mx-auto pb-12">
    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center gap-3">
            <div class="bg-[#003d79] p-2 rounded-lg shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-extrabold text-[#003d79] tracking-tight">Edit Alat</h1>
                <p class="text-gray-500 text-sm">Perbarui informasi inventaris aset UPMD</p>
            </div>
        </div>
        <a href="{{ route('items.index') }}" class="flex items-center gap-2 text-gray-500 hover:text-[#003d79] font-semibold transition-all group text-sm bg-white px-5 py-2.5 rounded-xl shadow-sm border border-gray-100">
            <span class="group-hover:-translate-x-1 transition-transform">←</span> Kembali
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
        <form action="{{ route('items.update', $item->id) }}" method="POST" enctype="multipart/form-data" class="divide-y divide-gray-100">
            @csrf
            @method('PUT') 
            
            <div class="p-6 md:p-8">
                <div class="flex items-center gap-2 mb-6">
                    <span class="w-1 h-6 bg-[#003d79] rounded-full"></span>
                    <h3 class="font-bold text-gray-800 uppercase text-xs tracking-widest">Informasi Dasar</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-gray-700 font-bold text-sm ml-1">Nama Alat</label>
                        <input type="text" name="name" value="{{ old('name', $item->name) }}" 
                            class="w-full border-gray-200 bg-gray-50 border p-3 rounded-xl focus:ring-2 focus:ring-[#003d79] focus:bg-white outline-none transition-all shadow-sm" 
                            placeholder="Masukkan nama alat..." required>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-gray-700 font-bold text-sm ml-1">Kode Inventaris</label>
                        <input type="text" name="inventory_code" value="{{ old('inventory_code', $item->inventory_code) }}" 
                            class="w-full border-gray-200 bg-gray-100 border p-3 rounded-xl cursor-not-allowed font-mono text-sm shadow-sm" 
                            readonly title="Kode ini dihasilkan secara otomatis oleh sistem">
                    </div>

                    <div class="space-y-2">
                        <label class="block text-gray-700 font-bold text-sm ml-1">Kategori</label>
                        <div class="relative">
                            <select name="category_id" class="w-full border-gray-200 bg-gray-50 border p-3 rounded-xl focus:ring-2 focus:ring-[#003d79] focus:bg-white outline-none transition-all shadow-sm appearance-none cursor-pointer">
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ $item->category_id == $cat->id ? 'selected' : '' }}>
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
                        <label class="block text-gray-700 font-bold text-sm ml-1">Deskripsi Alat</label>
                        <textarea name="description" rows="1" 
                            class="w-full border-gray-200 bg-gray-50 border p-3 rounded-xl focus:ring-2 focus:ring-[#003d79] focus:bg-white outline-none transition-all shadow-sm"
                            placeholder="Spesifikasi singkat...">{{ old('description', $item->description) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="p-6 md:p-8 bg-gray-50/50">
                <div class="flex items-center gap-2 mb-6">
                    <span class="w-1 h-6 bg-orange-500 rounded-full"></span>
                    <h3 class="font-bold text-gray-800 uppercase text-xs tracking-widest">Status & Kondisi</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-gray-700 font-bold text-sm ml-1">Status Ketersediaan</label>
                        <select name="status" class="w-full border-gray-200 bg-white border p-3 rounded-xl focus:ring-2 focus:ring-[#003d79] outline-none transition-all shadow-sm cursor-pointer font-semibold text-[#003d79]">
                            <option value="ready" {{ $item->status == 'ready' ? 'selected' : '' }}>● Ready</option>
                            <option value="maintenance" {{ $item->status == 'maintenance' ? 'selected' : '' }}>● Maintenance</option>
                            <option value="lost" {{ $item->status == 'lost' ? 'selected' : '' }}>● Hilang</option>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-gray-700 font-bold text-sm ml-1">Kondisi Fisik Alat</label>
                        <select name="condition" class="w-full border-gray-200 bg-white border p-3 rounded-xl focus:ring-2 focus:ring-[#003d79] outline-none transition-all shadow-sm cursor-pointer">
                            <option value="sehat" {{ $item->condition == 'sehat' ? 'selected' : '' }}>🟢 Sehat (Normal)</option>
                            <option value="rusak_sebagian" {{ $item->condition == 'rusak_sebagian' ? 'selected' : '' }}>🟡 Rusak Sebagian</option>
                            <option value="rusak_total" {{ $item->condition == 'rusak_total' ? 'selected' : '' }}>🔴 Rusak Total</option>
                            <option value="perbaikan" {{ $item->condition == 'perbaikan' ? 'selected' : '' }}>🔵 Dalam Perbaikan</option>
                        </select>
                    </div>

                    <div class="md:col-span-2 space-y-2">
                        <label class="block text-gray-700 font-bold text-sm ml-1">Catatan Kerusakan (Jika ada)</label>
                        <textarea name="condition_note" rows="2" 
                            class="w-full border-gray-200 bg-white border p-3 rounded-xl focus:ring-2 focus:ring-[#003d79] outline-none transition-all shadow-sm" 
                            placeholder="Jelaskan detail kerusakan alat secara spesifik...">{{ old('condition_note', $item->condition_note) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="p-6 md:p-8">
                <div class="flex items-center gap-2 mb-6">
                    <span class="w-1 h-6 bg-green-500 rounded-full"></span>
                    <h3 class="font-bold text-gray-800 uppercase text-xs tracking-widest">Media Foto</h3>
                </div>
                
                <div class="flex flex-col md:flex-row items-start gap-8">
                    @if($item->image_url)
                    <div class="w-full md:w-48 shrink-0">
                        <p class="text-[10px] text-gray-400 uppercase font-bold mb-2 ml-1 text-center md:text-left">Foto Saat Ini</p>
                        <div class="relative group">
                            <img src="{{ Storage::url($item->image_url) }}" class="w-full h-48 md:h-40 object-cover rounded-2xl border-4 border-white shadow-lg group-hover:scale-[1.02] transition-transform duration-300">
                            <div class="absolute inset-0 bg-black/20 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        </div>
                    </div>
                    @endif

                    <div class="flex-grow w-full">
                        <p class="text-[10px] text-gray-400 uppercase font-bold mb-2 ml-1">Ganti Foto Alat</p>
                        <label class="flex flex-col items-center justify-center w-full h-40 md:h-40 border-2 border-gray-200 border-dashed rounded-2xl cursor-pointer bg-gray-50 hover:bg-gray-100 transition-all group overflow-hidden relative">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 mb-2 text-gray-400 group-hover:text-[#003d79] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                <p class="text-xs text-gray-500 font-bold group-hover:text-[#003d79]">Klik untuk upload gambar baru</p>
                                <p class="text-[10px] text-gray-400 mt-1">PNG, JPG atau JPEG (Maks. 2MB)</p>
                            </div>
                            <input type="file" name="image" class="hidden" id="imageInput" onchange="previewImage(event)">
                            <div id="newPreviewContainer" class="absolute inset-0 bg-white hidden">
                                <img id="newPreview" class="w-full h-full object-contain p-2">
                                <div class="absolute top-2 right-2 bg-[#003d79] text-white p-1 rounded-full shadow-lg">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"></path></svg>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <div class="p-6 md:p-8 bg-gray-50 flex flex-col md:flex-row justify-end gap-3">
                <a href="{{ route('items.index') }}" class="order-2 md:order-1 px-8 py-3.5 text-gray-600 hover:bg-gray-200 rounded-xl font-bold text-sm transition-all text-center">
                    Batal
                </a>
                <button type="submit" class="order-1 md:order-2 px-10 py-3.5 bg-[#003d79] text-white rounded-xl hover:bg-blue-900 transition-all shadow-lg shadow-blue-900/20 font-extrabold text-sm active:scale-95 transform">
                    Simpan Perubahan
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
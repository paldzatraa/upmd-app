@extends('layouts.app')

@section('title', 'Formulir Peminjaman - UPMD')

@section('content')
<div class="max-w-6xl mx-auto py-8 px-4">
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
        <div class="flex items-center gap-3">
            <div class="bg-[#003d79] p-2.5 rounded-xl shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-extrabold text-[#003d79] tracking-tight">Formulir Peminjaman</h1>
                <p class="text-gray-500 text-sm italic">Pastikan data yang Anda masukkan sudah benar.</p>
            </div>
        </div>
        <a href="{{ route('loans.catalog') }}" class="flex items-center gap-2 text-gray-500 hover:text-[#003d79] font-semibold transition-all group text-sm bg-white px-5 py-2.5 rounded-xl shadow-sm border border-gray-100">
            <span class="group-hover:-translate-x-1 transition-transform">←</span> Kembali
        </a>
    </div>

    <form action="{{ route('loans.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <div class="lg:col-span-4 order-1 lg:order-1">
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden lg:sticky lg:top-8">
                    <div class="p-5 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                        <h3 class="font-bold text-gray-800 flex items-center gap-2 text-sm">
                            <span class="text-lg">📦</span> Barang Terpilih
                        </h3>
                        <span class="bg-[#003d79] text-white text-[10px] px-2 py-0.5 rounded-full font-bold">
                            {{ count($selectedItems) }} Alat
                        </span>
                    </div>
                    
                    <div class="p-5 space-y-4 max-h-[500px] overflow-y-auto">
                        @foreach($selectedItems as $item)
                            <input type="hidden" name="item_ids[]" value="{{ $item->id }}">

                            <div class="flex gap-4 items-center p-3 rounded-xl border border-transparent hover:border-blue-100 hover:bg-blue-50/30 transition-all group">
                                <div class="w-16 h-16 bg-gray-100 rounded-lg overflow-hidden shrink-0 border border-gray-100 shadow-sm group-hover:scale-105 transition-transform">
                                    @if($item->image_url)
                                        <img src="{{ Storage::url($item->image_url) }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="flex items-center justify-center h-full text-xl bg-gray-200">📷</div>
                                    @endif
                                </div>
                                <div class="overflow-hidden">
                                    <h4 class="font-bold text-sm text-gray-800 truncate">{{ $item->name }}</h4>
                                    <p class="text-[10px] text-gray-400 font-mono mt-1 bg-white px-1.5 py-0.5 rounded border inline-block uppercase">
                                        {{ $item->inventory_code }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="lg:col-span-8 order-2 lg:order-2">
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                    
                    @if ($errors->any())
                        <div class="m-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r-xl shadow-sm">
                            <div class="flex items-center gap-2 mb-2 font-bold uppercase text-xs tracking-widest">
                                <span>⚠️</span> Ada Kesalahan:
                            </div>
                            <ul class="list-disc list-inside text-xs space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="p-6 md:p-8 space-y-8">
                        
                        <div class="space-y-6">
                            <div class="flex items-center gap-2 mb-4">
                                <span class="w-1.5 h-6 bg-[#003d79] rounded-full"></span>
                                <h3 class="font-bold text-gray-800 uppercase text-xs tracking-widest">Waktu & Kontak</h3>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="block text-gray-700 font-bold text-sm ml-1 uppercase tracking-tighter">Tanggal Mulai Pinjam</label>
                                    <input type="date" name="loan_date" 
                                           class="w-full border-gray-200 bg-gray-50 border p-3 rounded-xl focus:ring-2 focus:ring-[#003d79] focus:bg-white outline-none transition-all shadow-sm" 
                                           value="{{ date('Y-m-d') }}"
                                           min="{{ date('Y-m-d') }}" required>
                                </div>

                                <div class="space-y-2">
                                    <label class="block text-gray-700 font-bold text-sm ml-1 uppercase tracking-tighter">Durasi Peminjaman</label>
                                    <div class="relative">
                                        <select name="duration" class="w-full border-gray-200 bg-gray-50 border p-3 rounded-xl focus:ring-2 focus:ring-[#003d79] focus:bg-white outline-none transition-all shadow-sm appearance-none cursor-pointer font-bold">
                                            <option value="1">1 Hari</option>
                                            <option value="2">2 Hari</option>
                                            <option value="3">3 Hari</option>
                                        </select>
                                        <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="block text-gray-700 font-bold text-sm ml-1 flex items-center gap-2 uppercase tracking-tighter">
                                    Nomor WhatsApp Aktif <span class="text-green-600">🟢</span>
                                </label>
                                <input type="number" name="whatsapp_number" 
                                       class="w-full border-gray-200 bg-gray-50 border p-3 rounded-xl focus:ring-2 focus:ring-[#003d79] focus:bg-white outline-none transition-all shadow-sm" 
                                       placeholder="Contoh: 081234567890" value="{{ old('whatsapp_number') }}" required>
                                <p class="text-[10px] text-gray-400 italic ml-1 font-medium">*Digunakan admin untuk konfirmasi ketersediaan alat.</p>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div class="flex items-center gap-2 mb-4">
                                <span class="w-1.5 h-6 bg-orange-500 rounded-full"></span>
                                <h3 class="font-bold text-gray-800 uppercase text-xs tracking-widest">Alasan & Keperluan</h3>
                            </div>
                            <div class="space-y-2">
                                <label class="block text-gray-700 font-bold text-sm ml-1 uppercase tracking-tighter">Detail Keperluan</label>
                                <textarea name="purpose" rows="4" 
                                          class="w-full border-gray-200 bg-gray-50 border p-3 rounded-xl focus:ring-2 focus:ring-[#003d79] focus:bg-white outline-none transition-all shadow-sm" 
                                          placeholder="Jelaskan untuk apa alat ini digunakan (Minimal 10 karakter)..." required>{{ old('purpose') }}</textarea>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div class="flex items-center gap-2 mb-4">
                                <span class="w-1.5 h-6 bg-red-500 rounded-full"></span>
                                <h3 class="font-bold text-gray-800 uppercase text-xs tracking-widest">Dokumen Pendukung</h3>
                            </div>
                            <div class="space-y-2">
                                <label class="block text-gray-700 font-bold text-sm ml-1 uppercase tracking-tighter">Surat Peminjaman (PDF/Gambar)</label>
                                
                                <div class="relative group">
                                    <label for="loan_letter" class="flex flex-col items-center justify-center w-full h-36 border-2 border-gray-200 border-dashed rounded-2xl cursor-pointer bg-gray-50 hover:bg-gray-100 hover:border-[#003d79] transition-all overflow-hidden relative">
                                        <div id="upload-placeholder" class="flex flex-col items-center justify-center py-4 text-center px-4">
                                            <svg class="w-10 h-10 mb-2 text-gray-400 group-hover:text-[#003d79] transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                            </svg>
                                            <p class="text-xs text-gray-500 font-black uppercase tracking-widest group-hover:text-[#003d79]">Klik untuk Pilih Berkas</p>
                                            <p class="text-[10px] text-gray-400 mt-1 uppercase">PDF, JPG, PNG (Max 2MB)</p>
                                        </div>
                                        
                                        <div id="file-chosen-wrapper" class="hidden flex flex-col items-center justify-center py-4 text-center px-4">
                                            <div class="bg-green-100 text-green-700 p-2 rounded-full mb-2">
                                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                            </div>
                                            <p id="file-name-display" class="text-xs font-bold text-gray-800 break-all"></p>
                                            <p class="text-[10px] text-blue-600 font-bold uppercase mt-1">Klik untuk mengganti file</p>
                                        </div>
                                    </label>
                                    <input type="file" id="loan_letter" name="loan_letter" accept=".pdf,.jpg,.jpeg,.png" class="hidden" required onchange="handleFileChange(this)">
                                </div>
                                <p id="upload-error-msg" class="hidden text-red-500 text-[10px] font-bold mt-1 uppercase tracking-tighter">Mohon pilih file surat peminjaman!</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 md:p-8 bg-gray-50 border-t border-gray-100 flex flex-col md:flex-row justify-end gap-3">
                        <a href="{{ route('loans.catalog') }}" class="order-2 md:order-1 px-8 py-4 text-gray-500 hover:bg-gray-200 rounded-xl font-bold text-sm transition-all text-center">
                            Batal
                        </a>
                        <button type="submit" class="order-1 md:order-2 px-10 py-4 bg-[#003d79] text-white rounded-xl hover:bg-blue-900 transition-all shadow-xl shadow-blue-900/20 font-black text-sm active:scale-95 transform flex items-center justify-center gap-3">
                            <span>Kirim Pengajuan</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </form>
</div>

<script>
    function handleFileChange(input) {
        const placeholder = document.getElementById('upload-placeholder');
        const wrapper = document.getElementById('file-chosen-wrapper');
        const fileNameDisplay = document.getElementById('file-name-display');
        const errorMsg = document.getElementById('upload-error-msg');

        if (input.files && input.files.length > 0) {
            const fileName = input.files[0].name;
            const fileSize = input.files[0].size / 1024 / 1024; // MB

            if (fileSize > 2) {
                alert("Ukuran file terlalu besar! Maksimal 2MB.");
                input.value = ""; // Reset input
                return;
            }

            fileNameDisplay.innerText = fileName;
            placeholder.classList.add('hidden');
            wrapper.classList.remove('hidden');
            errorMsg.classList.add('hidden');
        } else {
            placeholder.classList.remove('hidden');
            wrapper.classList.add('hidden');
        }
    }
</script>
@endsection
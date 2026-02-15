@extends('layouts.app')

@section('title', 'Kelola Alat - UPMD')

@section('content')
<div class="max-w-7xl mx-auto pb-20 px-4">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
        <div class="flex items-center gap-3">
            <div class="bg-[#003d79] p-2.5 rounded-xl shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-extrabold text-[#003d79] tracking-tight">Kelola Inventaris</h1>
                <p class="text-gray-500 text-sm">
                    @if(request('search') || request('category_id'))
                        Menampilkan <span class="font-bold text-[#003d79]">{{ $items->count() }}</span> hasil pencarian
                    @else
                        Total <span class="font-bold text-[#003d79]">{{ $items->count() }}</span> aset terdaftar
                    @endif
                </p>
            </div>
        </div>
        <a href="{{ route('items.create') }}" class="inline-flex items-center justify-center gap-2 bg-[#003d79] text-white px-6 py-3 rounded-xl hover:bg-blue-900 transition-all shadow-lg shadow-blue-900/20 font-bold text-sm active:scale-95 transform">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            <span>Tambah Alat Baru</span>
        </a>
    </div>

    <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 mb-8">
        <form action="{{ route('items.index') }}" method="GET" class="flex flex-col md:flex-row gap-3">
            
            <div class="relative flex-grow md:w-48 shrink-0">
                <select name="category_id" onchange="this.form.submit()" class="w-full border-gray-200 bg-gray-50 border p-3 rounded-xl focus:ring-2 focus:ring-[#003d79] outline-none transition-all text-sm appearance-none cursor-pointer font-bold text-gray-700">
                    <option value="">Semua Kategori</option>
                    @if(isset($categories))
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    @endif
                </select>
                <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
            </div>

            <div class="relative flex-grow">
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Cari nama alat atau kode inventaris..." 
                       class="w-full border-gray-200 bg-gray-50 border p-3 pl-11 rounded-xl focus:ring-2 focus:ring-[#003d79] focus:bg-white outline-none transition-all shadow-sm text-sm">
                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="bg-gray-800 text-white px-6 py-3 rounded-xl text-sm font-bold hover:bg-black transition-all shadow-md flex-grow md:flex-grow-0">
                    Cari
                </button>
                @if(request('search') || request('category_id'))
                    <a href="{{ route('items.index') }}" class="bg-red-50 text-red-600 px-4 py-3 rounded-xl text-sm font-bold hover:bg-red-100 transition-all border border-red-100 flex items-center justify-center" title="Reset">
                        ✕
                    </a>
                @endif
            </div>
        </form>
    </div>

    <div class="hidden md:block bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50/80 text-gray-500 uppercase text-[11px] font-extrabold tracking-widest border-b border-gray-100">
                    <th class="p-5">Foto</th>
                    <th class="p-5">Identitas Alat</th>
                    <th class="p-5">Kategori</th>
                    <th class="p-5">Kondisi Alat</th>
                    <th class="p-5">Status</th>
                    <th class="p-5 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 text-sm divide-y divide-gray-50">
                @forelse($items as $item)
                <tr class="hover:bg-blue-50/30 transition-colors group">
                    <td class="p-5 text-center">
                        <div class="w-14 h-14 bg-gray-100 rounded-xl overflow-hidden border-2 border-white shadow-sm group-hover:shadow-md transition-all mx-auto">
                            @if($item->image_url)
                                <img src="{{ Storage::url($item->image_url) }}" class="w-full h-full object-cover">
                            @else
                                <div class="flex items-center justify-center h-full text-gray-300 bg-gray-50 text-xl">📷</div>
                            @endif
                        </div>
                    </td>
                    <td class="p-5">
                        <div class="font-bold text-gray-800 text-base group-hover:text-[#003d79] transition-colors">{{ $item->name }}</div>
                        <div class="font-mono text-[10px] text-gray-400 mt-1 uppercase tracking-tighter">{{ $item->inventory_code }}</div>
                    </td>
                    <td class="p-5">
                        <span class="bg-gray-50 text-gray-500 text-[10px] px-2.5 py-1 rounded-lg font-bold border border-gray-100 uppercase">
                            {{ $item->category->name }}
                        </span>
                    </td>
                    
                    <td class="p-5">
                        @php
                            $condClass = [
                                'sehat' => 'bg-green-50 text-green-700 border-green-100',
                                'rusak_sebagian' => 'bg-yellow-50 text-yellow-700 border-yellow-100',
                                'rusak_total' => 'bg-red-50 text-red-700 border-red-100',
                                'perbaikan' => 'bg-blue-50 text-blue-700 border-blue-100',
                            ][$item->condition] ?? 'bg-gray-50 text-gray-700 border-gray-100';

                            $condIcon = [
                                'sehat' => '🟢',
                                'rusak_sebagian' => '🟡',
                                'rusak_total' => '🔴',
                                'perbaikan' => '🔵',
                            ][$item->condition] ?? '⚪';
                        @endphp
                        <div class="inline-flex flex-col">
                            <span class="inline-flex items-center gap-1.5 {{ $condClass }} px-3 py-1.5 rounded-xl text-[10px] font-extrabold uppercase border">
                                {{ $condIcon }} {{ str_replace('_', ' ', $item->condition) }}
                            </span>
                            @if($item->condition_note)
                                <p class="text-[9px] text-gray-400 mt-1 max-w-[150px] truncate italic" title="{{ $item->condition_note }}">
                                    *{{ $item->condition_note }}
                                </p>
                            @endif
                        </div>
                    </td>

                    <td class="p-5">
                        @if($item->status == 'ready') 
                            <span class="text-green-600 font-extrabold text-[11px] flex items-center gap-1.5 uppercase">
                                <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span> Ready
                            </span>
                        @elseif($item->status == 'borrowed') 
                            <span class="text-[#003d79] font-extrabold text-[11px] flex items-center gap-1.5 uppercase">
                                <span class="w-1.5 h-1.5 bg-[#003d79] rounded-full"></span> Dipinjam
                            </span>
                        @else 
                            <span class="text-red-600 font-extrabold text-[11px] flex items-center gap-1.5 uppercase">
                                <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span> {{ $item->status }}
                            </span>
                        @endif
                    </td>

                    <td class="p-5 text-right">
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('items.edit', $item->id) }}" class="p-2 bg-yellow-50 text-yellow-600 rounded-lg hover:bg-yellow-500 hover:text-white transition-all shadow-sm border border-yellow-100" title="Edit Alat">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </a>
                            <form action="{{ route('items.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus aset ini secara permanen?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-600 hover:text-white transition-all shadow-sm border border-red-100" title="Hapus Aset">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-20 text-center">
                        <div class="flex flex-col items-center italic text-gray-400">
                            <span class="text-5xl mb-3">🔍</span>
                            <p>Alat tidak ditemukan atau belum ada data inventaris.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="md:hidden space-y-4">
        @forelse($items as $item)
        <div class="bg-white p-5 rounded-2xl shadow-md border border-gray-100 overflow-hidden relative group">
            <div class="flex gap-4">
                <div class="w-20 h-20 bg-gray-50 rounded-xl flex-shrink-0 overflow-hidden border border-gray-100">
                    @if($item->image_url)
                        <img src="{{ Storage::url($item->image_url) }}" class="w-full h-full object-cover">
                    @else
                        <div class="flex items-center justify-center h-full text-gray-300 text-2xl">📷</div>
                    @endif
                </div>
                
                <div class="flex-grow">
                    <div class="flex justify-between items-start">
                        <h3 class="font-bold text-gray-800 text-sm leading-tight pr-2">{{ $item->name }}</h3>
                        @if($item->status == 'ready') 
                            <span class="w-2 h-2 bg-green-500 rounded-full shadow-[0_0_5px_rgba(34,197,94,0.8)]"></span>
                        @else
                            <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                        @endif
                    </div>
                    <p class="text-[9px] font-mono text-gray-400 mt-1 uppercase tracking-widest">{{ $item->inventory_code }}</p>
                    
                    <div class="flex flex-wrap gap-2 mt-3">
                        <span class="bg-gray-100 text-gray-600 text-[8px] px-2 py-0.5 rounded-md font-bold uppercase border border-gray-200">
                            {{ $item->category->name }}
                        </span>
                        <span class="bg-orange-50 text-orange-600 text-[8px] px-2 py-0.5 rounded-md font-extrabold uppercase border border-orange-100">
                            {{ str_replace('_', ' ', $item->condition) }}
                        </span>
                    </div>
                </div>
            </div>
            
            <div class="flex gap-2 mt-4 pt-4 border-t border-gray-50">
                <a href="{{ route('items.edit', $item->id) }}" class="flex-1 py-2.5 bg-yellow-50 text-yellow-700 rounded-xl text-xs font-bold text-center border border-yellow-100 active:bg-yellow-100 transition-colors shadow-sm">
                    Edit Aset
                </a>
                <form action="{{ route('items.destroy', $item->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Hapus?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="w-full py-2.5 bg-red-50 text-red-700 rounded-xl text-xs font-bold border border-red-100 active:bg-red-100 transition-colors shadow-sm text-center">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="bg-white p-12 rounded-2xl border-2 border-dashed border-gray-100 text-center">
            <p class="text-gray-400 text-sm italic font-medium">Belum ada data inventaris...</p>
        </div>
        @endforelse
    </div>

</div>
@endsection
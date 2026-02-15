@extends('layouts.app')

@section('title', 'Katalog Peminjaman - UPMD')

@section('content')
<div class="max-w-7xl mx-auto pb-32 px-4">
    
    <div class="bg-white p-6 rounded-[2rem] shadow-xl border border-gray-100 mb-10">
        <div class="flex flex-col lg:flex-row justify-between items-center gap-6">
            <div class="text-center lg:text-left">
                <h1 class="text-3xl font-extrabold text-[#003d79] tracking-tight">Katalog Alat</h1>
                <p class="text-gray-500 text-sm mt-1">Pilih alat yang Anda butuhkan untuk kegiatan akademik.</p>
            </div>

            <form action="{{ route('loans.catalog') }}" method="GET" class="flex flex-col md:flex-row gap-3 w-full lg:w-auto">
                <div class="relative flex-grow md:w-48">
                    <select name="category_id" onchange="this.form.submit()" class="w-full border-gray-200 bg-gray-50 border p-3 rounded-xl focus:ring-2 focus:ring-[#003d79] outline-none transition-all text-sm appearance-none cursor-pointer">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>

                <div class="relative flex-grow md:w-64">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama alat..." class="w-full border-gray-200 bg-gray-50 border p-3 pl-11 rounded-xl focus:ring-2 focus:ring-[#003d79] outline-none transition-all text-sm">
                    <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>

                <button type="submit" class="bg-[#003d79] text-white px-8 py-3 rounded-xl font-bold hover:bg-blue-900 transition-all shadow-lg shadow-blue-900/20 active:scale-95">
                    Cari
                </button>
                @if(request('search') || request('category_id'))
                    <a href="{{ route('loans.catalog') }}" class="bg-gray-100 text-gray-500 px-4 py-3 rounded-xl text-center hover:bg-gray-200 transition-all">✕</a>
                @endif
            </form>
        </div>
    </div>

    <form action="{{ route('loans.create') }}" method="GET" id="loanForm">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @forelse($items as $item)
                @php 
                    $isBorrowed = $item->status !== 'ready'; 
                    $returnDate = null;
                    if($isBorrowed) {
                        $lastLoanDetail = \App\Models\LoanDetail::where('item_id', $item->id)
                            ->whereHas('loan', fn($q) => $q->whereIn('status', ['approved', 'active']))
                            ->with('loan')->latest()->first();
                        if($lastLoanDetail) $returnDate = \Carbon\Carbon::parse($lastLoanDetail->loan->expected_return_date)->format('d M');
                    }
                @endphp

                <div class="item-card group bg-white rounded-[2rem] shadow-md border border-gray-100 overflow-hidden hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex flex-col relative {{ $isBorrowed ? 'opacity-75' : '' }}">
                    
                    <div class="h-56 bg-gray-100 relative overflow-hidden">
                        @if($item->image_url)
                            <img src="{{ Storage::url($item->image_url) }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        @else
                            <div class="flex items-center justify-center h-full text-5xl bg-gray-200">📷</div>
                        @endif

                        <div class="absolute top-4 left-4 flex flex-col gap-2">
                            @if($isBorrowed)
                                <span class="bg-red-600/90 backdrop-blur-md text-white font-black text-[9px] px-3 py-1 rounded-full uppercase tracking-widest shadow-lg">Dipinjam</span>
                            @else
                                <span class="bg-green-500/90 backdrop-blur-md text-white font-black text-[9px] px-3 py-1 rounded-full uppercase tracking-widest shadow-lg">Tersedia</span>
                            @endif
                            
                            @if($item->condition && $item->condition !== 'sehat')
                                <span class="bg-orange-500/90 backdrop-blur-md text-white font-black text-[8px] px-2.5 py-1 rounded-full uppercase tracking-tighter">
                                    {{ str_replace('_', ' ', $item->condition) }}
                                </span>
                            @endif
                        </div>

                        @if($isBorrowed)
                            <div class="absolute inset-0 bg-black/40 backdrop-blur-[2px] flex flex-col items-center justify-center p-4 text-center">
                                @if($returnDate)
                                    <div class="bg-white/10 border border-white/20 p-2 rounded-xl text-white">
                                        <p class="text-[9px] uppercase font-bold opacity-80">Estimasi Tersedia</p>
                                        <p class="text-sm font-black text-yellow-300">{{ $returnDate }}</p>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>

                    <div class="p-6 flex-grow flex flex-col">
                        <div class="mb-4">
                            <span class="text-[10px] font-bold text-blue-600 uppercase tracking-widest">{{ $item->category->name }}</span>
                            <h3 class="font-extrabold text-gray-800 text-lg leading-tight group-hover:text-[#003d79] transition-colors line-clamp-1 mt-1">{{ $item->name }}</h3>
                            <p class="text-[10px] font-mono text-gray-400 mt-1 uppercase tracking-tighter">{{ $item->inventory_code }}</p>
                        </div>

                        <div class="mt-auto pt-4 border-t border-gray-50">
                            @if(!$isBorrowed)
                                <label class="flex items-center justify-center gap-3 cursor-pointer p-3 rounded-2xl hover:bg-blue-50 border-2 border-transparent transition-all group/label select-card-trigger">
                                    <input type="checkbox" name="items[]" value="{{ $item->id }}" class="item-checkbox w-6 h-6 text-[#003d79] rounded-lg border-gray-300 focus:ring-[#003d79] transition-transform group-active/label:scale-90">
                                    <span class="text-sm font-black text-gray-500 group-hover/label:text-[#003d79] uppercase tracking-tight">Pilih Alat</span>
                                </label>
                            @else
                                <div class="text-center py-3 bg-gray-50 rounded-2xl text-[10px] font-bold text-gray-400 uppercase italic">
                                    Tidak Tersedia
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white p-20 rounded-[3rem] text-center border-2 border-dashed border-gray-100">
                    <div class="text-7xl mb-6">🔭</div>
                    <h3 class="text-xl font-bold text-gray-800">Alat tidak ditemukan</h3>
                    <p class="text-gray-400 mt-2">Coba gunakan kata kunci lain atau bersihkan filter.</p>
                </div>
            @endforelse
        </div>

        <div id="checkoutFAB" class="fixed bottom-8 left-1/2 -translate-x-1/2 z-50 w-full px-4 max-w-lg transition-all duration-500 translate-y-32">
            <button type="submit" class="w-full bg-[#003d79] text-white font-black px-8 py-5 rounded-[2rem] shadow-2xl hover:bg-blue-900 transition-all transform active:scale-95 flex items-center justify-between group border-4 border-white">
                <div class="flex items-center gap-4">
                    <div class="bg-white/20 w-10 h-10 rounded-full flex items-center justify-center text-sm" id="selectedCount">0</div>
                    <span class="uppercase tracking-widest text-sm">Ajukan Peminjaman</span>
                </div>
                <svg class="w-6 h-6 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                </svg>
            </button>
        </div>
    </form>
</div>

<style>
    /* Custom Styling for Checked Cards */
    .card-selected {
        border-color: #003d79 !important;
        background-color: #f0f7ff !important;
        transform: scale(0.98);
        box-shadow: 0 10px 25px -5px rgba(0, 61, 121, 0.2);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkboxes = document.querySelectorAll('.item-checkbox');
        const fab = document.getElementById('checkoutFAB');
        const counter = document.getElementById('selectedCount');

        function updateFAB() {
            const selectedCount = document.querySelectorAll('.item-checkbox:checked').length;
            counter.innerText = selectedCount;

            if (selectedCount > 0) {
                fab.classList.remove('translate-y-32');
                fab.classList.add('translate-y-0');
            } else {
                fab.classList.add('translate-y-32');
                fab.classList.remove('translate-y-0');
            }
        }

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const card = this.closest('.item-card');
                if (this.checked) {
                    card.classList.add('card-selected');
                } else {
                    card.classList.remove('card-selected');
                }
                updateFAB();
            });
        });
    });
</script>
@endsection
@extends('layouts.app')

@section('title', 'Dashboard - UPMD')

@section('content')
<div class="max-w-6xl mx-auto mt-4 md:mt-8 pb-20 px-4">

    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
        <div>
            <h1 class="text-2xl md:text-3xl font-extrabold text-[#003d79] tracking-tight">
                👋 Halo, <span class="text-black">{{ explode(' ', Auth::user()->name)[0] }}</span>!
            </h1>
            <p class="text-gray-500 text-sm mt-1 font-medium">Selamat datang kembali di Sistem Inventory UPMD.</p>
        </div>
        <div class="flex items-center gap-2 bg-white px-4 py-2 rounded-2xl shadow-sm border border-gray-100 w-fit">
            <span class="text-xs md:text-sm font-bold text-gray-600">📅 {{ \Carbon\Carbon::now()->format('d M Y') }}</span>
        </div>
    </div>

    @if(Auth::user()->role === 'admin' || Auth::user()->role === 'superadmin')
        <div class="grid grid-cols-2 lg:grid-cols-5 gap-3 md:gap-4 mb-8">
            <div class="bg-white p-5 rounded-2xl shadow-sm border-b-4 border-blue-500 hover:shadow-md transition-all">
                <p class="text-[10px] md:text-xs text-gray-500 uppercase font-black tracking-widest mb-1">Total Aset</p>
                <p class="text-xl md:text-2xl font-black text-gray-800">{{ $totalItems }} <span class="text-xs font-normal text-gray-400 uppercase">Unit</span></p>
            </div>

            <div class="bg-white p-5 rounded-2xl shadow-sm border-b-4 border-purple-500 hover:shadow-md transition-all">
                <p class="text-[10px] md:text-xs text-gray-500 uppercase font-black tracking-widest mb-1">Dipinjam</p>
                <p class="text-xl md:text-2xl font-black text-gray-800">{{ $activeLoans }} <span class="text-xs font-normal text-gray-400 uppercase">Unit</span></p>
            </div>

            <a href="{{ route('admin.loans') }}" class="bg-white p-5 rounded-2xl shadow-sm border-b-4 border-yellow-500 hover:bg-yellow-50 transition-all relative group">
                <p class="text-[10px] md:text-xs text-yellow-700 uppercase font-black tracking-widest mb-1">Konfirmasi</p>
                <p class="text-xl md:text-2xl font-black text-gray-800">{{ $pendingLoans }} <span class="text-xs font-normal text-gray-400 uppercase">Req</span></p>
                @if($pendingLoans > 0)
                    <span class="absolute top-3 right-3 flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
                    </span>
                @endif
            </a>

            <a href="{{ route('admin.loans') }}" class="bg-white p-5 rounded-2xl shadow-sm border-b-4 border-red-500 hover:bg-red-50 transition-all">
                <p class="text-[10px] md:text-xs text-red-500 uppercase font-black tracking-widest mb-1">Overdue</p>
                <p class="text-xl md:text-2xl font-black text-red-600">{{ $overdueLoansCount }} <span class="text-xs font-normal text-gray-400 uppercase">Telat</span></p>
            </a>

            <div class="bg-white p-5 rounded-2xl shadow-sm border-b-4 border-green-500 hover:shadow-md transition-all">
                <p class="text-[10px] md:text-xs text-gray-500 uppercase font-black tracking-widest mb-1">User</p>
                <p class="text-xl md:text-2xl font-black text-gray-800">{{ $totalUsers }}</p>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <div class="bg-[#003d79] p-6 rounded-[2rem] shadow-xl text-white relative overflow-hidden group">
            <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/10 rounded-full blur-3xl group-hover:bg-white/20 transition-all"></div>
            <h3 class="font-bold text-blue-200 uppercase text-[10px] tracking-[0.2em] mb-8">Informasi Akun</h3>
            
            <div class="flex items-center gap-4 mb-8">
                <div class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center text-2xl font-bold border border-white/30">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div>
                    <p class="font-bold text-lg leading-tight">{{ Auth::user()->name }}</p>
                    <p class="text-blue-200 text-xs opacity-80">{{ Auth::user()->email }}</p>
                </div>
            </div>

            <div class="bg-black/20 rounded-2xl p-4 border border-white/10 text-xs flex justify-between items-center">
                <span class="font-medium text-blue-100 uppercase tracking-widest">Akses</span>
                <span class="bg-white text-[#003d79] px-3 py-1 rounded-lg font-black uppercase shadow-sm">
                    {{ Auth::user()->role }}
                </span>
            </div>
        </div>

        <div class="lg:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-4 font-bold">
            <a href="{{ route('loans.catalog') }}" class="flex items-center gap-6 p-8 bg-white border border-gray-100 rounded-[2rem] hover:shadow-xl hover:border-[#003d79]/30 hover:-translate-y-1 transition-all group">
                <div class="w-20 h-20 bg-blue-50 text-[#003d79] rounded-[1.5rem] flex items-center justify-center text-4xl group-hover:bg-[#003d79] group-hover:text-white transition-all shadow-sm shrink-0">
                    🔭
                </div>
                <div>
                    <h4 class="text-xl text-gray-800 tracking-tight">Pinjam Alat Baru</h4>
                    <p class="text-xs text-gray-400 font-medium uppercase tracking-widest mt-1">Cek Katalog Alat</p>
                </div>
            </a>

            @if(Auth::user()->role === 'admin' || Auth::user()->role === 'superadmin')
                <a href="{{ route('items.index') }}" class="flex items-center gap-6 p-8 bg-white border border-gray-100 rounded-[2rem] hover:shadow-xl hover:border-blue-500/30 hover:-translate-y-1 transition-all group">
                    <div class="w-20 h-20 bg-blue-50 text-[#003d79] rounded-[1.5rem] flex items-center justify-center text-4xl group-hover:bg-blue-600 group-hover:text-white transition-all shadow-sm shrink-0">
                        📦
                    </div>
                    <div>
                        <h4 class="text-xl text-gray-800 tracking-tight">Kelola Inventaris</h4>
                        <p class="text-xs text-gray-400 font-medium uppercase tracking-widest mt-1">Update Data Aset</p>
                    </div>
                </a>
            @else
                <a href="{{ route('guide') }}" class="flex items-center gap-6 p-8 bg-white border border-gray-100 rounded-[2rem] hover:shadow-xl hover:border-[#003d79]/30 hover:-translate-y-1 transition-all group">
                    <div class="w-20 h-20 bg-blue-50 text-[#003d79] rounded-[1.5rem] flex items-center justify-center text-4xl group-hover:bg-[#003d79] group-hover:text-white transition-all shadow-sm shrink-0">
                        📜
                    </div>
                    <div>
                        <h4 class="text-xl text-gray-800 tracking-tight">Panduan Sistem</h4>
                        <p class="text-xs text-gray-400 font-medium mt-1 uppercase tracking-widest">Alur & Syarat Pinjam</p>
                    </div>
                </a>
            @endif
        </div>
    </div>

    @php $hasOverdue = $loans->filter(fn($l) => $l->isOverdue())->count() > 0; @endphp
    @if($hasOverdue)
        <div class="mb-8 bg-red-600 rounded-2xl p-4 shadow-lg shadow-red-200 animate-pulse flex items-center gap-4 text-white">
            <span class="text-3xl">📢</span>
            <div>
                <h4 class="font-black text-sm uppercase tracking-widest">Keterlambatan Terdeteksi!</h4>
                <p class="text-xs opacity-90">Ada alat yang melewati batas waktu. Mohon segera mengembalikan alat tersebut.</p>
            </div>
        </div>
    @endif

    <div class="bg-white rounded-[2rem] shadow-xl border border-gray-100 overflow-hidden">
        <div class="p-6 md:p-8 border-b border-gray-50 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h3 class="font-extrabold text-gray-800 text-xl flex items-center gap-3">
                    📜 Riwayat Peminjaman
                </h3>
                <p class="text-gray-500 text-sm mt-1 font-medium">Lihat rincian riwayat peminjaman dan status pengambilan alat.</p>
            </div>
            <span class="bg-gray-50 text-[#003d79] px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-[0.1em] border border-blue-50">
                Total: {{ $loans->count() }} Data
            </span>
        </div>

        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 text-gray-400 text-[10px] font-black uppercase tracking-[0.2em] border-b">
                    <tr>
                        <th class="px-8 py-5">Barang</th>
                        <th class="px-8 py-5 text-center">Periode</th>
                        <th class="px-8 py-5 text-center">Status & Logistik</th>
                        <th class="px-8 py-5 text-right px-10">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 text-gray-700">
                    @forelse($loans as $loan)
                    <tr class="hover:bg-blue-50/20 transition-all {{ $loan->isOverdue() ? 'bg-red-50/30' : '' }}">
                        <td class="px-8 py-6">
                            <div class="space-y-1.5">
                                @foreach($loan->details as $detail)
                                    <div class="flex items-center gap-2 font-bold text-gray-800 text-sm">
                                        <span class="w-1.5 h-1.5 {{ $loan->isOverdue() ? 'bg-red-500' : 'bg-[#003d79]' }} rounded-full"></span>
                                        {{ $detail->item->name ?? 'Item Terhapus' }}
                                    </div>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-8 py-6 text-center">
                            <div class="inline-flex flex-col text-[11px] font-bold">
                                <span class="text-gray-400 uppercase text-[9px] tracking-tighter mb-1">Masa Pinjam</span>
                                <span class="text-gray-700">{{ \Carbon\Carbon::parse($loan->loan_date)->format('d M') }} — <span class="{{ $loan->isOverdue() ? 'text-red-600' : '' }}">{{ \Carbon\Carbon::parse($loan->expected_return_date)->format('d M Y') }}</span></span>
                            </div>
                        </td>
                        <td class="px-8 py-6 text-center">
                            @if($loan->isOverdue())
                                <span class="bg-red-600 text-white px-3 py-1 rounded-full text-[9px] font-black uppercase">⚠️ Overdue</span>
                            @else
                                <span class="text-[10px] font-black uppercase tracking-widest {{ $loan->status == 'approved' ? 'text-blue-600' : ($loan->status == 'pending' ? 'text-yellow-600' : 'text-gray-400') }}">
                                    {{ $loan->status }}
                                </span>
                            @endif

                            <div class="mt-2">
                                @if($loan->status == 'approved' && !$loan->isOverdue())
                                    @php
                                        $pickupLabels = [
                                            'pending' => ['bg-orange-50 text-orange-600 border-orange-100', 'Belum Diambil'],
                                            'picked_up' => ['bg-green-50 text-green-600 border-green-100', 'Sudah Diambil'],
                                            'unclaimed' => ['bg-red-50 text-red-600 border-red-100', 'Tdk Diambil'],
                                        ][$loan->pickup_status] ?? ['bg-gray-100 text-gray-500', 'Unknown'];
                                    @endphp
                                    <span class="text-[9px] font-black uppercase px-2 py-0.5 rounded border {{ $pickupLabels[0] }}">
                                        ● {{ $pickupLabels[1] }}
                                    </span>
                                @endif
                            </div>
                        </td>
                        <td class="px-8 py-6 text-right px-10">
                            @if($loan->status == 'approved' || $loan->isOverdue())
                                <a href="https://wa.me/6281219900217?text={{ urlencode('Halo Admin, konfirmasi pengembalian ID #' . $loan->id) }}" target="_blank" class="bg-green-500 text-white px-4 py-2 rounded-xl text-[10px] font-black hover:bg-green-600 transition-all uppercase tracking-tighter">Chat Admin</a>
                            @else
                                <span class="text-gray-300">—</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="py-20 text-center text-gray-400 font-bold italic">Belum ada riwayat peminjaman.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="md:hidden divide-y divide-gray-100 text-gray-700">
            @forelse($loans as $loan)
            <div class="p-6 space-y-4 {{ $loan->isOverdue() ? 'bg-red-50/30' : '' }}">
                <div class="flex justify-between items-start">
                    <div class="space-y-1">
                        @foreach($loan->details as $detail)
                            <p class="font-black text-gray-800 text-sm flex items-center gap-2 uppercase">
                                <span class="w-1.5 h-1.5 {{ $loan->isOverdue() ? 'bg-red-500' : 'bg-blue-500' }} rounded-full"></span>
                                {{ $detail->item->name }}
                            </p>
                        @endforeach
                        @if($loan->status == 'approved')
                            <p class="text-[9px] font-black uppercase mt-2 {{ $loan->pickup_status == 'picked_up' ? 'text-green-600' : 'text-orange-600' }}">
                                {{ $loan->pickup_status == 'picked_up' ? '✓ Sudah Diambil' : '○ Belum Diambil' }}
                            </p>
                        @endif
                    </div>
                    <span class="{{ $loan->isOverdue() ? 'text-red-600' : 'text-gray-400' }} text-[9px] font-black uppercase tracking-widest">
                        {{ $loan->isOverdue() ? '⚠️ Overdue' : $loan->status }}
                    </span>
                </div>
                
                <div class="flex">
                    @if($loan->status == 'approved' || $loan->isOverdue())
                        <a href="https://wa.me/6281219900217" class="w-full bg-green-500 text-white text-center py-3 rounded-xl text-xs font-black uppercase tracking-tighter shadow-lg shadow-green-100">Chat Admin</a>
                    @endif
                </div>
            </div>
            @empty
                <div class="py-10 text-center text-gray-400 font-bold italic text-sm">Belum ada riwayat.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('title', 'Riwayat Peminjaman - UPMD')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-xl md:text-2xl font-bold text-[#003d79]">Riwayat Saya</h1>
        <a href="{{ route('loans.catalog') }}" class="bg-white border border-[#003d79] text-[#003d79] px-3 py-1.5 rounded-lg text-xs md:text-sm font-bold shadow-sm hover:bg-gray-50 transition">
            + Pinjam Lagi
        </a>
    </div>

    <div class="hidden md:block bg-white shadow-md rounded-lg overflow-hidden border border-gray-200">
        <table class="w-full text-left text-sm">
            <thead class="bg-gray-50 text-gray-600 uppercase font-bold text-xs">
                <tr>
                    <th class="p-4">Alat</th>
                    <th class="p-4">Tgl Pinjam</th>
                    <th class="p-4">Wajib Kembali</th>
                    <th class="p-4">Status</th>
                    <th class="p-4">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($loans as $loan)
                <tr class="hover:bg-blue-50 transition">
                    <td class="p-4 font-bold">
                        {{ $loan->item->name }}
                        <div class="text-[10px] text-gray-400 font-mono">{{ $loan->item->inventory_code }}</div>
                    </td>
                    <td class="p-4">{{ \Carbon\Carbon::parse($loan->loan_date)->format('d M Y') }}</td>
                    <td class="p-4 font-medium text-gray-700">
                        {{ \Carbon\Carbon::parse($loan->expected_return_date)->format('d M Y') }}
                    </td>
                    <td class="p-4">
                        <span class="px-2 py-1 rounded text-xs font-bold
                            {{ $loan->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                              ($loan->status == 'approved' ? 'bg-blue-100 text-blue-800' : 
                              ($loan->status == 'returned' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800')) }}">
                            {{ ucfirst($loan->status) }}
                        </span>
                    </td>
                    <td class="p-4 text-xs">
                        @if($loan->status == 'approved' && $loan->extension_status != 'pending')
                            <a href="{{ route('loans.extend', $loan->id) }}" class="inline-block bg-orange-50 text-orange-700 px-3 py-1.5 rounded border border-orange-200 hover:bg-orange-100 font-bold transition">
                                Perpanjang
                            </a>
                        @elseif($loan->extension_status == 'pending')
                            <span class="text-orange-500 italic flex items-center gap-1">
                                <span class="animate-pulse">●</span> Menunggu Konfirmasi Extend
                            </span>
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="p-8 text-center text-gray-400">Belum ada riwayat.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="md:hidden space-y-4">
        @forelse($loans as $loan)
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200 relative overflow-hidden">
            <div class="absolute left-0 top-0 bottom-0 w-1.5 
                {{ $loan->status == 'pending' ? 'bg-yellow-400' : 
                  ($loan->status == 'approved' ? 'bg-blue-500' : 
                  ($loan->status == 'returned' ? 'bg-green-500' : 'bg-red-500')) }}">
            </div>

            <div class="pl-3">
                <div class="flex justify-between items-start mb-1">
                    <h3 class="font-bold text-gray-800">{{ $loan->item->name }}</h3>
                    <span class="text-[10px] font-mono bg-gray-100 px-1 rounded">{{ $loan->item->inventory_code }}</span>
                </div>
                
                <div class="flex justify-between items-end mt-3 border-b border-gray-100 pb-3">
                    <div class="text-xs text-gray-500">
                        <p>Pinjam: <span class="font-semibold">{{ \Carbon\Carbon::parse($loan->loan_date)->format('d M') }}</span></p>
                        <p>Kembali: <span class="font-semibold">{{ \Carbon\Carbon::parse($loan->expected_return_date)->format('d M') }}</span></p>
                    </div>
                    
                    <span class="px-2 py-1 rounded text-[10px] font-bold uppercase tracking-wide
                        {{ $loan->status == 'pending' ? 'bg-yellow-50 text-yellow-700 border border-yellow-200' : 
                          ($loan->status == 'approved' ? 'bg-blue-50 text-blue-700 border border-blue-200' : 
                          ($loan->status == 'returned' ? 'bg-green-50 text-green-700 border border-green-200' : 'bg-red-50 text-red-700 border border-red-200')) }}">
                        {{ $loan->status }}
                    </span>
                </div>
                
                <div class="pt-2">
                    @if($loan->status == 'approved' && $loan->extension_status != 'pending')
                        <a href="{{ route('loans.extend', $loan->id) }}" class="block w-full text-center bg-orange-50 text-orange-700 text-xs font-bold py-2 rounded border border-orange-200 hover:bg-orange-100 transition">
                            ⏳ Ajukan Perpanjangan
                        </a>
                    @elseif($loan->extension_status == 'pending')
                        <div class="text-center bg-yellow-50 text-yellow-800 text-[10px] font-bold py-1.5 rounded border border-yellow-100">
                            ⏳ Menunggu Konfirmasi Perpanjangan
                        </div>
                    @elseif($loan->admin_note)
                        <div class="text-xs italic text-gray-500 bg-gray-50 p-2 rounded">
                            Catatan: "{{ $loan->admin_note }}"
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="text-center text-gray-400 py-10">Belum ada riwayat.</div>
        @endforelse
    </div>
</div>
@endsection
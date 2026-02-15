@extends('layouts.app')

@section('title', 'Konfirmasi Peminjaman - UPMD')

@section('content')
<div class="max-w-7xl mx-auto pb-20 px-4 mt-6">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
        <div class="flex items-center gap-3">
            <div class="bg-[#003d79] p-2.5 rounded-xl shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-extrabold text-[#003d79] tracking-tight">Konfirmasi Peminjaman</h1>
                <p class="text-gray-500 text-sm">Kelola persetujuan dan status logistik pengambilan alat.</p>
            </div>
        </div>
        <a href="{{ route('dashboard') }}" class="flex items-center gap-2 text-gray-500 hover:text-[#003d79] font-semibold transition-all group text-sm">
            <span class="group-hover:-translate-x-1 transition-transform">←</span> Kembali
        </a>
    </div>

    <div class="hidden md:block bg-white shadow-lg rounded-2xl overflow-hidden border border-gray-100">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50/80 text-gray-400 uppercase text-[11px] font-extrabold tracking-widest border-b border-gray-100">
                    <th class="p-5">Peminjam</th>
                    <th class="p-5 w-1/3">Detail Pengajuan</th>
                    <th class="p-5 text-center">Status & Logistik</th>
                    <th class="p-5 text-right px-8">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 text-sm divide-y divide-gray-50">
                @forelse($loans as $loan)
                <tr class="hover:bg-blue-50/20 transition-colors group align-top {{ $loan->isOverdue() ? 'bg-red-50/30' : '' }}">
                    <td class="p-5">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-gray-100 border border-gray-200 flex items-center justify-center text-[#003d79] font-bold text-sm">
                                {{ substr($loan->user->name, 0, 1) }}
                            </div>
                            <div>
                                <div class="font-bold text-gray-800 text-base group-hover:text-[#003d79] transition-colors">{{ $loan->user->name }}</div>
                                <div class="text-[11px] text-gray-400 italic">{{ $loan->user->email }}</div>
                            </div>
                        </div>
                    </td>

                    <td class="p-5">
                        <div class="space-y-1">
                            @foreach($loan->details as $detail)
                                <div class="text-gray-800 font-medium flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 bg-gray-300 rounded-full"></span>
                                    {{ $detail->item->name ?? 'Item Terhapus' }}
                                </div>
                            @endforeach
                        </div>
                        <p class="text-[10px] font-bold mt-3 text-gray-400 uppercase tracking-tighter">
                            📅 {{ \Carbon\Carbon::parse($loan->loan_date)->format('d M') }} — {{ \Carbon\Carbon::parse($loan->expected_return_date)->format('d M Y') }}
                        </p>
                    </td>

                    <td class="p-5 text-center">
                        @if($loan->isOverdue())
                            <span class="bg-red-600 text-white px-3 py-1 rounded-full text-[10px] font-black uppercase shadow-sm">⚠️ OVERDUE</span>
                        @else
                            <span class="inline-flex items-center gap-1.5 @if($loan->status == 'pending') bg-yellow-50 text-yellow-700 border-yellow-100 @elseif($loan->status == 'approved') bg-blue-50 text-[#003d79] border-blue-100 @elseif($loan->status == 'returned') bg-green-50 text-green-700 border-green-100 @else bg-red-50 text-red-700 border-red-100 @endif px-3 py-1 rounded-full text-[10px] font-extrabold uppercase border">
                                <span class="w-1.5 h-1.5 @if($loan->status == 'pending') bg-yellow-500 @elseif($loan->status == 'approved') bg-[#003d79] @elseif($loan->status == 'returned') bg-green-500 @else bg-red-500 @endif rounded-full"></span>
                                {{ $loan->status }}
                            </span>
                        @endif

                        <div class="mt-2 flex flex-col gap-1 items-center text-center">
                            @if($loan->status == 'approved' && !$loan->isOverdue())
                                @php
                                    $pickupLabels = [
                                        'pending' => ['bg-orange-50 text-orange-600 border-orange-100', 'Belum Diambil'],
                                        'picked_up' => ['bg-green-50 text-green-600 border-green-100', 'Sudah Diambil'],
                                        'unclaimed' => ['bg-red-50 text-red-600 border-red-100', 'Tdk Diambil'],
                                    ][$loan->pickup_status] ?? ['bg-gray-50', 'Unknown'];
                                @endphp
                                <span class="text-[9px] font-black uppercase px-2 py-0.5 rounded border {{ $pickupLabels[0] }}">
                                    ● {{ $pickupLabels[1] }}
                                </span>
                            @endif
                        </div>
                    </td>

                    <td class="p-5 text-right px-8">
                        <div class="flex justify-end gap-2">
                            <button onclick="openDetailModal({{ json_encode([
                                'id' => $loan->id,
                                'name' => $loan->user->name,
                                'email' => $loan->user->email,
                                'whatsapp' => $loan->whatsapp_number,
                                'loan_date' => \Carbon\Carbon::parse($loan->loan_date)->format('d F Y'),
                                'return_date' => \Carbon\Carbon::parse($loan->expected_return_date)->format('d F Y'),
                                'purpose' => $loan->purpose,
                                'letter' => $loan->loan_letter ? asset('storage/' . $loan->loan_letter) : null,
                                'items' => $loan->details->map(fn($d) => $d->item->name ?? 'Item Terhapus'),
                                'status' => $loan->status
                            ]) }})" class="p-2 bg-blue-50 text-blue-600 border border-blue-100 rounded-lg hover:bg-blue-600 hover:text-white transition-all shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </button>

                            @if($loan->status == 'pending')
                                <form action="{{ route('admin.loans.approve', $loan->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="p-2 bg-green-50 text-green-600 border border-green-100 rounded-lg hover:bg-green-600 hover:text-white transition-all shadow-sm" onclick="return confirm('Setujui pengajuan?')"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg></button>
                                </form>
                                <button onclick="openRejectModal('{{ route('admin.loans.reject', $loan->id) }}', 'Tolak Pengajuan')" class="p-2 bg-red-50 text-red-600 border border-red-100 rounded-lg hover:bg-red-600 hover:text-white transition-all shadow-sm"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                            @elseif($loan->status == 'approved')
                                @if($loan->pickup_status == 'pending')
                                    <form action="{{ route('admin.loans.pickup', $loan->id) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="p-2 bg-yellow-50 text-yellow-700 border border-yellow-100 rounded-lg hover:bg-yellow-500 hover:text-white transition-all shadow-sm" title="Ambil Alat"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg></button>
                                    </form>
                                    <form action="{{ route('admin.loans.unclaimed', $loan->id) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="p-2 bg-red-50 text-red-600 border border-red-100 rounded-lg hover:bg-red-600 hover:text-white transition-all shadow-sm" title="Batal" onclick="return confirm('Batal diambil?')"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                                    </form>
                                @elseif($loan->pickup_status == 'picked_up')
                                    <form action="{{ route('admin.loans.return', $loan->id) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="p-2 bg-gray-50 text-gray-700 border border-gray-200 rounded-lg hover:bg-gray-800 hover:text-white transition-all shadow-sm" title="Kembali" onclick="return confirm('Konfirmasi pengembalian?')"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg></button>
                                    </form>
                                @endif
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="p-20 text-center italic text-gray-400">Tidak ada pengajuan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="md:hidden space-y-4">
        @forelse($loans as $loan)
        <div class="bg-white p-5 rounded-2xl shadow-md border border-gray-100 relative overflow-hidden">
            <div class="absolute left-0 top-0 bottom-0 w-1 {{ $loan->isOverdue() ? 'bg-red-600' : ($loan->status == 'pending' ? 'bg-yellow-400' : 'bg-blue-500') }}"></div>
            
            <div onclick="openDetailModal({{ json_encode(['id' => $loan->id, 'name' => $loan->user->name, 'email' => $loan->user->email, 'whatsapp' => $loan->whatsapp_number, 'loan_date' => $loan->loan_date, 'return_date' => $loan->expected_return_date, 'purpose' => $loan->purpose, 'letter' => $loan->loan_letter ? asset('storage/' . $loan->loan_letter) : null, 'items' => $loan->details->map(fn($d) => $d->item->name ?? 'Item'), 'status' => $loan->status]) }})">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="font-bold text-gray-800 text-base">{{ $loan->user->name }}</h3>
                        <p class="text-[10px] text-gray-400 mt-1">ID-{{ str_pad($loan->id, 4, '0', STR_PAD_LEFT) }}</p>
                    </div>
                    <span class="text-[9px] font-black px-2 py-1 rounded bg-gray-100 uppercase">{{ $loan->status }}</span>
                </div>
            </div>

            <div class="flex flex-col gap-2 border-t pt-4 mt-2">
                @if($loan->status == 'pending')
                    <div class="flex gap-2">
                        <form action="{{ route('admin.loans.approve', $loan->id) }}" method="POST" class="flex-1">
                            @csrf @method('PATCH')
                            <button class="w-full py-2.5 bg-[#003d79] text-white rounded-xl text-xs font-bold shadow-sm">Terima</button>
                        </form>
                        <button onclick="openRejectModal('{{ route('admin.loans.reject', $loan->id) }}', 'Tolak')" class="flex-1 py-2.5 bg-red-50 text-red-600 border border-red-100 rounded-xl text-xs font-bold">Tolak</button>
                    </div>
                @elseif($loan->status == 'approved')
                    @if($loan->pickup_status == 'pending')
                        <div class="flex gap-2">
                            <form action="{{ route('admin.loans.pickup', $loan->id) }}" method="POST" class="flex-1">
                                @csrf @method('PATCH')
                                <button class="w-full py-2.5 bg-yellow-500 text-white rounded-xl text-xs font-bold shadow-sm">✅ Sudah Diambil</button>
                            </form>
                            <form action="{{ route('admin.loans.unclaimed', $loan->id) }}" method="POST" class="flex-none">
                                @csrf @method('PATCH')
                                <button class="px-4 py-2.5 bg-red-50 text-red-600 border border-red-100 rounded-xl font-bold" onclick="return confirm('Batal diambil?')">✖</button>
                            </form>
                        </div>
                    @elseif($loan->pickup_status == 'picked_up')
                        <form action="{{ route('admin.loans.return', $loan->id) }}" method="POST">
                            @csrf @method('PATCH')
                            <button class="w-full py-2.5 bg-gray-800 text-white rounded-xl text-xs font-bold shadow-sm uppercase">📥 Barang Kembali</button>
                        </form>
                    @endif
                @endif
            </div>
        </div>
        @empty
            <div class="text-center text-gray-400 py-10 italic">Kosong...</div>
        @endforelse
    </div>
</div>

{{-- MODAL DETAIL --}}
<div id="detailModal" class="fixed inset-0 z-50 hidden bg-gray-900/60 flex items-center justify-center p-4 backdrop-blur-sm">
    <div class="bg-white rounded-[2rem] shadow-2xl w-full max-w-lg overflow-hidden animate-in zoom-in duration-300">
        <div class="bg-[#003d79] px-8 py-6 flex justify-between items-center text-white">
            <h3 class="text-lg font-black uppercase tracking-widest">Rincian Pengajuan</h3>
            <button onclick="closeDetailModal()" class="text-white/60 hover:text-white font-bold text-2xl">&times;</button>
        </div>
        <div class="p-8 space-y-6 max-h-[70vh] overflow-y-auto">
            <div class="grid grid-cols-2 gap-4 border-b pb-4 border-gray-100">
                <div><p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Peminjam</p><p class="font-bold text-gray-800" id="detailName"></p></div>
                <div><p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Kontak WA</p><p class="font-bold text-green-600" id="detailWA"></p></div>
            </div>
            <div class="grid grid-cols-2 gap-4 bg-gray-50 p-4 rounded-2xl border border-gray-100">
                <div><p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Mulai Pinjam</p><p class="font-bold text-gray-700" id="detailStartDate"></p></div>
                <div><p class="text-[10px] font-black text-gray-400 uppercase tracking-widest text-red-400">Batas Kembali</p><p class="font-bold text-red-600" id="detailEndDate"></p></div>
            </div>
            <div><p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Daftar Alat</p><div id="detailItemList" class="space-y-2 text-sm font-bold text-gray-700"></div></div>
            
            <div id="detailPurposeContainer">
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Keperluan</p>
                <p id="detailPurpose" class="text-sm text-gray-600 italic bg-gray-50 p-3 rounded-xl border"></p>
            </div>

            <div id="detailLetterContainer">
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Dokumen Surat</p>
                <a id="detailLetterLink" href="#" target="_blank" class="flex items-center justify-center gap-2 w-full py-3 bg-blue-50 text-[#003d79] rounded-xl font-bold border border-blue-100 hover:bg-[#003d79] hover:text-white transition-all uppercase text-xs">
                    📂 Buka Surat Peminjaman
                </a>
            </div>
        </div>
        <div class="p-6 bg-gray-50 text-center"><button onclick="closeDetailModal()" class="px-8 py-2.5 bg-gray-200 text-gray-700 rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-gray-300">Tutup</button></div>
    </div>
</div>

{{-- MODAL REJECT --}}
<div id="rejectModal" class="fixed inset-0 z-50 hidden bg-gray-900/60 flex items-center justify-center p-4 backdrop-blur-sm">
    <div class="bg-white rounded-[2rem] shadow-2xl w-full max-w-md overflow-hidden">
        <div class="bg-red-50 px-8 py-6 border-b border-red-100 flex justify-between items-center"><h3 class="text-lg font-black text-red-700 uppercase tracking-widest">Penolakan</h3><button onclick="closeRejectModal()" class="text-gray-400 hover:text-red-600 font-bold text-2xl">&times;</button></div>
        <form id="rejectForm" action="" method="POST" class="p-8">
            @csrf @method('PATCH')
            <div class="mb-6"><label class="block text-[11px] font-black text-gray-400 uppercase tracking-widest mb-3">Alasan Penolakan</label><textarea name="reason" rows="4" class="w-full border border-gray-200 bg-gray-50 rounded-2xl p-4 outline-none text-sm focus:ring-2 focus:ring-red-500 transition-all" placeholder="Tuliskan alasan penolakan..." required></textarea></div>
            <div class="flex gap-3"><button type="button" onclick="closeRejectModal()" class="flex-1 py-3.5 bg-gray-100 text-gray-500 rounded-xl font-bold transition hover:bg-gray-200">Batal</button><button type="submit" class="flex-1 py-3.5 bg-red-600 text-white rounded-xl font-bold shadow-lg shadow-red-200">Kirim</button></div>
        </form>
    </div>
</div>

<script>
    function openDetailModal(data) {
        document.getElementById('detailName').innerText = data.name;
        document.getElementById('detailWA').innerText = data.whatsapp;
        document.getElementById('detailStartDate').innerText = data.loan_date;
        document.getElementById('detailEndDate').innerText = data.return_date;
        document.getElementById('detailPurpose').innerText = `"${data.purpose}"`;
        
        const itemList = document.getElementById('detailItemList');
        itemList.innerHTML = '';
        data.items.forEach(item => {
            itemList.innerHTML += `<div class="bg-white border p-2.5 rounded-xl flex items-center gap-2 shadow-sm"><span class="w-2 h-2 bg-blue-500 rounded-full"></span> ${item}</div>`;
        });

        const letterContainer = document.getElementById('detailLetterContainer');
        const letterLink = document.getElementById('detailLetterLink');

        // PERBAIKAN PATH: Menggunakan asset('storage/' + path) dari controller
        if (data.letter) {
            letterContainer.classList.remove('hidden');
            letterLink.href = data.letter;
        } else {
            letterContainer.classList.add('hidden');
        }

        document.getElementById('detailModal').classList.remove('hidden');
        document.getElementById('detailModal').classList.add('flex');
    }

    function closeDetailModal() { 
        document.getElementById('detailModal').classList.add('hidden'); 
        document.getElementById('detailModal').classList.remove('flex'); 
    }

    function openRejectModal(actionUrl, title) { 
        document.getElementById('rejectForm').action = actionUrl; 
        document.getElementById('rejectModal').classList.remove('hidden'); 
        document.getElementById('rejectModal').classList.add('flex'); 
    }

    function closeRejectModal() { 
        document.getElementById('rejectModal').classList.add('hidden'); 
        document.getElementById('rejectModal').classList.remove('flex'); 
    }
</script>
@endsection
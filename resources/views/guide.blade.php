@extends('layouts.app')

@section('title', 'Panduan Peminjaman - UPMD')

@section('content')
<div class="max-w-4xl mx-auto pb-20 px-4 mt-6">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-4">
        <div class="flex items-center gap-3">
            <div class="bg-[#003d79] p-3 rounded-2xl shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-extrabold text-[#003d79] tracking-tight">Panduan Peminjaman</h1>
                <p class="text-gray-500 text-sm mt-1">Langkah-langkah dan syarat meminjam alat di UPMD.</p>
            </div>
        </div>
        <a href="{{ route('dashboard') }}" class="flex items-center gap-2 text-gray-500 hover:text-[#003d79] font-semibold transition-all group text-sm bg-white px-5 py-2.5 rounded-xl shadow-sm border border-gray-100">
            <span class="group-hover:-translate-x-1 transition-transform">←</span> Kembali
        </a>
    </div>

    <div class="bg-white p-8 md:p-12 rounded-[2rem] shadow-xl border border-gray-100 relative overflow-hidden mb-8">
        <div class="absolute top-0 right-0 w-64 h-64 bg-blue-50 rounded-full blur-3xl -z-10 opacity-60 translate-x-1/2 -translate-y-1/2"></div>
        
        <h2 class="text-xl font-black text-gray-800 mb-8 uppercase tracking-widest flex items-center gap-3">
            <span class="w-2 h-8 bg-[#003d79] rounded-full inline-block"></span> Alur Peminjaman
        </h2>

        <div class="relative border-l-2 border-blue-100 ml-3 md:ml-4 space-y-10">
            
            <div class="relative pl-8 md:pl-10">
                <div class="absolute -left-[17px] top-0 w-8 h-8 bg-[#003d79] rounded-full flex items-center justify-center text-white font-black text-sm shadow-md border-4 border-white">1</div>
                <h3 class="font-bold text-gray-800 text-lg">Pilih Alat di Katalog</h3>
                <p class="text-gray-500 text-sm mt-2 leading-relaxed">Buka halaman <a href="{{ route('loans.catalog') }}" class="text-blue-600 font-bold hover:underline">Katalog Alat</a>. Cari alat yang Anda butuhkan, pastikan statusnya <b>Tersedia</b>, lalu centang kotak "Pilih Alat". Anda bisa memilih beberapa alat sekaligus.</p>
            </div>

            <div class="relative pl-8 md:pl-10">
                <div class="absolute -left-[17px] top-0 w-8 h-8 bg-[#003d79] rounded-full flex items-center justify-center text-white font-black text-sm shadow-md border-4 border-white">2</div>
                <h3 class="font-bold text-gray-800 text-lg">Isi Formulir & Upload Surat</h3>
                <p class="text-gray-500 text-sm mt-2 leading-relaxed">Klik tombol "Ajukan Peminjaman". Isi tanggal mulai pinjam, durasi, nomor WA aktif, dan detail keperluan. <b>Wajib mengunggah Surat Peminjaman</b> (format PDF/JPG/PNG maksimal 2MB).</p>
            </div>

            <div class="relative pl-8 md:pl-10">
                <div class="absolute -left-[17px] top-0 w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center text-white font-black text-sm shadow-md border-4 border-white">3</div>
                <h3 class="font-bold text-gray-800 text-lg">Tunggu Konfirmasi Admin</h3>
                <p class="text-gray-500 text-sm mt-2 leading-relaxed">Pengajuan Anda akan berstatus <span class="bg-yellow-100 text-yellow-700 px-2 py-0.5 rounded text-[10px] font-bold uppercase">Menunggu</span>. Admin akan memeriksa ketersediaan fisik alat dan kelengkapan surat Anda. Silakan pantau statusnya di Dashboard Anda.</p>
            </div>

            <div class="relative pl-8 md:pl-10">
                <div class="absolute -left-[17px] top-0 w-8 h-8 bg-green-500 rounded-full flex items-center justify-center text-white font-black text-sm shadow-md border-4 border-white">4</div>
                <h3 class="font-bold text-gray-800 text-lg">Ambil Alat di Ruang UPMD</h3>
                <p class="text-gray-500 text-sm mt-2 leading-relaxed">Jika status berubah menjadi <span class="bg-blue-50 text-[#003d79] border border-blue-100 px-2 py-0.5 rounded text-[10px] font-bold uppercase">Disetujui</span>, segera ambil alat ke ruang UPMD sesuai tanggal mulai pinjam. Tunjukkan bukti persetujuan di Dashboard kepada petugas.</p>
            </div>

            <div class="relative pl-8 md:pl-10">
                <div class="absolute -left-[17px] top-0 w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center text-white font-black text-sm shadow-md border-4 border-white">5</div>
                <h3 class="font-bold text-gray-800 text-lg">Kembalikan Tepat Waktu</h3>
                <p class="text-gray-500 text-sm mt-2 leading-relaxed">Gunakan alat dengan penuh tanggung jawab. Kembalikan alat sebelum atau tepat pada batas waktu peminjaman. Jika terlambat, akun Anda dapat diblokir dari peminjaman selanjutnya.</p>
            </div>

        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-red-50 p-6 md:p-8 rounded-[2rem] border border-red-100">
            <div class="w-12 h-12 bg-red-100 text-red-600 rounded-xl flex items-center justify-center text-2xl mb-4 shadow-sm">⚠️</div>
            <h3 class="font-black text-red-800 text-lg mb-2">Peraturan Penting</h3>
            <ul class="text-sm text-red-700 space-y-2 list-disc list-inside">
                <li>Kerusakan/kehilangan menjadi tanggung jawab peminjam sepenuhnya.</li>
                <li>Dilarang meminjamkan kembali alat kepada pihak ketiga (orang lain).</li>
                <li>Alat yang berstatus <b class="uppercase text-[10px]">Overdue</b> akan memicu denda administrasi.</li>
            </ul>
        </div>

        <div class="bg-[#003d79] text-white p-6 md:p-8 rounded-[2rem] shadow-lg">
            <div class="w-12 h-12 bg-white/20 text-white rounded-xl flex items-center justify-center text-2xl mb-4 shadow-sm backdrop-blur-sm">💬</div>
            <h3 class="font-black text-blue-100 text-lg mb-2">Butuh Bantuan?</h3>
            <p class="text-sm text-blue-200 mb-6 leading-relaxed">Jika Anda memiliki kendala terkait sistem, ingin memperpanjang masa pinjam, atau menanyakan ketersediaan alat mendesak, silakan hubungi Admin UPMD.</p>
            <a href="https://wa.me/6281219900217" target="_blank" class="inline-flex items-center gap-2 bg-green-500 text-white px-6 py-3 rounded-xl font-bold hover:bg-green-600 transition-all shadow-md active:scale-95 text-sm uppercase tracking-widest">
                Chat WhatsApp Admin
            </a>
        </div>
    </div>

</div>
@endsection
@extends('emails.layout')

@section('content')
    <div style="text-align: center;">
        <span style="font-size: 50px;">🎉</span>
    </div>
    <h2 style="text-align: center; color: #003d79;">Perpanjangan Berhasil!</h2>
    
    <p>Halo <strong>{{ $loan->user->name }}</strong>,</p>
    <p>Permintaan perpanjangan durasi peminjaman untuk alat <span class="highlight">{{ $loan->item->name }}</span> telah disetujui.</p>

    <div style="text-align: center; margin: 30px 0; padding: 20px; background-color: #e3f2fd; border-radius: 10px;">
        <p style="margin: 0; font-size: 12px; text-transform: uppercase; letter-spacing: 1px;">Tanggal Kembali Baru</p>
        <p style="margin: 5px 0 0 0; font-size: 24px; font-weight: bold; color: #003d79;">
            {{ \Carbon\Carbon::parse($loan->expected_return_date)->format('d F Y') }}
        </p>
    </div>

    <p style="text-align: center;">Terima kasih telah mengonfirmasi. Harap kembalikan sesuai jadwal baru.</p>
@endsection
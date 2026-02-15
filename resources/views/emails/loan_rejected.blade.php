@extends('emails.layout')
@section('content')
    <h2 style="color: #d32f2f; text-align: center;">Mohon Maaf</h2>
    <p>Halo {{ $loan->user->name }}, pengajuan peminjaman alat <strong>{{ $loan->item->name }}</strong> tidak dapat kami setujui saat ini.</p>

    <div style="background-color: #fff5f5; border-left: 4px solid #d32f2f; padding: 15px; margin: 20px 0;">
        <strong>Alasan Penolakan:</strong><br>
        "{{ $reason }}"
    </div>
    <p>Silakan ajukan kembali di lain waktu atau hubungi admin.</p>
@endsection
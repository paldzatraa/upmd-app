@extends('emails.layout')
@section('content')
    <h2 style="color: #d32f2f; text-align: center;">Perpanjangan Ditolak</h2>
    <p>Halo {{ $loan->user->name }}, permintaan perpanjangan waktu untuk alat <strong>{{ $loan->item->name }}</strong> ditolak.</p>

    <div style="background-color: #fff5f5; border-left: 4px solid #d32f2f; padding: 15px; margin: 20px 0;">
        <strong>Alasan Admin:</strong><br>
        "{{ $reason }}"
    </div>
    <p>Harap kembalikan alat sesuai jadwal awal: <strong>{{ \Carbon\Carbon::parse($loan->expected_return_date)->format('d M Y') }}</strong>.</p>
@endsection
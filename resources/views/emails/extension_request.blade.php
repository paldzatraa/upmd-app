@extends('emails.layout')

@section('content')
    <h2 style="color: #ff9800; margin-top: 0;">⏳ Permintaan Perpanjangan</h2>
    <p>Halo Admin, mahasiswa berikut mengajukan perpanjangan waktu peminjaman.</p>

    <table class="data-table">
        <tr>
            <td>Peminjam</td>
            <td>{{ $loan->user->name }}</td>
        </tr>
        <tr>
            <td>Alat</td>
            <td>{{ $loan->item->name }}</td>
        </tr>
        <tr>
            <td>Jadwal Awal</td>
            <td>{{ \Carbon\Carbon::parse($loan->expected_return_date)->format('d M Y') }}</td>
        </tr>
        <tr>
            <td>Minta Sampai</td>
            <td style="color: #003d79; font-weight: bold; font-size: 16px;">{{ \Carbon\Carbon::parse($loan->request_return_date)->format('d M Y') }}</td>
        </tr>
        <tr>
            <td>Alasan</td>
            <td>"{{ $loan->extension_reason }}"</td>
        </tr>
    </table>

    <div style="text-align: center;">
        <a href="{{ route('admin.loans') }}" class="btn">Cek Dashboard</a>
    </div>
@endsection
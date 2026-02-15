@extends('emails.layout')

@section('content')
    <h2 style="color: #003d79; margin-top: 0;">🔔 Pengajuan Baru</h2>
    <p>Halo Admin, ada mahasiswa yang mengajukan peminjaman alat baru.</p>

    <table class="data-table">
        <tr>
            <td>Peminjam</td>
            <td>{{ $loan->user->name }} <br><span style="font-size: 12px; color: #888;">{{ $loan->user->email }}</span></td>
        </tr>
        <tr>
            <td>Alat</td>
            <td><strong>{{ $loan->item->name }}</strong></td>
        </tr>
        <tr>
            <td>Kode</td>
            <td>{{ $loan->item->inventory_code }}</td>
        </tr>
        <tr>
            <td>Durasi</td>
            <td>{{ \Carbon\Carbon::parse($loan->loan_date)->format('d M') }} s.d {{ \Carbon\Carbon::parse($loan->expected_return_date)->format('d M Y') }}</td>
        </tr>
        <tr>
            <td>Keperluan</td>
            <td>"{{ $loan->purpose }}"</td>
        </tr>
    </table>

    <div style="text-align: center;">
        <a href="{{ route('admin.loans') }}" class="btn">Login & Konfirmasi</a>
    </div>
@endsection
@extends('emails.layout')

@section('content')
    <div style="text-align: center; margin-bottom: 20px;">
        <span style="font-size: 50px;">✅</span>
    </div>
    <h2 style="text-align: center; color: #2e7d32; margin-top: 0;">Permintaan Disetujui!</h2>
    
    <p>Halo <span class="highlight">{{ $loan->user->name }}</span>,</p>
    <p>Kabar baik! Pengajuan peminjaman alat Anda telah disetujui oleh Admin.</p>

    <div style="background-color: #f0fdf4; border: 1px solid #bbf7d0; padding: 15px; border-radius: 8px; margin: 20px 0;">
        <table class="data-table" style="margin: 0;">
            <tr>
                <td>Alat</td>
                <td>{{ $loan->item->name }}</td>
            </tr>
            <tr>
                <td>Wajib Kembali</td>
                <td style="color: #d32f2f; font-weight: bold;">{{ \Carbon\Carbon::parse($loan->expected_return_date)->format('d F Y') }}</td>
            </tr>
        </table>
    </div>

    <p><strong>Panduan Pengambilan:</strong></p>
    <ul>
        <li>Silakan datang ke ruang UPMD segera.</li>
        <li>Tunjukkan email ini atau KTM kepada petugas.</li>
        <li>Jaga alat dengan baik.</li>
    </ul>
@endsection
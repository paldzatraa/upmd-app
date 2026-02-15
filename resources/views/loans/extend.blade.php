@extends('layouts.app')

@section('title', 'Ajukan Perpanjangan - UPMD')

@section('content')
<div class="max-w-md mx-auto bg-white p-6 rounded-xl shadow-md border">
    <h2 class="text-xl font-bold mb-4">Ajukan Perpanjangan</h2>
    <p class="text-gray-600 text-sm mb-4">Alat: <strong>{{ $loan->item->name }}</strong></p>
    
    <form action="{{ route('loans.extend.store', $loan->id) }}" method="POST">
        @csrf @method('PATCH')
        
        <div class="mb-4">
            <label class="block text-sm font-bold mb-2">Minta Sampai Tanggal:</label>
            <input type="date" name="extension_date" class="w-full border p-2 rounded" required>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-bold mb-2">Alasan:</label>
            <textarea name="reason" class="w-full border p-2 rounded" rows="3" required></textarea>
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg font-bold">Kirim Pengajuan</button>
    </form>
</div>
@endsection
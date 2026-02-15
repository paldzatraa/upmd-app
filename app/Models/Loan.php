<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    protected $fillable = [
        'user_id', 'item_id', 'purpose', 'loan_date', 
        'expected_return_date', 'actual_return_date', 
        'status', 'admin_note', 'return_condition',
        'request_return_date', 'extension_reason', 'extension_status',
        'loan_letter', 'whatsapp_number'
    ];

    // Relasi: Peminjaman dilakukan oleh satu User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Peminjaman meminjam satu Alat
    public function item()
    {
        return $this->hasMany(LoanDetail::class);
    }

    // Menghubungkan Peminjaman (Header) ke Rincian Barang (Detail)
    public function details()
    {
        return $this->hasMany(LoanDetail::class);
    }

    public function isOverdue()
    {
    // Overdue jika: Status Approved, Barang sudah diambil, dan melewati tanggal kembali
        return $this->status === 'approved' && 
            $this->pickup_status === 'picked_up' && 
            \Carbon\Carbon::now()->gt($this->expected_return_date);
    }
}
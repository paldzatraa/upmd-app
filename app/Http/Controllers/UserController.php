<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // 1. Tampilkan Daftar User (DENGAN FITUR SEARCH)
    public function index(Request $request)
    {
        // Gunakan query builder agar bisa ditambah filter
        $users = User::query()
            ->when($request->search, function ($query) use ($request) {
                $query->where(function($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%')
                      ->orWhere('email', 'like', '%' . $request->search . '%');
                });
            })
            // Urutkan admin paling atas, lalu user terbaru yang mendaftar
            ->orderBy('role', 'asc')
            ->latest()
            ->get();

        return view('users.index', compact('users'));
    }

    // 2. Ubah Role (Toggle)
    public function toggleRole(User $user)
    {
        // 1. Cek: Tidak boleh mengubah diri sendiri
        if ($user->id == Auth::id()) {
            return back()->with('error', 'Anda tidak bisa mengubah role akun sendiri!');
        }

        // 2. Cek: PROTEKSI SUPERADMIN
        // Pastikan email ini sama dengan yang ada di index.blade.php
        $superAdminEmail = 'naufalds@student.ub.ac.id'; 

        if (strtolower($user->email) === strtolower($superAdminEmail)) {
            return back()->with('error', '⛔ AKSES DITOLAK: Anda tidak memiliki wewenang untuk mengubah Superadmin!');
        }

        // 3. Logika Toggle
        $newRole = ($user->role === 'admin') ? 'user' : 'admin';
        
        $user->update(['role' => $newRole]);

        return back()->with('success', "Role {$user->name} berhasil diubah menjadi {$newRole}.");
    }

    // 3. Hapus User
    public function destroy(User $user)
    {
        // 1. Cegah menghapus diri sendiri
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri!');
        }

        // 2. Cegah menghapus Superadmin
        $superAdminEmail = 'naufalds@student.ub.ac.id';
        if (strtolower($user->email) === strtolower($superAdminEmail)) {
            return back()->with('error', '⛔ AKSES DITOLAK: Akun Superadmin tidak dapat dihapus!');
        }

        // 3. Eksekusi Hapus
        $user->delete();

        return back()->with('success', "User {$user->name} telah berhasil dihapus dari sistem.");
    }
}
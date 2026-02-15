@extends('layouts.app')

@section('title', 'Manajemen User - UPMD')

@section('content')
<div class="max-w-7xl mx-auto pb-20 px-4">
    
    @php
        $superAdminEmail = 'naufalds@student.ub.ac.id'; 
    @endphp

    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
        <div class="flex items-center gap-3">
            <div class="bg-[#003d79] p-2.5 rounded-xl shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-extrabold text-[#003d79] tracking-tight">Manajemen User</h1>
                <p class="text-gray-500 text-sm">
                    @if(request('search'))
                        Ditemukan <span class="font-bold text-[#003d79]">{{ $users->count() }}</span> user untuk "{{ request('search') }}"
                    @else
                        Total <span class="font-bold text-[#003d79]">{{ $users->count() }}</span> user terdaftar
                    @endif
                </p>
            </div>
        </div>
    </div>

    <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 mb-8">
        <form action="{{ route('users.index') }}" method="GET" class="flex flex-col md:flex-row gap-3">
            <div class="relative flex-grow">
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Cari berdasarkan nama user atau email..." 
                       class="w-full border-gray-200 bg-gray-50 border p-3 pl-11 rounded-xl focus:ring-2 focus:ring-[#003d79] focus:bg-white outline-none transition-all shadow-sm text-sm">
                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
            </div>
            <button type="submit" class="bg-[#1f2937] text-white px-8 py-3 rounded-xl text-sm font-bold hover:bg-black transition-all shadow-md">
                Cari User
            </button>
            @if(request('search'))
                <a href="{{ route('users.index') }}" class="bg-red-50 text-red-600 px-4 py-3 rounded-xl text-sm font-bold hover:bg-red-100 transition-all border border-red-100 flex items-center justify-center">
                    ✕
                </a>
            @endif
        </form>
    </div>

    <div class="hidden md:block bg-white shadow-lg rounded-2xl overflow-hidden border border-gray-100">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50/80 text-gray-500 uppercase text-[11px] font-extrabold tracking-widest border-b border-gray-100">
                    <th class="p-5">Foto</th>
                    <th class="p-5">Identitas User</th>
                    <th class="p-5">Email</th>
                    <th class="p-5 text-center">Role</th>
                    <th class="p-5 text-right px-8">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 text-sm divide-y divide-gray-50">
                @forelse($users as $user)
                @php 
                    $isSuperAdmin = strtolower(trim($user->email)) === strtolower(trim($superAdminEmail));
                    $isMe = $user->id == Auth::id();
                @endphp
                <tr class="hover:bg-blue-50/20 transition-colors group">
                    <td class="p-5 text-center">
                        <div class="w-12 h-12 bg-gray-100 rounded-xl overflow-hidden border-2 border-white shadow-sm flex items-center justify-center text-[#003d79] font-bold text-lg uppercase group-hover:scale-110 transition-transform mx-auto">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                    </td>
                    <td class="p-5">
                        <div class="font-bold text-gray-800 text-base group-hover:text-[#003d79] transition-colors">
                            {{ $user->name }}
                        </div>
                        @if($isMe)
                            <span class="bg-blue-100 text-blue-700 text-[9px] px-2 py-0.5 rounded-md font-black uppercase">Anda</span>
                        @endif
                    </td>
                    <td class="p-5 text-gray-500 font-medium">
                        {{ $user->email }}
                    </td>
                    <td class="p-5 text-center">
                        @if($user->role == 'admin')
                            <span class="inline-flex items-center gap-1.5 bg-blue-50 text-[#003d79] px-3 py-1.5 rounded-full text-[10px] font-extrabold uppercase border border-blue-100">
                                <span class="w-1.5 h-1.5 bg-[#003d79] rounded-full shadow-[0_0_5px_rgba(0,61,121,0.5)]"></span> ADMINISTRATOR
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 bg-gray-50 text-gray-400 px-3 py-1.5 rounded-full text-[10px] font-extrabold uppercase border border-gray-200">
                                <span class="w-1.5 h-1.5 bg-gray-300 rounded-full"></span> REGULAR USER
                            </span>
                        @endif
                    </td>
                    <td class="p-5 text-right px-8">
                        <div class="flex justify-end gap-2">
                            @if($isSuperAdmin)
                                <span class="text-[10px] bg-yellow-50 text-yellow-700 border border-yellow-100 px-3 py-1.5 rounded-xl font-black uppercase tracking-widest shadow-sm">🔒 Master</span>
                            @elseif(!$isMe)
                                <form action="{{ route('users.toggle', $user->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    @if($user->role == 'admin')
                                        <button type="submit" class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-600 hover:text-white transition-all shadow-sm border border-red-100" title="Turunkan Role" onclick="return confirm('Turunkan role user ini?')">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                                        </button>
                                    @else
                                        <button type="submit" class="p-2 bg-green-50 text-green-600 rounded-lg hover:bg-green-600 hover:text-white transition-all shadow-sm border border-green-100" title="Angkat Role">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                                        </button>
                                    @endif
                                </form>
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('⚠️ PENTING: Menghapus user akan menghapus semua riwayat peminjamannya secara permanen. Lanjutkan?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 bg-gray-100 text-gray-400 rounded-lg hover:bg-red-600 hover:text-white transition-all shadow-sm border border-gray-200" title="Hapus User">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            @else
                                <span class="text-[10px] text-gray-300 italic font-bold uppercase tracking-widest px-2">Self Identity</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="p-20 text-center italic text-gray-400">User tidak ditemukan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="md:hidden space-y-4">
        @forelse($users as $user)
        @php 
            $isSuperAdmin = strtolower(trim($user->email)) === strtolower(trim($superAdminEmail));
            $isMe = $user->id == Auth::id();
        @endphp
        <div class="bg-white p-5 rounded-2xl shadow-md border border-gray-100">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center text-[#003d79] font-bold text-lg uppercase border border-gray-200 shadow-sm">
                    {{ substr($user->name, 0, 1) }}
                </div>
                <div class="overflow-hidden">
                    <h3 class="font-bold text-gray-800 text-base truncate">{{ $user->name }}</h3>
                    <p class="text-xs text-gray-400 truncate">{{ $user->email }}</p>
                </div>
            </div>

            <div class="flex items-center justify-between py-3 border-t border-gray-50 mb-4">
                <span class="text-[10px] font-bold text-gray-400 uppercase">Hak Akses</span>
                @if($user->role == 'admin')
                    <span class="inline-flex items-center gap-1.5 bg-blue-50 text-[#003d79] px-3 py-1 rounded-full text-[10px] font-extrabold uppercase border border-blue-100">
                        ADMIN
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 bg-gray-50 text-gray-400 px-3 py-1 rounded-full text-[10px] font-extrabold uppercase border border-gray-200">
                        USER
                    </span>
                @endif
            </div>

            <div class="flex gap-2">
                @if($isSuperAdmin)
                    <div class="w-full bg-yellow-50 text-yellow-700 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest text-center border border-yellow-100">🔒 System Master</div>
                @elseif(!$isMe)
                    <form action="{{ route('users.toggle', $user->id) }}" method="POST" class="flex-1">
                        @csrf @method('PATCH')
                        @if($user->role == 'admin')
                            <button type="submit" class="w-full bg-red-50 text-red-600 py-2.5 rounded-xl text-xs font-bold border border-red-100 flex items-center justify-center gap-2" onclick="return confirm('Turunkan role?')">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                                Turunkan
                            </button>
                        @else
                            <button type="submit" class="w-full bg-green-50 text-green-600 py-2.5 rounded-xl text-xs font-bold border border-green-100 flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                                Angkat
                            </button>
                        @endif
                    </form>
                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="flex-none" onsubmit="return confirm('Hapus user?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="p-2.5 bg-gray-100 text-gray-400 rounded-xl border border-gray-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </form>
                @else
                    <div class="w-full bg-blue-50 text-blue-700 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest text-center border border-blue-100 italic">Ini Akun Anda</div>
                @endif
            </div>
        </div>
        @empty
        <div class="bg-white p-12 rounded-2xl border-2 border-dashed border-gray-100 text-center italic text-gray-400">User tidak ditemukan.</div>
        @endforelse
    </div>
</div>
@endsection
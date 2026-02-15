<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\IsAdmin; 

/*
|--------------------------------------------------------------------------
| Web Routes (Jalur Akses)
|--------------------------------------------------------------------------
*/

// ==========================================
// 1. HALAMAN PUBLIK (Bisa diakses tanpa login)
// ==========================================

Route::get('/', function () {
    return view('welcome');
})->name('login');

// Halaman Katalog (Akses Publik/Member)
Route::get('/catalog', [LoanController::class, 'index'])->name('loans.catalog');

// LOGIN SSO
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('login.google');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// ==========================================
// 2. HALAMAN MEMBER (Harus Login)
// ==========================================

Route::middleware(['auth'])->group(function () {
    
    // --- DASHBOARD (Statistik + Riwayat) ---
    Route::get('/dashboard', function () {
        // 1. Statistik Dasar
        $totalItems = \App\Models\Item::count();
        $activeLoans = \App\Models\Loan::where('status', 'approved')->count();
        $pendingLoans = \App\Models\Loan::where('status', 'pending')->count();
        $totalUsers = \App\Models\User::count();
        $myActiveLoans = \App\Models\Loan::where('user_id', Auth::id())->where('status', 'approved')->count();

        // 2. Statistik Overdue (Tambahan Baru)
        $overdueLoansCount = \App\Models\Loan::where('status', 'approved')
                            ->where('pickup_status', 'picked_up')
                            ->where('expected_return_date', '<', now())
                            ->count();

        // 3. Data Riwayat Peminjaman
        $loans = \App\Models\Loan::with('details.item')
                    ->where('user_id', Auth::id())
                    ->latest()
                    ->get();

        return view('dashboard', compact(
            'totalItems', 
            'activeLoans', 
            'pendingLoans', 
            'totalUsers', 
            'myActiveLoans', 
            'overdueLoansCount', // Variabel dikirim ke view
            'loans'
        ));
    })->name('dashboard');

    // --- HALAMAN PANDUAN SISTEM (BARU) ---
    Route::get('/panduan', function () {
        return view('guide');
    })->name('guide');

    // --- FITUR PEMINJAMAN (User) ---
    
    // 1. Halaman Form Pengajuan (Checkout)
    Route::get('/loans/create', [LoanController::class, 'create'])->name('loans.create');

    // 2. Proses Simpan
    Route::post('/loans/store', [LoanController::class, 'store'])->name('loans.store');

    // Fitur Extend Peminjaman (User)
    Route::get('/loans/{loan}/extend', [LoanController::class, 'extendForm'])->name('loans.extend');
    Route::patch('/loans/{loan}/extend', [LoanController::class, 'extendStore'])->name('loans.extend.store');

    // ==========================================
    // 3. AREA KHUSUS ADMIN (Dilindungi Middleware IsAdmin)
    // ==========================================
    Route::middleware(IsAdmin::class)->group(function () {

        // Manajemen User
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::patch('/users/{user}/toggle', [UserController::class, 'toggleRole'])->name('users.toggle');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy'); // <--- BARU: Fitur Hapus

        // Manajemen Peminjaman
        Route::prefix('admin')->group(function () {
            // List Peminjaman
            Route::get('/loans', [LoanController::class, 'adminIndex'])->name('admin.loans');
            
            // Aksi Dasar (Approve/Reject/Return)
            Route::patch('/loans/{loan}/approve', [LoanController::class, 'approve'])->name('admin.loans.approve');
            Route::patch('/loans/{loan}/reject', [LoanController::class, 'reject'])->name('admin.loans.reject');
            Route::patch('/loans/{loan}/return', [LoanController::class, 'complete'])->name('admin.loans.return');

            // Konfirmasi Barang Sudah Diambil
            Route::patch('/loans/{loan}/pickup', [LoanController::class, 'markAsPickedUp'])->name('admin.loans.pickup');

            // Konfirmasi Barang Tidak Diambil
            Route::patch('/loans/{loan}/unclaimed', [LoanController::class, 'markAsUnclaimed'])->name('admin.loans.unclaimed');

            // Aksi Extend
            Route::patch('/loans/{loan}/approve-extend', [LoanController::class, 'approveExtension'])->name('admin.loans.approve_extend');
            Route::patch('/loans/{loan}/reject-extend', [LoanController::class, 'rejectExtension'])->name('admin.loans.reject_extend');
        });

        // Kelola Barang
        Route::resource('items', ItemController::class);
        
    });

});
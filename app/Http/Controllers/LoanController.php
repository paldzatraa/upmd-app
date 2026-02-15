<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Loan;
use App\Models\LoanDetail; 
use App\Mail\NewLoanRequest;
use App\Mail\LoanApproved;
use App\Mail\ExtensionRequestMail;
use App\Mail\LoanRejected;
use App\Mail\ExtensionRejected;
use App\Mail\ExtensionApprovedMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class LoanController extends Controller
{
    // ==========================================
    // 1. HALAMAN KATALOG & FORM (SISI MAHASISWA)
    // ==========================================

    // 1. Halaman Katalog
    public function index(Request $request)
    {
        $categories = \App\Models\Category::all();

        $items = Item::query()
            ->when($request->search, function ($query) use ($request) {
                $query->where('name', 'like', '%'.$request->search.'%');
            })
            ->when($request->category_id, function ($query) use ($request) {
                $query->where('category_id', $request->category_id);
            })
            ->latest()
            ->get();

        return view('loans.catalog', compact('items', 'categories'));
    }

    // 2. Halaman Form Pengajuan (Checkout)
    public function create(Request $request)
    {
        $itemIds = $request->query('items');

        if (empty($itemIds)) {
            return redirect()->route('loans.catalog')->with('error', 'Harap pilih minimal satu alat!');
        }

        $selectedItems = Item::whereIn('id', $itemIds)->get();

        return view('loans.create', compact('selectedItems'));
    }

    // 3. Proses Simpan Peminjaman (FIX: VALIDASI & UPLOAD WAJIB)
    public function store(Request $request)
    {
        // Validasi input dengan pesan error kustom
        $request->validate([
            'item_ids'        => 'required|array|min:1',
            'whatsapp_number' => 'required|numeric|min:10',
            'loan_date'       => 'required|date|after_or_equal:today',
            'duration'        => 'required|numeric|min:1|max:7',
            'purpose'         => 'required|string|min:10',
            'loan_letter'     => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048', // WAJIB DIISI
        ], [
            'loan_letter.required' => 'Surat peminjaman wajib diunggah!',
            'loan_letter.file'     => 'Berkas yang diunggah harus berupa file.',
            'loan_letter.mimes'    => 'Format surat harus PDF, JPG, atau PNG.',
            'loan_letter.max'      => 'Ukuran file surat maksimal 2MB.',
            'purpose.min'          => 'Alasan keperluan minimal 10 karakter.',
        ]);

        $loanDate = Carbon::parse($request->loan_date);
        $returnDate = $loanDate->copy()->addDays((int) $request->duration);

        // Proses simpan file ke storage/app/public/loan_letters
        $letterPath = null;
        if ($request->hasFile('loan_letter')) {
            $letterPath = $request->file('loan_letter')->store('loan_letters', 'public');
        }

        // Simpan Header Peminjaman
        $loan = Loan::create([
            'user_id' => Auth::id(),
            'whatsapp_number' => $request->whatsapp_number,
            'loan_date' => $loanDate,
            'expected_return_date' => $returnDate,
            'purpose' => $request->purpose,
            'status' => 'pending',
            'loan_letter' => $letterPath,
            'pickup_status' => 'pending'
        ]);

        // Simpan Detail Item
        foreach ($request->item_ids as $itemId) {
            LoanDetail::create([
                'loan_id' => $loan->id,
                'item_id' => $itemId,
            ]);
        }

        // Notifikasi Email ke Admin
        $adminEmail = 'naufalds@student.ub.ac.id'; 
        try {
            Mail::to($adminEmail)->send(new NewLoanRequest($loan));
        } catch (\Exception $e) {}

        return redirect()->route('dashboard')->with('success', 'Pengajuan berhasil dikirim! Silakan tunggu konfirmasi Admin.');
    }


    // ==========================================
    // 2. FITUR EXTEND (MAHASISWA)
    // ==========================================

    public function extendForm(Loan $loan)
    {
        if($loan->status !== 'approved') {
            return back()->with('error', 'Peminjaman ini tidak bisa diperpanjang.');
        }
        return view('loans.extend', compact('loan'));
    }

    public function extendStore(Request $request, Loan $loan)
    {
        $request->validate([
            'extension_date' => 'required|date|after:today',
            'reason' => 'required|string|min:5'
        ]);

        $loan->update([
            'request_return_date' => $request->extension_date,
            'extension_reason' => $request->reason,
            'extension_status' => 'pending'
        ]);

        return redirect()->route('dashboard')->with('success', 'Permintaan perpanjangan dikirim!');
    }


    // ==========================================
    // 3. FITUR ADMIN (MANAGEMENT)
    // ==========================================

    public function adminIndex()
    {
        $loans = Loan::with(['user', 'details.item'])
                     ->orderByRaw("FIELD(status, 'pending', 'approved', 'returned', 'rejected')")
                     ->latest()
                     ->get();
                      
        return view('loans.admin', compact('loans'));
    }

    // A. Setujui Peminjaman
    public function approve(Loan $loan)
    {
        foreach($loan->details as $detail) {
            if($detail->item->status !== 'ready') {
                return back()->with('error', 'Gagal! Alat (' . $detail->item->name . ') sedang dipinjam.');
            }
        }

        $loan->update(['status' => 'approved']);

        // Update status alat jadi dipinjam
        $itemIds = $loan->details()->pluck('item_id');
        Item::whereIn('id', $itemIds)->update(['status' => 'borrowed']);

        return back()->with('success', 'Peminjaman disetujui!');
    }

    // B. Tandai Barang Sudah Diambil
    public function markAsPickedUp(Loan $loan)
    {
        $loan->pickup_status = 'picked_up';
        if ($loan->save()) {
            return back()->with('success', 'Status diperbarui: Barang telah diambil oleh mahasiswa.');
        }
        return back()->with('error', 'Gagal memperbarui status pengambilan.');
    }

    // C. Selesaikan Peminjaman (Barang Kembali)
    public function complete(Loan $loan)
    {
        $loan->update([
            'status' => 'returned',
            'actual_return_date' => now(),
            'pickup_status' => 'returned'
        ]);

        // Stok kembali Ready
        $itemIds = $loan->details()->pluck('item_id');
        if ($itemIds->isNotEmpty()) {
            Item::whereIn('id', $itemIds)->update(['status' => 'ready']);
        }

        return back()->with('success', 'Alat kembali! Stok otomatis update jadi Ready.');
    }

    // D. Tolak Peminjaman
    public function reject(Request $request, Loan $loan)
    {
        $request->validate(['reason' => 'required|string|min:3']);
        $loan->update([
            'status' => 'rejected',
            'admin_note' => $request->reason
        ]);
        return back()->with('success', 'Peminjaman ditolak.');
    }

    // E. Tandai Barang Tidak Diambil (Unclaimed)
    public function markAsUnclaimed(Loan $loan)
    {
        if ($loan->status == 'approved') {
            $loan->update([
                'status' => 'rejected', 
                'pickup_status' => 'unclaimed',
                'admin_note' => 'Barang tidak diambil sesuai jadwal.'
            ]);

            $itemIds = $loan->details()->pluck('item_id');
            Item::whereIn('id', $itemIds)->update(['status' => 'ready']);

            return back()->with('success', 'Status diperbarui: Barang tidak diambil.');
        }
        return back()->with('error', 'Aksi tidak valid.');
    }

    // F. Fitur Approve Extension
    public function approveExtension(Loan $loan)
    {
        $loan->update([
            'expected_return_date' => $loan->request_return_date,
            'extension_status' => 'approved',
            'request_return_date' => null,
        ]);
        return back()->with('success', 'Perpanjangan disetujui!');
    }

    public function rejectExtension(Request $request, Loan $loan)
    {
        $request->validate(['reason' => 'required|string|min:3']);
        $loan->update([
            'extension_status' => 'rejected',
            'admin_note' => 'Extend Ditolak: ' . $request->reason
        ]);
        return back()->with('success', 'Perpanjangan ditolak.');
    }
}
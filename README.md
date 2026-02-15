# 📦 UPMD Inventory Management System

![Laravel](https://img.shields.io/badge/Laravel-11.x-red?style=for-the-badge&logo=laravel)
![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-3.0-blue?style=for-the-badge&logo=tailwind-css)
![MySQL](https://img.shields.io/badge/MySQL-8.0-orange?style=for-the-badge&logo=mysql)
![PHP](https://img.shields.io/badge/PHP-8.2-purple?style=for-the-badge&logo=php)

Sistem Informasi Peminjaman Barang berbasis Web untuk **Unit Pengembangan Media Digital (UPMD)**. Aplikasi ini dirancang untuk mempermudah proses peminjaman, pengembalian, dan perpanjangan alat, serta dilengkapi dengan notifikasi email otomatis.

---

## 🚀 Fitur Unggulan

### 🔐 Autentikasi & Keamanan
- **Login SSO Google:** Login menggunakan email mahasiswa UB/Google.
- **Role Management:** Pembedaan akses antara *Mahasiswa*, *Admin*, dan *Superadmin*.
- **Superadmin Protection:** Akun Superadmin dikunci dan tidak bisa diturunkan jabatannya oleh admin lain.

### 🎒 Peminjaman (Loan)
- **Katalog Alat:** Pencarian dan filter kategori alat yang *Ready*.
- **Booking System:** Validasi tanggal dan durasi peminjaman (Maks. 7 hari).
- **Extension System:** Fitur perpanjangan waktu pinjam dengan persetujuan Admin.
- **History:** Riwayat peminjaman lengkap dengan status.

### 📧 Notifikasi Email (SMTP)
Sistem mengirim email otomatis saat:
- Mahasiswa mengajukan peminjaman.
- Admin menyetujui (*Approve*) peminjaman.
- Mahasiswa mengajukan perpanjangan (*Extend*).
- Admin menyetujui/menolak perpanjangan beserta alasannya.

### 📱 UI/UX Responsif
- **Desktop:** Tampilan tabel data yang luas dan informatif.
- **Mobile:** Tampilan otomatis berubah menjadi *Card View* yang nyaman di HP.

---

## 🛠️ Teknologi yang Digunakan
- **Backend:** Laravel Framework
- **Frontend:** Blade + Tailwind CSS

---
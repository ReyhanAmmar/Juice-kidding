# Juice Kidding — Project Rules & Guidelines

## 1. Tech Stack
- **Framework**: Laravel 12 (PHP 8.x), Monolith MVC (no API-first/SPA framework)
- **CSS**: Tailwind CSS (custom configuration defined in `app-admin.blade.php` and `main.blade.php`)
- **Icons**: Lucide Icons loaded via CDN (triggered using `lucide.createIcons()`)
- **Charts**: Chart.js (used in admin sales reports)
- **Database**: MySQL managed via Laragon

## 2. Architecture & File Structure
- **Controllers**: `AdminController`, `CustomerController`, `MitraController`, `ArtikelController`
- **Layouts**: 
  - `resources/views/layouts/main.blade.php` (Customer - Mobile container `max-w-sm mx-auto`)
  - `resources/views/layouts/app-admin.blade.php` (Admin - Desktop dashboard layout)
- **Auth**: Session-based auth with custom role middlewares:
  - `isAdmin` (Role ID: 1 - Admin)
  - `isCustomer` (Role ID: 2 - Customer)
  - `isPenjual` / `isDapur` (Role ID: 3 - Dapur Pusat)
  - `isDriver` (Role ID: 4 - Kurir Pengantar)

## 3. Database Schema (snake_case Bahasa Indonesia)
### Primary Keys
Semua tabel menggunakan nama kolom primary key format: `id_<nama_tabel>` (e.g., `id_pesanan`, `id_menu`, `id_user`).

### Daftar Tabel Utama:
*   **users**: `id_user`, `nama_lengkap`, `email`, `username`, `password`, `id_role`, `no_hp`, `foto_profil`, `poin`, `google_id`, `is_active`
*   **roles**: `id_role`, `nama_role` (Admin, Customer, Penjual, Driver), `is_active`
*   **menu_jus**: `id_menu`, `nama_jus`, `deskripsi`, `id_kategori`, `harga`, `foto`, `estimasi_kalori`, `rating_rata`, `id_status_stok` (1=Tersedia, 2=Habis)
*   **kategori_menu**: `id_kategori`, `nama_kategori`, `is_active`
*   **alamat_tersimpan**: `id_alamat`, `id_customer`, `label`, `alamat_lengkap`, `latitude`, `longitude`, `is_utama`
*   **pesanan**: `id_pesanan`, `kode_pesanan`, `id_customer`, `id_driver`, `id_tipe_pesanan` (1=Pick-up, 2=Delivery), `id_slot`, `tanggal_pesan`, `id_alamat`, `alamat_snapshot`, `jarak_km`, `subtotal`, `ongkos_kirim`, `total_bayar`, `id_status_pesanan`, `metode_pembayaran` (COD/Transfer), `id_batch_driver`
*   **detail_pesanan**: `id_detail`, `id_pesanan`, `id_menu`, `nama_menu_snapshot`, `jumlah`, `harga_satuan`, `subtotal`
*   **detail_pesanan_opsi**: `id_detail_opsi`, `id_detail`, `id_opsi`, `nama_opsi_snapshot`, `harga_tambahan_snapshot`
*   **riwayat_status_pesanan**: `id_riwayat`, `id_pesanan`, `id_status_pesanan`, `diubah_oleh` (id_user), `catatan`
*   **opsi_kustomisasi**: `id_opsi`, `id_tipe_opsi`, `nama_opsi`, `harga_tambahan`, `is_active`
*   **tipe_opsi**: `id_tipe_opsi`, `nama_tipe` (Ukuran, Gula, Topping), `wajib_pilih`, `pilih_banyak`
*   **keranjang**: `id_customer`, `id_menu`, `jumlah`, `subtotal`
*   **keranjang_opsi**: `id_keranjang_opsi`, `id_keranjang`, `id_opsi`
*   **notifikasi**: `id_notifikasi`, `id_user`, `judul`, `pesan`, `tipe`, `id_pesanan`, `sudah_dibaca`

### Status Pesanan (Order Status Values)
- `1` = Baru (Pesanan masuk, belum dikonfirmasi)
- `2` = Diproses (Sedang disiapkan di dapur)
- `3` = Siap (Pesanan selesai diracik, siap diambil/diantar)
- `4` = Diantar (Dalam pengiriman oleh driver)
- `5` = Sampai (Telah sampai di tujuan/alamat customer)
- `6` = Selesai (Transaksi ditutup dengan sukses)
- `7` = Dibatalkan (Dibatalkan oleh admin/sistem)

## 4. Integrasi Pihak Ketiga
### A. Google Login (Socialite)
- Konfigurasi ditaruh di `.env` (`GOOGLE_CLIENT_ID`, `GOOGLE_CLIENT_SECRET`, `GOOGLE_REDIRECT_URI`)
- Callback route: `https://<DOMAIN-NGROK>/auth/google/callback`
- Integrasi backend menggunakan `Socialite::driver('google')->user()`.

### B. Pencarian Alamat Gratis (OpenStreetMap + Leaflet.js + Nominatim API)
- Tidak menggunakan Google Maps SDK (karena berbayar).
- Map dirender di frontend memakai **Leaflet.js** (`L.map('map')`) dengan marker draggable.
- Fitur autocomplete pencarian alamat memanggil API gratis **Nominatim OpenStreetMap** (`https://nominatim.openstreetmap.org/search?q={query}&countrycodes=id`).

### C. Payment Gateway Midtrans (Snap API)
- Menggunakan library SDK `midtrans/midtrans-php`.
- Menggunakan popup Snap JS (`window.snap.pay`) di checkout frontend.
- API Webhook callback didaftarkan di `/api/midtrans/callback` untuk mengubah status pesanan secara otomatis (settlement, expire, cancel).

## 5. Design System
- **Primary Color**: `#E17D19` (Oranye Logo) - Class: `text-primary`, `bg-primary`
- **Secondary Color**: `#96C84B` (Hijau Logo) - Class: `text-secondary`, `bg-secondary`
- **Functional Colors**: 
  - Accent Red: `#E11919`, Accent Blue: `#194B96`, Accent Purple: `#7D4B96`
- **Fonts**: Nunito Sans (headings), System/Inter/Poppins (body)
- **UI Components Style**:
  - Admin cards: `rounded-3xl shadow-card border border-gray-100`
  - Customer cards: `rounded-2xl shadow-sm border border-zinc-100`
  - Form Inputs: `border-2 border-gray-200 rounded-2xl focus:border-primary`

## 6. Strict Rules for AI Coding
1. **Bahasa**: Selalu gunakan bahasa Indonesia untuk penulisan variabel baru, kolom database, komentar kode, dan dokumentasi commit.
2. **Komentar & Dokumen**: Jangan hapus komentar atau docstring asli yang tidak berhubungan dengan modifikasi yang sedang dilakukan.
3. **Seeder vs Controller**: Gunakan Query Builder `DB::table('nama_tabel')->insert(...)` di dalam Database Seeder, tetapi gunakan Eloquent Model (e.g. `Pesanan::create(...)`) di dalam Controller.
4. **Form & Security**: Setiap form input HTML harus menyertakan directive `@csrf`. Form dengan method selain GET/POST harus menyertakan spoofing `@method('PUT')` atau `@method('DELETE')`.
5. **Lingkup File**: Jangan pernah menulis atau memodifikasi file di luar direktori workspace (`c:\laragon\www\Juice-Kidding`).
6. **Desain & Animasi**: Tombol submit/proses harus memiliki transisi hover/active click (`active:scale-95 transition-all`). Jika terjadi error validasi, input harus ditandai dengan warna merah (`border-accent-red`) beserta teks pesan error di bawahnya.


# Panduan Implementasi & Dokumentasi: Dashboard Mitra (Dapur & Driver)

Dokumen ini berisi spesifikasi dan dokumentasi untuk **Dashboard Mitra** pada aplikasi **Juice Kidding**, mencakup Dashboard Dapur (Penjual) dan Dashboard Driver (Kurir).

---

## 📋 Status Implementasi

| Fitur | Status | Catatan |
|-------|--------|---------|
| Dashboard Dapur | ✅ Selesai | Stats, histori, aksi cepat |
| Antrian Pesanan | ✅ Selesai | AJAX polling 30s, update status |
| Stok Menu | ✅ Selesai | Input jumlah stok, toggle habis |
| Riwayat Pesanan | ✅ Selesai | Pagination, filter status |
| Header Dapur | ✅ Selesai | Dark header, nav tabs, user dropdown |
| Driver - Pengantaran | ❌ Belum | Perlu implementasi |
| Driver - Ambil Pesanan | ❌ Belum | Perlu implementasi |
| Driver - Selesai Antar | ❌ Belum | Perlu implementasi |
| Dynamic Role-based Tabs | ❌ Belum | Tabs/header masih statis |

---

## 🎨 Panduan Visual & Skema Warna (Juice Kidding Style)

### Tipografi
- **Font Utama:** `Nunito` (400..900) — rounded, playful, friendly
- **Fallback:** `Nunito Sans` (200..1000)
- **Body:** 14px (`text-sm`), weight 500 (`font-medium`)
- **Heading:** 16-24px (`text-base` sampai `text-2xl`), weight 700-900 (`font-bold` sampai `font-black`)

### Palette Warna (dari DESIGN.md)

| Peran | Hex | CSS Variable | Dipakai Untuk |
|-------|-----|-------------|---------------|
| **Primary** | `#E17D19` | `--color-primary` | CTA, kode pesanan, tab aktif, aksi utama |
| **Primary Dark** | `#C45E0A` | `--color-primary-dark` | Hover button |
| **Primary Light** | `#FDF3E7` | `--color-primary-light` | Background chip, hover ringan |
| **Secondary** | `#96C84B` | `--color-secondary` | Selesai, tersedia, online status |
| **Secondary Dark** | `#6E9A2A` | `--color-secondary-dark` | Teks di badge hijau |
| **Secondary Light** | `#EEF7D8` | `--color-secondary-light` | Background badge hijau |
| **Accent Blue** | `#194B96` | `--color-accent-blue` | Info, pick-up, navigasi driver |
| **Accent Purple** | `#7D4B96` | `--color-accent-purple` | Siap diambil, racikan |
| **Accent Red** | `#E11919` | `--color-accent-red` | Error, habis, bahaya |
| **Brand Dark** | `#1A1820` | `--text-dark` | Header dark mode, teks heading |
| **Body** | `#3D3A4A` | `--text-body` | Teks body |
| **Muted** | `#9B97A8` | `--text-muted` | Caption, placeholder |
| **Border** | `#E8E6F0` | `--border-subtle` | Border card, divider |
| **Surface** | `#F8F7FC` | `--surface-page` | Background halaman |

### Interaksi UI
- Semua tombol: `active:scale-95 transition-all` untuk efek tekan
- Card hover: `hover:shadow-[0_4px_16px_0_rgba(0,0,0,0.08)]`
- Focus: `focus-visible:ring-2 focus-visible:ring-[#E17D19]`
- Durasi transisi: 150-300ms

---

## 🏗️ Struktur Route

### Route Saat Ini (Sudah Berjalan)

```php
Route::middleware(['auth', 'isPenjual'])->prefix('dapur')->name('dapur.')->group(function () {
    Route::get('/dashboard', [MitraController::class, 'dashboardDapur'])->name('dashboard');
    Route::get('/antrian', [MitraController::class, 'antrianDapur'])->name('antrian');
    Route::get('/antrian/json', [MitraController::class, 'antrianDapurJson'])->name('antrian.json');
    Route::put('/update-status/{id_pesanan}', [MitraController::class, 'updateStatusPesanan'])->name('update-status');
    Route::get('/stok', [MitraController::class, 'stokDapur'])->name('stok');
    Route::put('/stok/{id_menu}/update', [MitraController::class, 'updateStok'])->name('stok.update');
    Route::get('/riwayat', [MitraController::class, 'riwayatDapur'])->name('riwayat');
    Route::get('/riwayat/json', [MitraController::class, 'riwayatDapurJson'])->name('riwayat.json');
});
```

### Route yang Direncanakan (Unified `/mitra`)

```php
Route::middleware(['auth'])->prefix('mitra')->name('mitra.')->group(function () {
    // Rute Dapur (Role: Penjual / Admin)
    Route::middleware(['isPenjual'])->group(function() {
        Route::get('/dashboard', [MitraController::class, 'dashboardDapur'])->name('dapur.dashboard');
        Route::get('/antrian', [MitraController::class, 'antrianDapur'])->name('dapur.antrian');
        Route::get('/antrian/json', [MitraController::class, 'antrianDapurJson'])->name('dapur.antrian.json');
        Route::get('/stok', [MitraController::class, 'stokDapur'])->name('dapur.stok');
        Route::put('/stok/{id_menu}/update', [MitraController::class, 'updateStok'])->name('dapur.stok.update');
        Route::get('/riwayat', [MitraController::class, 'riwayatDapur'])->name('dapur.riwayat');
        Route::get('/riwayat/json', [MitraController::class, 'riwayatDapurJson'])->name('dapur.riwayat.json');
        Route::put('/update-status/{id_pesanan}', [MitraController::class, 'updateStatusPesanan'])->name('update-status');
    });

    // Rute Driver (Role: Driver / Admin)
    Route::middleware(['isDriver'])->group(function() {
        Route::get('/pengantaran', [MitraController::class, 'pengantaranDriver'])->name('driver.pengantaran');
        Route::put('/ambil-pesanan/{id_pesanan}', [MitraController::class, 'ambilPesanan'])->name('driver.ambil-pesanan');
        Route::put('/selesai-antar/{id_pesanan}', [MitraController::class, 'selesaiAntar'])->name('driver.selesai-antar');
    });
});
```

---

## 📁 Struktur File

### Halaman Dapur (✅ Sudah)
```
resources/views/mitra/
├── dashboard.blade.php          # Dashboard utama
├── antrian-dapur.blade.php      # Antrian pesanan (AJAX polling)
├── stok.blade.php               # Manajemen stok menu
├── riwayat-dapur.blade.php      # Riwayat pesanan (paginated)
├── partials/
│   ├── dapur-header.blade.php   # Header navigasi dark
│   ├── dapur-cards.blade.php    # Card antrian (untuk AJAX)
│   ├── dapur-tabs.blade.php     # Tab navigasi (legacy)
│   └── riwayat-list.blade.php   # List riwayat (untuk AJAX)
```

### Halaman Driver (❌ Belum)
```
resources/views/mitra/
├── list-delivery.blade.php      # Halaman pengantaran driver
```

---

## 📄 Halaman yang Sudah Dibuat

### 1. Dashboard Dapur
- **Route:** `GET /dapur/dashboard` → `MitraController@dashboardDapur`
- **View:** `mitra.dashboard`
- **Data:** `pesananBaru`, `pesananDiproses`, `pesananSiap`, `pesananSelesai`, `latestOrders`, `orderHistory`
- **Fitur:**
  - 4 stat cards (Baru, Diproses, Siap, Selesai)
  - Queue history (10 pesanan terakhir selesai hari ini)
  - Active orders table (5 pesanan terbaru)
  - Quick actions (Kelola Antrian, Perbarui Stok)
  - System clock (realtime)

### 2. Antrian Pesanan
- **Route:** `GET /dapur/antrian` → `MitraController@antrianDapur`
- **Route JSON:** `GET /dapur/antrian/json` → `MitraController@antrianDapurJson`
- **View:** `mitra.antrian-dapur` + `mitra.partials.dapur-cards`
- **Fitur:**
  - AJAX polling setiap 30 detik
  - Update status via AJAX (1 → 2 → 3)
  - Order count badge realtime
  - Manual refresh button
  - Toast notification
  - Auto-dismiss alerts

### 3. Stok Menu
- **Route:** `GET /dapur/stok` → `MitraController@stokDapur`
- **Route Update:** `PUT /dapur/stok/{id}/update` → `MitraController@updateStok`
- **View:** `mitra.stok`
- **Data:** `menu` (MenuJus with kategori)
- **Fitur:**
  - Grid menu dengan gambar
  - Input jumlah stok (number)
  - Toggle Tersedia/Habis
  - Counter header (X tersedia / Y habis)
  - Badge kategori menu

### 4. Riwayat Pesanan
- **Route:** `GET /dapur/riwayat` → `MitraController@riwayatDapur`
- **Route JSON:** `GET /dapur/riwayat/json` → `MitraController@riwayatDapurJson`
- **View:** `mitra.riwayat-dapur` + `mitra.partials.riwayat-list`
- **Data:** `riwayat` (paginated, 20/page), `totalHariIni`
- **Fitur:**
  - 4 stat cards (Total, Selesai, Siap, Diantar)
  - List riwayat dengan status icon
  - Durasi persiapan (menit)
  - Pagination
  - Empty state

### 5. Header Dapur
- **View:** `mitra.partials.dapur-header`
- **Fitur:**
  - Dark background (`#1A1820`) dengan backdrop blur
  - Rainbow gradient accent bar (2px)
  - Logo JK (static, no link)
  - Nav tabs: Dashboard, Antrian, Stok, Riwayat
  - Nav tabs: halaman aktif berupa `<span>`, bukan link
  - User avatar + dropdown (hanya nama + Keluar)
  - Tidak ada link ke customer/landing page

---

## 🚚 Driver (Belum Diimplementasikan)

### Metode yang Perlu Ditambahkan ke MitraController

```php
// Tampilkan halaman daftar pengantaran driver
public function pengantaranDriver()
{
    $idDriver = Auth::id();

    // 1. Antrean Delivery (Status 3, tipe 2, id_driver NULL)
    $antrean = Pesanan::with(['customer', 'alamat'])
        ->where('id_tipe_pesanan', 2)
        ->where('id_status_pesanan', 3)
        ->whereNull('id_driver')
        ->orderBy('id_pesanan', 'asc')
        ->get();

    // 2. Pengantaran Aktif (Status 4, id_driver driver yang login)
    $aktif = Pesanan::with(['customer', 'alamat', 'detail_pesanan.menu'])
        ->where('id_driver', $idDriver)
        ->where('id_status_pesanan', 4)
        ->orderBy('id_pesanan', 'asc')
        ->get();

    // 3. Riwayat Pengantaran (Status 5 / 6, id_driver driver saat ini)
    $riwayat = Pesanan::with(['customer'])
        ->where('id_driver', $idDriver)
        ->whereIn('id_status_pesanan', [5, 6])
        ->orderBy('updated_at', 'desc')
        ->take(10)
        ->get();

    return view('mitra.list-delivery', compact('antrean', 'aktif', 'riwayat'));
}

// Ambil Pesanan (Assign Driver)
public function ambilPesanan(Request $request, $id_pesanan)
{
    $pesanan = Pesanan::findOrFail($id_pesanan);
    if ($pesanan->id_driver !== null) {
        return response()->json(['success' => false, 'message' => 'Pesanan sudah diambil oleh driver lain!']);
    }
    $pesanan->id_driver = Auth::id();
    $pesanan->id_status_pesanan = 4; // Diantar
    $pesanan->save();
    RiwayatStatusPesanan::create([
        'id_pesanan' => $pesanan->id_pesanan,
        'id_status_pesanan' => 4,
        'diubah_oleh' => Auth::id(),
        'catatan' => 'Pesanan siap diantar dan telah diambil oleh driver.'
    ]);
    return response()->json(['success' => true, 'message' => 'Pesanan berhasil diambil!']);
}

// Selesai Antar (Sampai)
public function selesaiAntar(Request $request, $id_pesanan)
{
    $pesanan = Pesanan::findOrFail($id_pesanan);
    if ($pesanan->id_driver != Auth::id()) {
        return response()->json(['success' => false, 'message' => 'Akses ditolak.']);
    }
    $pesanan->id_status_pesanan = 5; // Sampai
    $pesanan->save();
    RiwayatStatusPesanan::create([
        'id_pesanan' => $pesanan->id_pesanan,
        'id_status_pesanan' => 5,
        'diubah_oleh' => Auth::id(),
        'catatan' => 'Pesanan telah diantarkan sampai ke alamat customer.'
    ]);
    return response()->json(['success' => true, 'message' => 'Pengantaran sukses!']);
}
```

### Halaman Driver yang Perlu Dibuat
Halaman `resources/views/mitra/list-delivery.blade.php` dengan:
- **Antrean Delivery:** Kartu pesanan siap antar (status 3, delivery, tanpa driver)
- **Pengantaran Aktif:** Kartu pesanan yang sedang diantar oleh driver
- **Riwayat:** Daftar pesanan yang sudah selesai diantar
- **Tombol Aksi:** "Ambil Pesanan" (oranye), "Selesai Antar" (hijau), "Navigasi" (biru, buka Google Maps), "Hubungi Customer" (WhatsApp)

---

## 🧭 Navigasi

### Header Saat Ini (dapur-header.blade.php)
```
┌──────────────────────────────────────────────────────────────┐
│ 🌈 Rainbow bar (2px)                                          │
│ [JK] DAPUR  │  Dashboard  │  Antrian  │  Stok  │  Riwayat  │  👤  │
└──────────────────────────────────────────────────────────────┘
```

### Header yang Direncanakan (Role-based)
```
┌──────────────────────────────────────────────────────────────┐
│ 🌈 Rainbow bar                                                 │
│ [JK] MITRA  │  Dashboard  │  Antrian  │  Stok  │  Riwayat  │  👤  │
│              │  Pengantaran (Driver) — hanya untuk role=4     │
└──────────────────────────────────────────────────────────────┘
```

---

## ⚠️ Catatan Penting

1. **Font:** Gunakan `Nunito` (400-900) sebagai font utama. `Nunito Sans` hanya sebagai fallback.
2. **Header:** Semua halaman dapur menggunakan `dapur-header.blade.php` dengan `hideHeader => true, hideMinimalHeader => true`.
3. **Tidak ada link ke customer:** Header dapur tidak boleh memiliki link ke halaman landing/customer.
4. **AJAX:** Halaman antrian dan riwayat menggunakan polling AJAX, bukan reload halaman penuh.
5. **Brand identity:** Rainbow bar, warna oranye primary, dan font Nunito adalah identitas Juice Kidding yang harus dipertahankan.
6. **Stok:** Form mengirim `stok` (integer quantity), controller mengatur `id_status_stok` otomatis (1 jika stok > 0, 2 jika stok = 0).
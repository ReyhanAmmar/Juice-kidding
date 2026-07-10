# Panduan Implementasi & Prompt AI: Dashboard & Detail Pesanan Driver

Dokumen ini berisi spesifikasi teknis dan prompt instruksi lengkap untuk mengimplementasikan halaman **Dashboard Driver** dan **Detail Pesanan** pada aplikasi **Juice Kidding**. Halaman ini dirancang khusus untuk kurir/driver pengantar guna mengambil antrean pesanan, melacak alamat pengantaran customer, dan menavigasi rute langsung ke titik lokasi customer menggunakan peta interaktif.

---

## 📋 Alur Bisnis & Kebutuhan Fungsional Driver

1. **Dashboard Tiga Tab Utama:**
   - **Tab 1: Antrean Delivery (Siap Diambil):** Menampilkan pesanan dengan `id_tipe_pesanan = 2` (Delivery), status `3` (Siap), dan `id_driver` masih kosong (`NULL`).
   - **Tab 2: Pengantaran Aktif (Sedang Diantar):** Menampilkan pesanan yang sedang diantar oleh driver saat ini (`id_driver = Auth::id()` dan status `4` = Diantar).
   - **Tab 3: Riwayat Pengantaran (Terkirim):** Menampilkan semua pesanan yang telah berhasil diantar oleh driver saat ini (status `5` = Sampai atau `6` = Selesai).

2. **Detail Pesanan & Navigasi Maps:**
   - **Alamat Lengkap & Koordinat:** Menampilkan alamat snapshot customer secara detail.
   - **Tombol Navigasi / Maps Interaktif:**
     - Jika alamat memiliki koordinat `latitude` dan `longitude` yang valid (dari tabel `alamat_tersimpan`), tombol navigasi akan membuka rute langsung di Google Maps:
       `https://www.google.com/maps/dir/?api=1&destination={latitude},{longitude}`
     - Jika koordinat kosong, tombol membuka pencarian alamat teks di Google Maps:
       `https://www.google.com/maps/search/?api=1&query={alamat_snapshot}`
   - **Hubungi Customer:** Menyediakan tombol cepat untuk menghubungi nomor HP customer via WhatsApp (`https://wa.me/no_hp`).

3. **Aksi Driver:**
   - **Ambil Pesanan:** Menetapkan driver saat ini ke pesanan, mengubah status pesanan menjadi `4` (Diantar), dan merekam riwayat status pesanan.
   - **Selesai Antar:** Mengubah status pesanan menjadi `5` (Sampai) atau `6` (Selesai), merekam riwayat status pesanan, dan memicu notifikasi push ke customer.

---

## 🎨 1. Panduan Desain & Visual (Juice Kidding Style)

*   **Color Palette (Skema Warna):**
    - **Warna Primer:** `#E17D19` (Oranye Logo) - gunakan class `bg-primary`, `text-primary` untuk tombol "Ambil Pesanan", status tunggu, dan aksen penting.
    - **Warna Sekunder:** `#96C84B` (Hijau Logo) - gunakan class `bg-secondary`, `text-secondary` untuk tombol "Selesai Antar", status terkirim, dan ikon sukses.
    - **Warna Fungsional:** Accent Blue (`#194B96`) untuk tombol Navigasi Maps, Accent Red (`#E11919`) untuk penanda pin peta, dan Accent Purple (`#7D4B96`) untuk info ringkasan.
*   **Tipografi:**
    - Gunakan font **Nunito / Nunito Sans** untuk semua judul halaman dan elemen teks di kartu pesanan agar terkesan modern dan ramah.
*   **Komponen UI:**
    - **Kartu Pesanan:** Desain clean dengan class `rounded-2xl shadow-sm border border-zinc-100 bg-white p-4`.
    - **Tombol Interaktif:** Wajib menyertakan efek hover dan transisi active click (`active:scale-95 transition-all`).

---

## 💻 2. Sisi Backend (Laravel)

### A. Rute Driver (`routes/web.php`)
Pastikan rute driver memanggil controller yang tepat. Anda dapat memindahkan logika ke controller baru bernama `DriverController.php` untuk menjaga kerapian kode:

```php
use App\Http\Controllers\DriverController;

Route::middleware(['auth', 'isDriver'])->prefix('driver')->name('driver.')->group(function () {
    Route::get('/pengantaran', [DriverController::class, 'index'])->name('pengantaran');
    Route::put('/ambil-pesanan/{id_pesanan}', [DriverController::class, 'ambilPesanan'])->name('ambil-pesanan');
    Route::put('/selesai-antar/{id_pesanan}', [DriverController::class, 'selesaiAntar'])->name('selesai-antar');
});
```

### B. Controller Driver (`app/Http/Controllers/DriverController.php`)
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\RiwayatStatusPesanan;
use App\Models\Notifikasi;
use Illuminate\Support\Facades\Auth;

class DriverController extends Controller
{
    public function index()
    {
        $idDriver = Auth::id();

        // 1. Antrean Delivery (Siap diambil, tipe pesanan delivery, status 3, belum ada driver)
        $antrean = Pesanan::with(['customer', 'alamat'])
            ->where('id_tipe_pesanan', 2)
            ->where('id_status_pesanan', 3)
            ->whereNull('id_driver')
            ->orderBy('id_pesanan', 'asc')
            ->get();

        // 2. Pengantaran Aktif (Sedang diantar oleh driver saat ini, status 4)
        $aktif = Pesanan::with(['customer', 'alamat', 'detail_pesanan.menu'])
            ->where('id_driver', $idDriver)
            ->where('id_status_pesanan', 4)
            ->orderBy('id_pesanan', 'asc')
            ->get();

        // 3. Riwayat Pengantaran (Selesai/Sampai oleh driver saat ini, status 5 atau 6)
        $riwayat = Pesanan::with(['customer'])
            ->where('id_driver', $idDriver)
            ->whereIn('id_status_pesanan', [5, 6])
            ->orderBy('updated_at', 'desc')
            ->take(15)
            ->get();

        return view('mitra.list-delivery', compact('antrean', 'aktif', 'riwayat'));
    }

    public function ambilPesanan(Request $request, $id_pesanan)
    {
        $pesanan = Pesanan::findOrFail($id_pesanan);

        if ($pesanan->id_driver !== null) {
            return response()->json(['success' => false, 'message' => 'Pesanan sudah diambil oleh driver lain!']);
        }

        $pesanan->id_driver = Auth::id();
        $pesanan->id_status_pesanan = 4; // Diantar
        $pesanan->save();

        // Catat riwayat status
        RiwayatStatusPesanan::create([
            'id_pesanan' => $pesanan->id_pesanan,
            'id_status_pesanan' => 4,
            'diubah_oleh' => Auth::id(),
            'catatan' => 'Pesanan diambil dan sedang diantar oleh driver.'
        ]);

        // Kirim notifikasi ke customer
        Notifikasi::create([
            'id_user' => $pesanan->id_customer,
            'judul' => 'Pesanan Sedang Diantar',
            'pesan' => 'Jus pesanan Anda #' . $pesanan->kode_pesanan . ' sedang dalam perjalanan oleh driver kami.',
            'tipe' => 'pesanan',
            'id_pesanan' => $pesanan->id_pesanan,
            'sudah_dibaca' => false
        ]);

        return response()->json(['success' => true, 'message' => 'Pesanan berhasil diambil!']);
    }

    public function selesaiAntar(Request $request, $id_pesanan)
    {
        $pesanan = Pesanan::findOrFail($id_pesanan);

        if ($pesanan->id_driver != Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Anda tidak memiliki hak untuk menyelesaikan pesanan ini.']);
        }

        $pesanan->id_status_pesanan = 5; // Sampai di tujuan
        $pesanan->save();

        // Catat riwayat status
        RiwayatStatusPesanan::create([
            'id_pesanan' => $pesanan->id_pesanan,
            'id_status_pesanan' => 5,
            'diubah_oleh' => Auth::id(),
            'catatan' => 'Pesanan telah sampai di lokasi tujuan customer.'
        ]);

        // Kirim notifikasi ke customer
        Notifikasi::create([
            'id_user' => $pesanan->id_customer,
            'judul' => 'Pesanan Telah Sampai',
            'pesan' => 'Jus pesanan Anda #' . $pesanan->kode_pesanan . ' telah sampai di tujuan. Terima kasih!',
            'tipe' => 'pesanan',
            'id_pesanan' => $pesanan->id_pesanan,
            'sudah_dibaca' => false
        ]);

        return response()->json(['success' => true, 'message' => 'Pesanan telah berhasil diantarkan!']);
    }
}
```

---

## 🎨 3. Sisi Frontend Driver View (`mitra/list-delivery.blade.php`)

Gunakan struktur layout mobile-friendly dengan visual interaktif:

### A. Tampilan Tab Navigasi & List
```html
{{-- Tab Header --}}
<div class="flex border-b border-gray-100 mb-4 bg-white sticky top-14 z-20">
    <button onclick="switchTab('antrean')" id="tab-btn-antrean" class="flex-1 py-3 text-center text-sm font-black text-primary border-b-2 border-primary font-['Nunito_Sans']">
        Antrean (${antrean->count()})
    </button>
    <button onclick="switchTab('aktif')" id="tab-btn-aktif" class="flex-1 py-3 text-center text-sm font-bold text-gray-500 border-b-2 border-transparent font-['Nunito_Sans']">
        Aktif (${aktif->count()})
    </button>
    <button onclick="switchTab('riwayat')" id="tab-btn-riwayat" class="flex-1 py-3 text-center text-sm font-bold text-gray-500 border-b-2 border-transparent font-['Nunito_Sans']">
        Riwayat
    </button>
</div>
```

### B. JavaScript Navigasi Peta & Aksi AJAX
```javascript
// Navigasi Google Maps Cerdas
function navigateToCustomer(address, lat, lng) {
    let url = "";
    if (lat && lng && lat !== "null" && lng !== "null") {
        // Jika ada koordinat, gunakan petunjuk arah (routing)
        url = `https://www.google.com/maps/dir/?api=1&destination=${lat},${lng}`;
    } else {
        // Jika tidak, gunakan pencarian alamat teks
        url = `https://www.google.com/maps/search/?api=1&query=${encodeURIComponent(address)}`;
    }
    window.open(url, '_blank');
}

// Hubungi Customer via WhatsApp
function contactCustomer(phone) {
    let formattedPhone = phone.replace(/[^0-9]/g, '');
    if (formattedPhone.startsWith('0')) {
        formattedPhone = '62' + formattedPhone.slice(1);
    }
    window.open(`https://wa.me/${formattedPhone}`, '_blank');
}

// Ambil Pesanan AJAX
function ambilPesanan(idPesanan) {
    if (!confirm("Ambil pesanan ini untuk diantar?")) return;

    fetch(`/driver/ambil-pesanan/${idPesanan}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(res => res.json())
    .then(data => {
        if(data.success) {
            showToast(data.message, '📦');
            setTimeout(() => window.location.reload(), 1000);
        } else {
            alert(data.message);
        }
    });
}
```

---

## 🤖 Prompt AI Lengkap untuk Eksekusi (Siap Copy-Paste)

Berikut adalah prompt lengkap untuk diumpankan ke AI coder Anda:

```text
Buatkan fitur Dashboard Driver dan Detail Pesanan pada aplikasi Laravel Monolith "Juice Kidding" dengan panduan berikut:

1. CONTROLLER & BACKEND (DRIVER LOGIC):
   - Buat controller baru bernama `DriverController.php` di folder App/Http/Controllers.
   - Implementasikan method `index()` untuk mengelompokkan pesanan menjadi tiga kategori:
     - Antrean: Pesanan dengan status = 3 (Siap), tipe = 2 (Delivery), dan id_driver is NULL.
     - Aktif: Pesanan yang sedang dikirim oleh driver saat ini (status = 4, id_driver = Auth::id()).
     - Riwayat: Pesanan yang telah dikirim oleh driver saat ini (status >= 5, id_driver = Auth::id()).
   - Implementasikan method `ambilPesanan($id)` untuk memasukkan ID driver yang login ke pesanan, mengubah status pesanan ke 4 (Diantar), dan menyimpan riwayat status.
   - Implementasikan method `selesaiAntar($id)` untuk mengubah status ke 5 (Sampai), menyimpan riwayat status, dan mengirim notifikasi sukses kepada pelanggan.
   - Daftarkan rute-rute driver dengan middleware 'isDriver' dan prefix 'driver' di web.php.

2. FRONTEND VIEW (DRIVERS INTERFACE):
   - Modifikasi berkas `resources/views/mitra/list-delivery.blade.php`. Terapkan layout `layouts.main` dengan mode minimalis (hideHeader = true, hideFooter = true).
   - Terapkan skema warna visual Juice Kidding yang premium:
     - Warna Primer: #E17D19 (Oranye) untuk tombol "Ambil Pesanan", status tunggu, dan aksen penting.
     - Warna Sekunder: #96C84B (Hijau) untuk tombol "Selesai Antar" dan status terkirim.
     - Warna Fungsional: Accent Blue (#194B96) untuk tombol "Navigasi".
   - Buat tab switcher sederhana (Antrean, Aktif, Riwayat) menggunakan CSS/JS.
   - Pada kartu pesanan Aktif dan Detail Pesanan:
     - Tambahkan tombol "Navigasi" dengan logika: Jika tabel alamat memiliki koordinat latitude/longitude, buka Google Maps Rute (https://www.google.com/maps/dir/?api=1&destination=lat,lng). Jika tidak, buka Google Maps Pencarian menggunakan alamat snapshot.
     - Tambahkan tombol "Hubungi Customer" yang membuka tautan cepat WhatsApp (https://wa.me/no_hp_format_internasional).
     - Buat detail item menu yang dipesan tampil rapi beserta harganya.
     - Terapkan efek mikro-animasi active:scale-95 pada tombol-tombol.

Gunakan bahasa Indonesia untuk penulisan komentar kode, nama variabel baru, dan dokumentasi di dalam controller.
```

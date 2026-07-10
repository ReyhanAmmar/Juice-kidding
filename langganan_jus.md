# Panduan Implementasi & Prompt AI: Fitur Langganan Jus Mingguan (Daily Order Generation)

Dokumen ini berisi spesifikasi teknis dan prompt instruksi lengkap untuk mengimplementasikan fitur **Langganan Jus Mingguan** pada aplikasi **Juice Kidding**. Fitur ini dirancang secara efektif dengan cara mengonversi paket langganan menjadi pesanan harian biasa bernilai Rp0, sehingga dapur dan driver dapat memproses pengiriman harian menggunakan sistem antrean yang sudah ada tanpa memerlukan perubahan alur kerja yang kompleks.

---

## 📋 Konsep Sistem & Alur Kerja

1. **Pembelian Paket Langganan (Customer):**
   - Customer mengakses halaman `/langganan` untuk melihat 3 pilihan paket:
     - **Starter (Rp250rb):** 3 botol / minggu.
     - **Healthy (Rp450rb):** 6 botol / minggu.
     - **Ultimate (Rp800rb):** 12 botol / minggu.
   - Saat checkout, customer memilih alamat pengantaran, hari pengiriman dalam seminggu (misal: Senin, Rabu, Jumat), dan melakukan pembayaran lunas menggunakan Midtrans Snap API.

2. **Pencatatan Paket Aktif di Database:**
   - Setelah pembayaran lunas (`settlement`), sistem mencatat kuota pengantaran ke dalam tabel `langganan_aktif` (misal kuota = 6 untuk paket Healthy) dan menandainya sebagai aktif (`is_active = 1`).

3. **Pembuatan Pesanan Harian Otomatis (Daily Generation):**
   - Setiap pagi (menggunakan Cron Scheduler harian Laravel atau tombol pemicu manual di dashboard Admin), sistem akan memeriksa daftar paket yang aktif pada hari tersebut.
   - Untuk setiap paket yang terjadwal kirim hari ini:
     - Sistem membuat entri baru di tabel **`pesanan`** dengan harga `total_bayar = 0` (karena sudah dibayar di depan) dan status `1` (Baru).
     - Kode pesanan diberi awalan khusus: **`JK-SUB-{id_langganan}-{sisa_kuota}`**.
     - Sistem membuat detail menu jus yang akan dikirim (misal: menu terlaris hari itu secara acak, atau jus default pilihan customer).
     - Mengurangi kuota `sisa_pengiriman` sebanyak 1. Jika kuota habis (`0`), ubah status paket menjadi nonaktif (`is_active = 0`).

4. **Pemrosesan Dapur & Driver (Mitra Side):**
   - Pesanan langganan harian otomatis muncul di antrean **Dapur** dengan status *Baru*. Pada baris pesanan, sistem menampilkan badge **`Langganan`** (warna ungu/violet `#7D4B96`) agar mudah dibedakan.
   - Setelah dapur meracik jus, status diubah menjadi *Siap*.
   - **Driver** mengambil antrean pengantaran tersebut di dashboard pengantaran, melihat peta rute ke alamat customer, lalu mengantarkannya hingga berstatus *Sampai*.

---

## 🗄️ 1. Skema Database Baru

Buat file migrasi baru untuk menyimpan data langganan yang dibeli customer:

```php
Schema::create('langganan_aktif', function (Blueprint $table) {
    $table->id('id_langganan');
    $table->unsignedBigInteger('id_customer');
    $table->string('nama_paket', 50); // Starter, Healthy, Ultimate
    $table->integer('total_harga');
    $table->integer('total_pengiriman'); // Misal: 6, 12, 24
    $table->integer('sisa_pengiriman');  // Berkurang setiap kali pesanan harian dibuat
    $table->unsignedBigInteger('id_alamat'); // Alamat kirim utama
    $table->text('hari_pengiriman'); // JSON array hari kirim, misal: ["Senin", "Rabu", "Jumat"]
    $table->string('status_pembayaran', 30)->default('Menunggu'); // Menunggu, Lunas, Batal
    $table->boolean('is_active')->default(false); // Aktif setelah lunas dan sisa > 0
    $table->timestamps();

    $table->foreign('id_customer')->references('id_user')->on('users')->onDelete('cascade');
    $table->foreign('id_alamat')->references('id_alamat')->on('alamat_tersimpan')->onDelete('cascade');
});
```

---

## 💻 2. Sisi Backend & Logika Pengantaran Harian (Laravel)

### A. Routing Baru (`routes/web.php`)
```php
// Halaman depan pembelian paket
Route::get('/langganan', [CustomerController::class, 'halamanLangganan'])->name('langganan.index');

// Checkout & Bayar Langganan (Customer)
Route::middleware(['auth', 'isCustomer'])->group(function() {
    Route::get('/langganan/checkout/{paket}', [CustomerController::class, 'checkoutLangganan'])->name('langganan.checkout');
    Route::post('/langganan/proses', [CustomerController::class, 'prosesPembelianLangganan'])->name('langganan.proses');
});

// Pemicu Generator Harian (Admin/Dapur)
Route::middleware(['auth', 'isAdmin'])->post('/admin/langganan/generate-daily', [AdminController::class, 'generateDailySubscriptionOrders'])->name('admin.langganan.generate');
```

### B. Fungsi Pembuat Pesanan Harian (Order Generator)
Implementasikan fungsi di Controller (misal `AdminController.php`) untuk memicu pembuatan pesanan harian:

```php
public function generateDailySubscriptionOrders()
{
    $hariIni = \Carbon\Carbon::now()->locale('id')->dayName; // Mengambil nama hari: "Senin", "Selasa", dll.
    
    // Ambil paket langganan yang aktif dan hari ini terjadwal kirim
    $langgananAktif = \App\Models\LanggananAktif::where('is_active', true)
        ->where('sisa_pengiriman', '>', 0)
        ->where('status_pembayaran', 'Lunas')
        ->get()
        ->filter(function($item) use ($hariIni) {
            $hariKirim = json_decode($item->hari_pengiriman, true) ?: [];
            return in_array($hariIni, $hariKirim);
        });

    $count = 0;
    foreach ($langgananAktif as $sub) {
        // 1. Pilih menu jus default (misal, menu terlaris secara acak)
        $menu = \App\Models\MenuJus::where('id_status_stok', 1)->inRandomOrder()->first();
        if (!$menu) continue;

        // 2. Buat pesanan baru bernilai Rp0
        $kodePesanan = 'JK-SUB-' . $sub->id_langganan . '-' . str_pad($sub->sisa_pengiriman, 2, '0', STR_PAD_LEFT);
        
        // Cek apakah hari ini pesanan ini sudah pernah dibuat sebelumnya (mencegah duplikasi kirim)
        $exist = \App\Models\Pesanan::where('kode_pesanan', $kodePesanan)->exists();
        if ($exist) continue;

        $pesanan = \App\Models\Pesanan::create([
            'kode_pesanan' => $kodePesanan,
            'id_customer' => $sub->id_customer,
            'id_tipe_pesanan' => 2, // Delivery
            'tanggal_pesan' => \Carbon\Carbon::today(),
            'id_alamat' => $sub->id_alamat,
            'alamat_snapshot' => $sub->alamat->alamat_lengkap ?? 'Alamat Langganan',
            'subtotal' => 0,
            'ongkos_kirim' => 0,
            'total_bayar' => 0,
            'id_status_pesanan' => 1, // Baru
            'metode_pembayaran' => 'Langganan'
        ]);

        // 3. Tambahkan Detail Menu
        \App\Models\DetailPesanan::create([
            'id_pesanan' => $pesanan->id_pesanan,
            'id_menu' => $menu->id_menu,
            'nama_menu_snapshot' => $menu->nama_jus . ' (Paket Langganan)',
            'jumlah' => 1,
            'harga_satuan' => 0,
            'subtotal' => 0
        ]);

        // 4. Kurangi sisa kuota langganan
        $sub->sisa_pengiriman -= 1;
        if ($sub->sisa_pengiriman <= 0) {
            $sub->is_active = false;
        }
        $sub->save();

        $count++;
    }

    return back()->with('success', "Berhasil membuat $count pesanan langganan untuk hari ini ($hariIni).");
}
```

---

## 🎨 3. Sisi Frontend (Dapur & Driver Badge)

Di view dapur (`mitra/antrian-dapur.blade.php`) dan driver (`mitra/list-delivery.blade.php`), tambahkan badge **Langganan** berwarna ungu violet jika metode pembayaran pesanan adalah 'Langganan':

```html
@if($item->metode_pembayaran == 'Langganan')
    <span class="inline-flex items-center gap-1 text-[11px] font-bold text-white bg-[#7D4B96] px-2.5 py-0.5 rounded-full ml-2">
        <i data-lucide="sparkles" class="w-3 h-3"></i> Langganan
    </span>
@endif
```

---

## 🤖 Prompt AI Lengkap untuk Eksekusi (Siap Copy-Paste)

Berikut adalah prompt lengkap untuk diumpankan ke AI coder Anda:

```text
Buatkan fitur "Langganan Jus Mingguan" lengkap dengan sistem pembuat pesanan harian otomatis pada aplikasi Laravel Monolith "Juice Kidding" dengan panduan berikut:

1. DATABASE & MIGRATION:
   - Buat tabel baru bernama `langganan_aktif` yang menyimpan: id_langganan, id_customer, nama_paket (Starter/Healthy/Ultimate), total_harga, total_pengiriman, sisa_pengiriman (integer), id_alamat (foreign key ke alamat_tersimpan), hari_pengiriman (text/JSON), status_pembayaran (default 'Menunggu'), dan is_active (boolean, default false).

2. CUSTOMER SIDE (CHECKOUT LANGGANAN & MIDTRANS):
   - Buat halaman depan `/langganan` untuk menampilkan paket langganan.
   - Buat halaman checkout khusus untuk langganan: Customer memilih alamat utama, memilih hari pengiriman (misal: tiap hari Senin, Rabu, Jumat), dan melakukan pembayaran dengan Midtrans Snap API.
   - Di webhook/callback callback pembayaran (PaymentCallbackController), jika pembayaran paket langganan sukses (settlement), ubah `status_pembayaran` di `langganan_aktif` menjadi 'Lunas', set `is_active` = true, dan isi `sisa_pengiriman` sesuai kuota paket.

3. DAILY ORDER GENERATOR LOGIC:
   - Buat fungsi `generateDailySubscriptionOrders()` di `AdminController.php` (dan buat rutenya).
   - Logika: Ambil semua data `langganan_aktif` yang aktif dan hari ini terjadwal kirim. Buat satu baris pesanan baru di tabel `pesanan` untuk masing-masing data dengan total_bayar = 0, ongkos_kirim = 0, metode_pembayaran = 'Langganan', dan status_pesanan = 1 (Baru). Tambahkan detail menu jus acak yang sedang tersedia, lalu kurangi sisa_pengiriman sebanyak 1. Jika sisa_pengiriman habis (0), set is_active menjadi false.

4. MITRA DASHBOARD LABELS:
   - Modifikasi halaman antrean dapur (`antrian-dapur.blade.php`) dan halaman pengantaran driver (`list-delivery.blade.php`).
   - Berikan badge khusus berwarna ungu violet (#7D4B96) bertuliskan "Langganan" untuk setiap pesanan yang memiliki metode_pembayaran = 'Langganan' agar peracik dapur dan kurir mengetahuinya dengan mudah.

Gunakan bahasa Indonesia untuk penulisan komentar kode, nama variabel baru, dan dokumentasi di dalam controller.
```

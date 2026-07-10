<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $now = Carbon::now();

        // 1. Roles
        DB::table('roles')->insert([
            ['id_role' => 1, 'nama_role' => 'Admin', 'keterangan' => 'Administrator sistem', 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['id_role' => 2, 'nama_role' => 'Customer', 'keterangan' => 'Pelanggan aplikasi', 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['id_role' => 3, 'nama_role' => 'Penjual', 'keterangan' => 'Mitra / Dapur', 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['id_role' => 4, 'nama_role' => 'Driver', 'keterangan' => 'Kurir pengantar', 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
        ]);

        // 2. Users
        $password = Hash::make('password123'); // Gunakan password standar
        DB::table('users')->insert([
            ['id_user' => 1, 'nama_lengkap' => 'Admin JK', 'email' => 'admin@jk.id', 'username' => 'admin', 'password' => $password, 'id_role' => 1, 'no_hp' => '08111111111', 'poin' => 0, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['id_user' => 2, 'nama_lengkap' => 'Reyhan', 'email' => 'reyhan@gmail.com', 'username' => 'reyhan', 'password' => $password, 'id_role' => 2, 'no_hp' => '081234567890', 'poin' => 150, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['id_user' => 3, 'nama_lengkap' => 'Sarah', 'email' => 'sarah@gmail.com', 'username' => 'sarah', 'password' => $password, 'id_role' => 2, 'no_hp' => '081987654321', 'poin' => 50, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['id_user' => 4, 'nama_lengkap' => 'Dapur Pusat', 'email' => 'dapur@jk.id', 'username' => 'dapur', 'password' => $password, 'id_role' => 3, 'no_hp' => '08222222222', 'poin' => 0, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['id_user' => 5, 'nama_lengkap' => 'Ahmad Driver', 'email' => 'ahmad@jk.id', 'username' => 'driver', 'password' => $password, 'id_role' => 4, 'no_hp' => '08333333333', 'poin' => 0, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
        ]);

        // 3. Tipe Opsi Kustomisasi
        DB::table('tipe_opsi')->insert([
            ['id_tipe_opsi' => 1, 'nama_tipe' => 'Ukuran', 'wajib_pilih' => 1, 'pilih_banyak' => 0, 'created_at' => $now, 'updated_at' => $now],
            ['id_tipe_opsi' => 2, 'nama_tipe' => 'Gula', 'wajib_pilih' => 1, 'pilih_banyak' => 0, 'created_at' => $now, 'updated_at' => $now],
            ['id_tipe_opsi' => 3, 'nama_tipe' => 'Topping', 'wajib_pilih' => 0, 'pilih_banyak' => 1, 'created_at' => $now, 'updated_at' => $now],
        ]);

        // 4. Opsi Kustomisasi
        DB::table('opsi_kustomisasi')->insert([
            ['id_opsi' => 1, 'id_tipe_opsi' => 1, 'nama_opsi' => 'Regular (250ml)', 'harga_tambahan' => 0, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['id_opsi' => 2, 'id_tipe_opsi' => 1, 'nama_opsi' => 'Large (500ml)', 'harga_tambahan' => 7000, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['id_opsi' => 3, 'id_tipe_opsi' => 1, 'nama_opsi' => 'Large (1000ml)', 'harga_tambahan' => 10000, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['id_opsi' => 4, 'id_tipe_opsi' => 2, 'nama_opsi' => 'No Sugar', 'harga_tambahan' => 0, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['id_opsi' => 5, 'id_tipe_opsi' => 2, 'nama_opsi' => 'Less Sugar', 'harga_tambahan' => 0, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['id_opsi' => 6, 'id_tipe_opsi' => 2, 'nama_opsi' => 'Normal', 'harga_tambahan' => 0, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['id_opsi' => 7, 'id_tipe_opsi' => 2, 'nama_opsi' => 'Extra Sugar', 'harga_tambahan' => 1000, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['id_opsi' => 8, 'id_tipe_opsi' => 3, 'nama_opsi' => 'Chia Seed', 'harga_tambahan' => 2000, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['id_opsi' => 9, 'id_tipe_opsi' => 3, 'nama_opsi' => 'Madu', 'harga_tambahan' => 3000, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['id_opsi' => 10, 'id_tipe_opsi' => 3, 'nama_opsi' => 'Aloe Vera', 'harga_tambahan' => 2500, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
        ]);

        // 5. Kategori Artikel
        DB::table('kategori_artikel')->insert([
            ['id_kategori_artikel' => 1, 'nama_kategori' => 'Nutrisi', 'created_at' => $now, 'updated_at' => $now],
            ['id_kategori_artikel' => 2, 'nama_kategori' => 'Gaya Hidup', 'created_at' => $now, 'updated_at' => $now],
            ['id_kategori_artikel' => 3, 'nama_kategori' => 'Resep', 'created_at' => $now, 'updated_at' => $now],
            ['id_kategori_artikel' => 4, 'nama_kategori' => 'Promo', 'created_at' => $now, 'updated_at' => $now],
        ]);

        // 6. Artikel
        DB::table('artikel')->insert([
            ['id_artikel' => 1, 'id_kategori_artikel' => 1, 'id_penulis' => 1, 'judul' => '5 Manfaat Jus Alpukat untuk Kesehatan Kulit', 'slug' => '5-manfaat-jus-alpukat-untuk-kesehatan-kulit', 'ringkasan' => 'Alpukat kaya akan vitamin E dan lemak baik yang menutrisi kulit dari dalam.', 'konten' => 'Konten lengkap artikel mengenai manfaat jus alpukat...', 'id_status_artikel' => 1, 'dilihat' => 124, 'created_at' => $now, 'updated_at' => $now],
            ['id_artikel' => 2, 'id_kategori_artikel' => 3, 'id_penulis' => 1, 'judul' => 'Resep Smoothie Berry untuk Sarapan Sehat', 'slug' => 'resep-smoothie-berry-untuk-sarapan-sehat', 'ringkasan' => 'Mulai hari dengan smoothie berry yang segar dan bergizi.', 'konten' => 'Konten lengkap resep smoothie berry...', 'id_status_artikel' => 1, 'dilihat' => 89, 'created_at' => $now, 'updated_at' => $now],
            ['id_artikel' => 3, 'id_kategori_artikel' => 2, 'id_penulis' => 1, 'judul' => 'Kapan Waktu Terbaik Minum Jus Detox?', 'slug' => 'kapan-waktu-terbaik-minum-jus-detox', 'ringkasan' => 'Waktu konsumsi jus detox memengaruhi penyerapan nutrisinya.', 'konten' => 'Konten lengkap mengenai waktu terbaik minum jus detox...', 'id_status_artikel' => 2, 'dilihat' => 0, 'created_at' => $now, 'updated_at' => $now],
        ]);

        // 7. Konfigurasi Delivery
        DB::table('konfigurasi_delivery')->insert([
            ['id_konfigurasi' => 1, 'radius_maks_km' => 7.00, 'tarif_0_3km' => 5000, 'tarif_3_7km' => 7000, 'created_at' => $now, 'updated_at' => $now],
        ]);

        // 8. Slot Waktu
        DB::table('slot_waktu')->insert([
            // Slot Pick-up (per 30 menit)
            ['id_slot' => 1, 'id_tipe_pesanan' => 1, 'jam_mulai' => '10:00:00', 'jam_selesai' => null, 'kapasitas' => 5, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['id_slot' => 2, 'id_tipe_pesanan' => 1, 'jam_mulai' => '10:30:00', 'jam_selesai' => null, 'kapasitas' => 5, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['id_slot' => 3, 'id_tipe_pesanan' => 1, 'jam_mulai' => '11:00:00', 'jam_selesai' => null, 'kapasitas' => 5, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['id_slot' => 4, 'id_tipe_pesanan' => 1, 'jam_mulai' => '11:30:00', 'jam_selesai' => null, 'kapasitas' => 5, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['id_slot' => 5, 'id_tipe_pesanan' => 1, 'jam_mulai' => '12:00:00', 'jam_selesai' => null, 'kapasitas' => 5, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            // Slot Delivery (per 1 jam)
            ['id_slot' => 6, 'id_tipe_pesanan' => 2, 'jam_mulai' => '13:00:00', 'jam_selesai' => '14:00:00', 'kapasitas' => 10, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['id_slot' => 7, 'id_tipe_pesanan' => 2, 'jam_mulai' => '14:00:00', 'jam_selesai' => '15:00:00', 'kapasitas' => 10, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['id_slot' => 8, 'id_tipe_pesanan' => 2, 'jam_mulai' => '15:00:00', 'jam_selesai' => '16:00:00', 'kapasitas' => 10, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
        ]);
        
        // 9. Data Tambahan (Kategori Menu & Menu Jus) agar Katalog bisa berjalan
        DB::table('kategori_menu')->insert([
            ['id_kategori' => 1, 'nama_kategori' => 'Buah', 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['id_kategori' => 2, 'nama_kategori' => 'Sayur', 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['id_kategori' => 3, 'nama_kategori' => 'Kustom / Racik Sendiri', 'is_active' => 0, 'created_at' => $now, 'updated_at' => $now],
        ]);

        DB::table('menu_jus')->insert([
            ['id_menu' => 1, 'nama_jus' => 'Smoothie Berry', 'deskripsi' => 'Campuran berbagai macam buah berry.', 'id_kategori' => 1, 'harga' => 25000, 'foto' => null, 'estimasi_kalori' => 150, 'rating_rata' => 4.5, 'id_status_stok' => 1, 'stok' => 15, 'created_at' => $now, 'updated_at' => $now],
            ['id_menu' => 2, 'nama_jus' => 'Detox Green', 'deskripsi' => 'Sayuran hijau untuk detox pagi hari.', 'id_kategori' => 2, 'harga' => 30000, 'foto' => null, 'estimasi_kalori' => 120, 'rating_rata' => 4.8, 'id_status_stok' => 1, 'stok' => 20, 'created_at' => $now, 'updated_at' => $now],
            ['id_menu' => 3, 'nama_jus' => 'Racik Sendiri', 'deskripsi' => 'Kustomisasi jus sesuai selera kamu', 'id_kategori' => 3, 'harga' => 0, 'foto' => 'default_racik.png', 'estimasi_kalori' => null, 'rating_rata' => null, 'id_status_stok' => 1, 'stok' => 999, 'created_at' => $now, 'updated_at' => $now],
        ]);

        // 10. Alamat Tersimpan untuk Customer
        DB::table('alamat_tersimpan')->insert([
            ['id_alamat' => 1, 'id_customer' => 2, 'label' => 'Rumah', 'alamat_lengkap' => 'Jl. Merdeka No. 10, Kelurahan Cideng, Jakarta Pusat', 'latitude' => -6.186486, 'longitude' => 106.810600, 'is_utama' => 1, 'created_at' => $now, 'updated_at' => null],
            ['id_alamat' => 2, 'id_customer' => 2, 'label' => 'Kantor', 'alamat_lengkap' => 'Jl. Sudirman Kav. 52, Jakarta Selatan', 'latitude' => -6.226100, 'longitude' => 106.809400, 'is_utama' => 0, 'created_at' => $now, 'updated_at' => null],
            ['id_alamat' => 3, 'id_customer' => 3, 'label' => 'Rumah', 'alamat_lengkap' => 'Jl. Kebon Jeruk Raya No. 5, Jakarta Barat', 'latitude' => -6.188200, 'longitude' => 106.773900, 'is_utama' => 1, 'created_at' => $now, 'updated_at' => null],
        ]);

        // ====== REALISTIC ORDER DATA GENERATOR ======
        // Generates ~365 days of orders with realistic volumes:
        //   Daily: up to 5M   |  Weekly: up to 50M
        //   Monthly: up to 500M  |  Yearly: up to 5B
        // ==============================================
        $menuPrices = [1 => 25000, 2 => 30000, 3 => 0];
        $menuNames  = [1 => 'Smoothie Berry', 2 => 'Detox Green'];
        $customers  = [2, 3];
        $metodes    = ['Midtrans (Bank Transfer)', 'Midtrans (QRIS)', 'Midtrans (GoPay)', 'COD'];
        $alamatCustomer = [2 => [1, 2], 3 => [3]];
        $nowForSeed = Carbon::now();

        $pesananId = 0;
        $detailId  = 0;
        $nextPesananId = 1;
        $nextDetailId  = 1;

        // Clear existing data in reverse FK order
        DB::table('detail_pesanan_opsi')->truncate();
        DB::table('riwayat_status_pesanan')->truncate();
        DB::table('detail_pesanan')->truncate();
        DB::table('pesanan')->truncate();
        DB::table('notifikasi')->truncate();

        // Generate up to 365 days back
        $daysToGenerate = 365;
        // Base daily target: ~2M on slow days, up to ~5M on peak days
        // Weekends (Fri-Sun) get higher volume

        for ($dayOffset = $daysToGenerate; $dayOffset >= 0; $dayOffset--) {
            $orderDate = Carbon::now()->subDays($dayOffset);
            $dayOfWeek = $orderDate->dayOfWeek; // 0=Sun, 6=Sat

            // Skip future dates
            if ($orderDate->isFuture()) continue;

            // Weekend boost: Friday (5), Saturday (6), Sunday (0) get more orders
            $isWeekend = in_array($dayOfWeek, [0, 5, 6]);
            // Peak days: Saturday highest
            $peakMultiplier = $dayOfWeek == 6 ? 1.8 : ($isWeekend ? 1.4 : 1.0);

            // Generate between 8–40 orders per day (scaled by peak)
            $ordersToday = max(5, intval(round(18 * $peakMultiplier * (0.7 + mt_rand(0, 60) / 100))));
            // Add some randomness
            $ordersToday = max(3, $ordersToday + mt_rand(-3, 5));

            for ($o = 0; $o < $ordersToday; $o++) {
                $pesananId = $nextPesananId++;
                $customerId = $customers[array_rand($customers)];
                $tipePesanan = mt_rand(1, 10) > 7 ? 1 : 2; // ~70% delivery
                $menuId = mt_rand(1, 2);
                $qty = mt_rand(1, 4);
                $hargaSatuan = $menuPrices[$menuId] + (mt_rand(0, 3) > 1 ? mt_rand(0, 7000) : 0); // sometimes with add-ons
                $subtotal = $hargaSatuan * $qty;

                // Delivery fee
                $jarak = null;
                $ongkir = 0;
                $alamatId = null;
                $alamatSnapshot = null;
                if ($tipePesanan == 2) {
                    $alamats = $alamatCustomer[$customerId] ?? [1];
                    $alamatId = $alamats[array_rand($alamats)];
                    $alamatSnapshot = 'Alamat pengiriman customer';
                    $jarak = round(0.5 + mt_rand(0, 60) / 10, 1);
                    $ongkir = $jarak <= 3 ? 5000 : 5000 + ceil(($jarak - 3) / 0.5) * 1000;
                }

                $totalBayar = $subtotal + $ongkir;

                // Status distribution: 80% completed, 5% cancelled, 5% active, 10% other
                $randStatus = mt_rand(1, 100);
                if ($dayOffset <= 2 && $randStatus > 90) {
                    // Recent orders: more likely to be active
                    $status = $randStatus > 95 ? 1 : 2;
                } elseif ($dayOffset <= 7 && $randStatus > 85) {
                    $status = mt_rand(1, 2);
                } else {
                    if ($randStatus > 95) {
                        $status = 7; // cancelled
                    } elseif ($randStatus > 90) {
                        $status = 4; // in delivery
                    } else {
                        $status = 6; // completed
                    }
                }

                $metodeBayar = $metodes[array_rand($metodes)];
                $kodePesanan = 'JK-' . $orderDate->format('Ymd') . '-' . str_pad($pesananId, 4, '0', STR_PAD_LEFT);

                // Random hour between 07:00 and 21:00
                $hour = mt_rand(7, 20);
                $minute = mt_rand(0, 59);
                $createdAt = $orderDate->copy()->setTime($hour, $minute, mt_rand(0, 59));

                DB::table('pesanan')->insert([
                    'id_pesanan' => $pesananId,
                    'kode_pesanan' => $kodePesanan,
                    'id_customer' => $customerId,
                    'id_driver' => ($status >= 4 && $status <= 6 && $tipePesanan == 2) ? 5 : null,
                    'id_tipe_pesanan' => $tipePesanan,
                    'id_slot' => null,
                    'tanggal_pesan' => $orderDate->toDateString(),
                    'id_alamat' => $alamatId,
                    'alamat_snapshot' => $alamatSnapshot,
                    'jarak_km' => $jarak,
                    'subtotal' => $subtotal,
                    'ongkos_kirim' => $ongkir,
                    'total_bayar' => $totalBayar,
                    'id_status_pesanan' => $status,
                    'metode_pembayaran' => $metodeBayar,
                    'poin_digunakan' => 0,
                    'id_batch_driver' => null,
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]);

                // Detail Pesanan
                $detailId = $nextDetailId++;
                DB::table('detail_pesanan')->insert([
                    'id_detail' => $detailId,
                    'id_pesanan' => $pesananId,
                    'id_menu' => $menuId,
                    'nama_menu_snapshot' => $menuNames[$menuId],
                    'jumlah' => $qty,
                    'harga_satuan' => $hargaSatuan,
                    'subtotal' => $subtotal,
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]);

                // Riwayat Status
                DB::table('riwayat_status_pesanan')->insert([
                    'id_pesanan' => $pesananId,
                    'id_status_pesanan' => 1,
                    'diubah_oleh' => null,
                    'catatan' => 'Pesanan baru dibuat',
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]);

                if ($status == 7) {
                    DB::table('riwayat_status_pesanan')->insert([
                        'id_pesanan' => $pesananId, 'id_status_pesanan' => 7,
                        'diubah_oleh' => 1, 'catatan' => 'Pesanan dibatalkan',
                        'created_at' => $createdAt->copy()->addMinutes(15),
                        'updated_at' => $createdAt->copy()->addMinutes(15),
                    ]);
                } elseif ($status >= 2) {
                    DB::table('riwayat_status_pesanan')->insert([
                        'id_pesanan' => $pesananId, 'id_status_pesanan' => 2,
                        'diubah_oleh' => 4, 'catatan' => 'Pesanan diproses oleh dapur',
                        'created_at' => $createdAt->copy()->addMinutes(mt_rand(3, 12)),
                        'updated_at' => $createdAt->copy()->addMinutes(mt_rand(3, 12)),
                    ]);
                }
                if ($status >= 3) {
                    DB::table('riwayat_status_pesanan')->insert([
                        'id_pesanan' => $pesananId, 'id_status_pesanan' => 3,
                        'diubah_oleh' => 4, 'catatan' => 'Pesanan siap',
                        'created_at' => $createdAt->copy()->addMinutes(mt_rand(10, 25)),
                        'updated_at' => $createdAt->copy()->addMinutes(mt_rand(10, 25)),
                    ]);
                }
                if ($status >= 4 && $tipePesanan == 2) {
                    DB::table('riwayat_status_pesanan')->insert([
                        'id_pesanan' => $pesananId, 'id_status_pesanan' => 4,
                        'diubah_oleh' => 5, 'catatan' => 'Pesanan sedang diantar',
                        'created_at' => $createdAt->copy()->addMinutes(mt_rand(20, 35)),
                        'updated_at' => $createdAt->copy()->addMinutes(mt_rand(20, 35)),
                    ]);
                }
                if ($status >= 5 && $tipePesanan == 2) {
                    DB::table('riwayat_status_pesanan')->insert([
                        'id_pesanan' => $pesananId, 'id_status_pesanan' => 5,
                        'diubah_oleh' => 5, 'catatan' => 'Pesanan sudah sampai',
                        'created_at' => $createdAt->copy()->addMinutes(mt_rand(35, 55)),
                        'updated_at' => $createdAt->copy()->addMinutes(mt_rand(35, 55)),
                    ]);
                }
                if ($status == 6) {
                    DB::table('riwayat_status_pesanan')->insert([
                        'id_pesanan' => $pesananId, 'id_status_pesanan' => 6,
                        'diubah_oleh' => null, 'catatan' => 'Pesanan selesai',
                        'created_at' => $createdAt->copy()->addMinutes(mt_rand(40, 60)),
                        'updated_at' => $createdAt->copy()->addMinutes(mt_rand(40, 60)),
                    ]);
                }
            }
        }
        // 14. Seed Paket Langganan
        DB::table('paket_langganan')->insert([
            [
                'id_paket' => 1,
                'nama_paket' => 'Starter Pack',
                'harga' => 250000,
                'total_pengiriman' => 3,
                'deskripsi' => 'Cocok untuk pemula. 3 botol jus segar pilihan per minggu dengan gratis ongkir.',
                'gratis_ongkir' => true,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id_paket' => 2,
                'nama_paket' => 'Healthy Pack',
                'harga' => 450000,
                'total_pengiriman' => 6,
                'deskripsi' => 'Pilihan terbaik untuk kesehatan harian. 6 botol jus segar pilihan per minggu dengan gratis ongkir.',
                'gratis_ongkir' => true,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id_paket' => 3,
                'nama_paket' => 'Ultimate Pack',
                'harga' => 800000,
                'total_pengiriman' => 12,
                'deskripsi' => 'Keluarga sehat energi penuh. 12 botol jus segar pilihan per minggu dengan gratis ongkir.',
                'gratis_ongkir' => true,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        // Hubungkan paket dengan menu jus yang diperbolehkan (Smoothie Berry & Detox Green)
        DB::table('paket_langganan_menu')->insert([
            ['id_paket' => 1, 'id_menu' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['id_paket' => 1, 'id_menu' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['id_paket' => 2, 'id_menu' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['id_paket' => 2, 'id_menu' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['id_paket' => 3, 'id_menu' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['id_paket' => 3, 'id_menu' => 2, 'created_at' => $now, 'updated_at' => $now],
        ]);

        $this->call([ArtikelSeeder::class]);
        $this->call([RacikSendiriSeeder::class]);
    }
}

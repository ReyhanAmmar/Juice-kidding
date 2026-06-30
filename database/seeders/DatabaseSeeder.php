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
        ]);

        DB::table('menu_jus')->insert([
            ['id_menu' => 1, 'nama_jus' => 'Smoothie Berry', 'deskripsi' => 'Campuran berbagai macam buah berry.', 'id_kategori' => 1, 'harga' => 25000, 'foto' => null, 'estimasi_kalori' => 150, 'rating_rata' => 4.5, 'id_status_stok' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['id_menu' => 2, 'nama_jus' => 'Detox Green', 'deskripsi' => 'Sayuran hijau untuk detox pagi hari.', 'id_kategori' => 2, 'harga' => 30000, 'foto' => null, 'estimasi_kalori' => 120, 'rating_rata' => 4.8, 'id_status_stok' => 1, 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}

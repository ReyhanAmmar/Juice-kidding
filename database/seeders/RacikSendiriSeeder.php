<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RacikSendiriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Menambahkan tipe opsi dan opsi kustomisasi untuk fitur Racik Sendiri
     */
    public function run(): void
    {
        // Tambah Tipe Opsi Baru
        DB::table('tipe_opsi')->insert([
            ['id_tipe_opsi' => 4, 'nama_tipe' => 'Cairan Base', 'wajib_pilih' => 1, 'pilih_banyak' => 0, 'urutan' => 10],
            ['id_tipe_opsi' => 5, 'nama_tipe' => 'Bahan', 'wajib_pilih' => 1, 'pilih_banyak' => 1, 'urutan' => 20],
            ['id_tipe_opsi' => 7, 'nama_tipe' => 'Tambahan', 'wajib_pilih' => 0, 'pilih_banyak' => 1, 'urutan' => 30],
            ['id_tipe_opsi' => 8, 'nama_tipe' => 'Ukuran Cup', 'wajib_pilih' => 1, 'pilih_banyak' => 0, 'urutan' => 5],
        ]);

        // Tambah Pilihan Opsi Kustomisasi
        DB::table('opsi_kustomisasi')->insert([
            // Ukuran Cup (ID Tipe: 8)
            ['id_opsi' => 34, 'id_tipe_opsi' => 8, 'nama_opsi' => 'Regular (250ml)', 'harga_tambahan' => 0, 'is_active' => 1, 'urutan' => 1],
            ['id_opsi' => 35, 'id_tipe_opsi' => 8, 'nama_opsi' => 'Large (500ml)', 'harga_tambahan' => 5000, 'is_active' => 1, 'urutan' => 2],
            ['id_opsi' => 36, 'id_tipe_opsi' => 8, 'nama_opsi' => 'Jumbo (1000ml)', 'harga_tambahan' => 8000, 'is_active' => 1, 'urutan' => 3],

            // Cairan Base (ID Tipe: 4)
            ['id_opsi' => 15, 'id_tipe_opsi' => 4, 'nama_opsi' => 'Air Mineral', 'harga_tambahan' => 0, 'is_active' => 1, 'urutan' => 1],
            ['id_opsi' => 16, 'id_tipe_opsi' => 4, 'nama_opsi' => 'Air Kelapa Murni', 'harga_tambahan' => 4000, 'is_active' => 1, 'urutan' => 2],
            ['id_opsi' => 17, 'id_tipe_opsi' => 4, 'nama_opsi' => 'Susu Almond (Almond Milk)', 'harga_tambahan' => 6000, 'is_active' => 1, 'urutan' => 3],
            ['id_opsi' => 18, 'id_tipe_opsi' => 4, 'nama_opsi' => 'Susu Segar (Fresh Milk)', 'harga_tambahan' => 4000, 'is_active' => 1, 'urutan' => 4],
            ['id_opsi' => 19, 'id_tipe_opsi' => 4, 'nama_opsi' => 'Yoghurt Base', 'harga_tambahan' => 5000, 'is_active' => 1, 'urutan' => 5],

            // Bahan Buah & Sayur (ID Tipe: 5)
            ['id_opsi' => 20, 'id_tipe_opsi' => 5, 'nama_opsi' => 'Mangga Arumanis', 'harga_tambahan' => 3000, 'is_active' => 1, 'urutan' => 1],
            ['id_opsi' => 21, 'id_tipe_opsi' => 5, 'nama_opsi' => 'Alpukat Mentega', 'harga_tambahan' => 4000, 'is_active' => 1, 'urutan' => 2],
            ['id_opsi' => 22, 'id_tipe_opsi' => 5, 'nama_opsi' => 'Apel Fuji', 'harga_tambahan' => 3000, 'is_active' => 1, 'urutan' => 3],
            ['id_opsi' => 23, 'id_tipe_opsi' => 5, 'nama_opsi' => 'Stroberi Segar', 'harga_tambahan' => 4000, 'is_active' => 1, 'urutan' => 4],
            ['id_opsi' => 24, 'id_tipe_opsi' => 5, 'nama_opsi' => 'Pisang Cavendish', 'harga_tambahan' => 2000, 'is_active' => 1, 'urutan' => 5],
            ['id_opsi' => 25, 'id_tipe_opsi' => 5, 'nama_opsi' => 'Wortel Organik', 'harga_tambahan' => 2500, 'is_active' => 1, 'urutan' => 6],
            ['id_opsi' => 26, 'id_tipe_opsi' => 5, 'nama_opsi' => 'Sawi Hijau', 'harga_tambahan' => 2000, 'is_active' => 1, 'urutan' => 7],
            ['id_opsi' => 27, 'id_tipe_opsi' => 5, 'nama_opsi' => 'Tomat Ceri', 'harga_tambahan' => 2000, 'is_active' => 1, 'urutan' => 8],

            // Tambahan (ID Tipe: 7)
            ['id_opsi' => 28, 'id_tipe_opsi' => 7, 'nama_opsi' => 'Jahe Emprit', 'harga_tambahan' => 1500, 'is_active' => 1, 'urutan' => 1],
            ['id_opsi' => 29, 'id_tipe_opsi' => 7, 'nama_opsi' => 'Kunyit', 'harga_tambahan' => 1500, 'is_active' => 1, 'urutan' => 2],
            ['id_opsi' => 30, 'id_tipe_opsi' => 7, 'nama_opsi' => 'Kayu Manis', 'harga_tambahan' => 1500, 'is_active' => 1, 'urutan' => 3],
            ['id_opsi' => 31, 'id_tipe_opsi' => 7, 'nama_opsi' => 'Kurma Ajwa', 'harga_tambahan' => 3000, 'is_active' => 1, 'urutan' => 4],
            ['id_opsi' => 32, 'id_tipe_opsi' => 7, 'nama_opsi' => 'Extra Yoghurt Topping', 'harga_tambahan' => 3000, 'is_active' => 1, 'urutan' => 5],
            ['id_opsi' => 33, 'id_tipe_opsi' => 7, 'nama_opsi' => 'Perasan Lemon Murni', 'harga_tambahan' => 2000, 'is_active' => 1, 'urutan' => 6],
        ]);
    }
}
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1. Roles
        Schema::create('roles', function (Blueprint $table) {
            $table->id('id_role');
            $table->string('nama_role', 50);
            $table->string('keterangan')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 2. Users (Overrides default users table migration if any)
        Schema::dropIfExists('users');
        Schema::create('users', function (Blueprint $table) {
            $table->id('id_user');
            $table->string('nama_lengkap', 100);
            $table->string('email')->unique();
            $table->string('username', 50)->unique()->nullable();
            $table->string('password');
            $table->unsignedBigInteger('id_role');
            $table->string('no_hp', 20)->nullable();
            $table->string('foto_profil')->nullable();
            $table->integer('poin')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->foreign('id_role')->references('id_role')->on('roles')->onDelete('cascade');
        });

        // 3. Kategori Menu
        Schema::create('kategori_menu', function (Blueprint $table) {
            $table->id('id_kategori');
            $table->string('nama_kategori', 100);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 4. Menu Jus
        Schema::create('menu_jus', function (Blueprint $table) {
            $table->id('id_menu');
            $table->string('nama_jus', 100);
            $table->text('deskripsi')->nullable();
            $table->unsignedBigInteger('id_kategori');
            $table->integer('harga');
            $table->string('foto')->nullable();
            $table->integer('estimasi_kalori')->nullable();
            $table->decimal('rating_rata', 3, 1)->default(0.0);
            $table->integer('id_status_stok')->default(1); // 1 = Tersedia, 2 = Habis
            $table->timestamps();

            $table->foreign('id_kategori')->references('id_kategori')->on('kategori_menu')->onDelete('cascade');
        });

        // 5. Slot Waktu
        Schema::create('slot_waktu', function (Blueprint $table) {
            $table->id('id_slot');
            $table->integer('id_tipe_pesanan');
            $table->time('jam_mulai');
            $table->time('jam_selesai')->nullable();
            $table->integer('kapasitas')->default(10);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 6. Konfigurasi Delivery
        Schema::create('konfigurasi_delivery', function (Blueprint $table) {
            $table->id('id_konfigurasi');
            $table->decimal('radius_maks_km', 8, 2)->default(7.00);
            $table->integer('tarif_0_3km')->default(5000);
            $table->integer('tarif_3_7km')->default(7000);
            $table->timestamps();
        });

        // 7. Tipe Opsi
        Schema::create('tipe_opsi', function (Blueprint $table) {
            $table->id('id_tipe_opsi');
            $table->string('nama_tipe', 50); // e.g., 'Ukuran', 'Gula'
            $table->boolean('wajib_pilih')->default(false);
            $table->boolean('pilih_banyak')->default(false);
            $table->timestamps();
        });

        // 8. Opsi Kustomisasi
        Schema::create('opsi_kustomisasi', function (Blueprint $table) {
            $table->id('id_opsi');
            $table->unsignedBigInteger('id_tipe_opsi');
            $table->string('nama_opsi', 100);
            $table->integer('harga_tambahan')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('id_tipe_opsi')->references('id_tipe_opsi')->on('tipe_opsi')->onDelete('cascade');
        });

        // 9. Alamat Tersimpan
        Schema::create('alamat_tersimpan', function (Blueprint $table) {
            $table->id('id_alamat');
            $table->unsignedBigInteger('id_customer');
            $table->string('label', 50); // e.g., 'Rumah', 'Kantor'
            $table->text('alamat_lengkap');
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->boolean('is_utama')->default(false);
            $table->timestamps();

            $table->foreign('id_customer')->references('id_user')->on('users')->onDelete('cascade');
        });

        // 10. Pesanan
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id('id_pesanan');
            $table->string('kode_pesanan', 50)->unique();
            $table->unsignedBigInteger('id_customer');
            $table->unsignedBigInteger('id_driver')->nullable();
            $table->integer('id_tipe_pesanan'); // 1 = Pick-up, 2 = Delivery
            $table->unsignedBigInteger('id_slot')->nullable();
            $table->date('tanggal_pesan');
            $table->unsignedBigInteger('id_alamat')->nullable();
            $table->text('alamat_snapshot')->nullable(); // Snapshot of address in case it's deleted
            $table->decimal('jarak_km', 8, 2)->nullable();
            $table->integer('subtotal')->default(0);
            $table->integer('ongkos_kirim')->default(0);
            $table->integer('total_bayar');
            $table->integer('id_status_pesanan')->default(1); // 1 = Baru, 2 = Diproses, dll.
            $table->string('metode_pembayaran', 50);
            $table->unsignedBigInteger('id_batch_driver')->nullable();
            $table->timestamps();

            $table->foreign('id_customer')->references('id_user')->on('users')->onDelete('cascade');
            $table->foreign('id_driver')->references('id_user')->on('users')->onDelete('set null');
            $table->foreign('id_slot')->references('id_slot')->on('slot_waktu')->onDelete('set null');
            $table->foreign('id_alamat')->references('id_alamat')->on('alamat_tersimpan')->onDelete('set null');
        });

        // 11. Detail Pesanan
        Schema::create('detail_pesanan', function (Blueprint $table) {
            $table->id('id_detail');
            $table->unsignedBigInteger('id_pesanan');
            $table->unsignedBigInteger('id_menu');
            $table->string('nama_menu_snapshot', 100);
            $table->integer('jumlah');
            $table->integer('harga_satuan');
            $table->integer('subtotal');
            $table->timestamps();

            $table->foreign('id_pesanan')->references('id_pesanan')->on('pesanan')->onDelete('cascade');
            $table->foreign('id_menu')->references('id_menu')->on('menu_jus')->onDelete('cascade');
        });

        // 12. Detail Pesanan Opsi
        Schema::create('detail_pesanan_opsi', function (Blueprint $table) {
            $table->id('id_detail_opsi');
            $table->unsignedBigInteger('id_detail');
            $table->unsignedBigInteger('id_opsi');
            $table->string('nama_opsi_snapshot', 50);
            $table->integer('harga_tambahan_snapshot')->default(0);
            $table->timestamps();

            $table->foreign('id_detail')->references('id_detail')->on('detail_pesanan')->onDelete('cascade');
            $table->foreign('id_opsi')->references('id_opsi')->on('opsi_kustomisasi')->onDelete('cascade');
        });

        // 13. Riwayat Status Pesanan
        Schema::create('riwayat_status_pesanan', function (Blueprint $table) {
            $table->id('id_riwayat');
            $table->unsignedBigInteger('id_pesanan');
            $table->integer('id_status_pesanan');
            $table->unsignedBigInteger('diubah_oleh')->nullable(); // Yang mengubah status
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->foreign('id_pesanan')->references('id_pesanan')->on('pesanan')->onDelete('cascade');
            $table->foreign('diubah_oleh')->references('id_user')->on('users')->onDelete('set null');
        });

        // 14. Kategori Artikel
        Schema::create('kategori_artikel', function (Blueprint $table) {
            $table->id('id_kategori_artikel');
            $table->string('nama_kategori', 50);
            $table->timestamps();
        });

        // 15. Artikel
        Schema::create('artikel', function (Blueprint $table) {
            $table->id('id_artikel');
            $table->unsignedBigInteger('id_kategori_artikel');
            $table->unsignedBigInteger('id_penulis');
            $table->string('judul', 150);
            $table->string('slug', 170)->unique();
            $table->string('thumbnail')->nullable();
            $table->string('ringkasan')->nullable();
            $table->longText('konten');
            $table->integer('id_status_artikel')->default(2); // 1 = Published, 2 = Draft
            $table->integer('dilihat')->default(0);
            $table->timestamps();

            $table->foreign('id_kategori_artikel')->references('id_kategori_artikel')->on('kategori_artikel')->onDelete('cascade');
            $table->foreign('id_penulis')->references('id_user')->on('users')->onDelete('cascade');
        });

        // 16. Ulasan
        Schema::create('ulasan', function (Blueprint $table) {
            $table->id('id_ulasan');
            $table->unsignedBigInteger('id_menu');
            $table->unsignedBigInteger('id_customer');
            $table->unsignedBigInteger('id_pesanan')->nullable();
            $table->boolean('rating');
            $table->text('komentar')->nullable();
            $table->timestamps();

            $table->foreign('id_pesanan')->references('id_pesanan')->on('pesanan')->onDelete('set null');
            $table->foreign('id_menu')->references('id_menu')->on('menu_jus')->onDelete('cascade');
            $table->foreign('id_customer')->references('id_user')->on('users')->onDelete('cascade');
        });

        // 17. Keranjang
        Schema::create('keranjang', function (Blueprint $table) {
            $table->id('id_keranjang');
            $table->unsignedBigInteger('id_customer');
            $table->unsignedBigInteger('id_menu');
            $table->integer('jumlah')->default(1);
            $table->integer('subtotal')->default(0);
            $table->timestamps();

            $table->foreign('id_customer')->references('id_user')->on('users')->onDelete('cascade');
            $table->foreign('id_menu')->references('id_menu')->on('menu_jus')->onDelete('cascade');
        });

        // 18. Keranjang Opsi
        Schema::create('keranjang_opsi', function (Blueprint $table) {
            $table->id('id_keranjang_opsi');
            $table->unsignedBigInteger('id_keranjang');
            $table->unsignedBigInteger('id_opsi');
            $table->timestamps();

            $table->foreign('id_keranjang')->references('id_keranjang')->on('keranjang')->onDelete('cascade');
            $table->foreign('id_opsi')->references('id_opsi')->on('opsi_kustomisasi')->onDelete('cascade');
        });

        // 19. Notifikasi
        Schema::create('notifikasi', function (Blueprint $table) {
            $table->id('id_notifikasi');
            $table->unsignedBigInteger('id_user');
            $table->string('judul', 150);
            $table->text('pesan')->nullable();
            $table->string('tipe', 30)->nullable();
            $table->unsignedBigInteger('id_pesanan')->nullable();
            $table->boolean('sudah_dibaca')->default(false);
            $table->timestamps();

            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
            $table->foreign('id_pesanan')->references('id_pesanan')->on('pesanan')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('notifikasi');
        Schema::dropIfExists('keranjang_opsi');
        Schema::dropIfExists('keranjang');
        Schema::dropIfExists('ulasan');
        Schema::dropIfExists('artikel');
        Schema::dropIfExists('kategori_artikel');
        Schema::dropIfExists('riwayat_status_pesanan');
        Schema::dropIfExists('detail_pesanan_opsi');
        Schema::dropIfExists('detail_pesanan');
        Schema::dropIfExists('pesanan');
        Schema::dropIfExists('alamat_tersimpan');
        Schema::dropIfExists('opsi_kustomisasi');
        Schema::dropIfExists('tipe_opsi');
        Schema::dropIfExists('konfigurasi_delivery');
        Schema::dropIfExists('slot_waktu');
        Schema::dropIfExists('menu_jus');
        Schema::dropIfExists('kategori_menu');
        Schema::dropIfExists('users');
        Schema::dropIfExists('roles');
    }
};

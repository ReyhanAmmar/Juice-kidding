<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Tabel Paket Langganan
        Schema::create('paket_langganan', function (Blueprint $table) {
            $table->id('id_paket');
            $table->string('nama_paket', 50);
            $table->integer('harga');
            $table->integer('total_pengiriman');
            $table->text('deskripsi')->nullable();
            $table->boolean('gratis_ongkir')->default(true);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 2. Tabel Pivot Paket Menu
        Schema::create('paket_langganan_menu', function (Blueprint $table) {
            $table->id('id_paket_menu');
            $table->unsignedBigInteger('id_paket');
            $table->unsignedBigInteger('id_menu');
            $table->timestamps();

            $table->foreign('id_paket')->references('id_paket')->on('paket_langganan')->onDelete('cascade');
            $table->foreign('id_menu')->references('id_menu')->on('menu_jus')->onDelete('cascade');
        });

        // 3. Tabel Langganan Aktif milik Customer
        Schema::create('langganan_aktif', function (Blueprint $table) {
            $table->id('id_langganan');
            $table->unsignedBigInteger('id_customer');
            $table->unsignedBigInteger('id_paket');
            $table->unsignedBigInteger('id_alamat');
            $table->text('hari_pengiriman'); // Simpan JSON array nama-nama hari
            $table->unsignedBigInteger('id_menu_default')->nullable(); // Menu default pilihan customer
            $table->integer('sisa_pengiriman');
            $table->string('status_pembayaran', 30)->default('Menunggu'); // Menunggu, Lunas, Batal
            $table->boolean('is_active')->default(false);
            $table->timestamps();

            $table->foreign('id_customer')->references('id_user')->on('users')->onDelete('cascade');
            $table->foreign('id_paket')->references('id_paket')->on('paket_langganan')->onDelete('cascade');
            $table->foreign('id_alamat')->references('id_alamat')->on('alamat_tersimpan')->onDelete('cascade');
            $table->foreign('id_menu_default')->references('id_menu')->on('menu_jus')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('langganan_aktif');
        Schema::dropIfExists('paket_langganan_menu');
        Schema::dropIfExists('paket_langganan');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Menambahkan kolom 'urutan' untuk mengatur posisi tampilan tipe opsi dan opsi kustomisasi
     */
    public function up(): void
    {
        Schema::table('tipe_opsi', function (Blueprint $table) {
            $table->integer('urutan')->default(0)->after('pilih_banyak');
        });

        Schema::table('opsi_kustomisasi', function (Blueprint $table) {
            $table->integer('urutan')->default(0)->after('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tipe_opsi', function (Blueprint $table) {
            $table->dropColumn('urutan');
        });

        Schema::table('opsi_kustomisasi', function (Blueprint $table) {
            $table->dropColumn('urutan');
        });
    }
};
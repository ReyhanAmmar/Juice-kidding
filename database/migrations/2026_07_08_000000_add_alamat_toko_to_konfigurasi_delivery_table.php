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
        Schema::table('konfigurasi_delivery', function (Blueprint $table) {
            $table->text('alamat_toko')->nullable()->after('id_konfigurasi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('konfigurasi_delivery', function (Blueprint $table) {
            $table->dropColumn('alamat_toko');
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alamat_toko', function (Blueprint $table) {
            $table->id('id_alamat_toko');
            $table->string('label', 100)->default('Pusat');
            $table->text('alamat_lengkap');
            $table->string('latitude', 20);
            $table->string('longitude', 20);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alamat_toko');
    }
};
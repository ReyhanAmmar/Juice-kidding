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
        Schema::table('menu_jus', function (Blueprint $table) {
            $table->integer('stok')->default(10)->after('id_status_stok');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('menu_jus', function (Blueprint $table) {
            $table->dropColumn('stok');
        });
    }
};

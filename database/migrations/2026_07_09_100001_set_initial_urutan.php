<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Mengisi urutan berurutan untuk data existing berdasarkan ID
     */
    public function up(): void
    {
        // Set urutan tipe_opsi berdasarkan id_tipe_opsi
        $tipeOpsi = DB::table('tipe_opsi')->orderBy('id_tipe_opsi')->get();
        foreach ($tipeOpsi as $i => $item) {
            DB::table('tipe_opsi')
                ->where('id_tipe_opsi', $item->id_tipe_opsi)
                ->update(['urutan' => $i + 1]);
        }

        // Set urutan opsi_kustomisasi berdasarkan id_opsi
        $opsiKustomisasi = DB::table('opsi_kustomisasi')->orderBy('id_opsi')->get();
        foreach ($opsiKustomisasi as $i => $item) {
            DB::table('opsi_kustomisasi')
                ->where('id_opsi', $item->id_opsi)
                ->update(['urutan' => $i + 1]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Kembalikan ke 0
        DB::table('tipe_opsi')->update(['urutan' => 0]);
        DB::table('opsi_kustomisasi')->update(['urutan' => 0]);
    }
};
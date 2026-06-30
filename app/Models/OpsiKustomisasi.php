<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OpsiKustomisasi extends Model
{
    protected $table = 'opsi_kustomisasi';
    protected $primaryKey = 'id_opsi';
    public $timestamps = false;

    protected $fillable = [
        'id_tipe_opsi', 'nama_opsi', 'harga_tambahan', 'is_active'
    ];

    public function tipe_opsi()
    {
        return $this->belongsTo(TipeOpsi::class, 'id_tipe_opsi', 'id_tipe_opsi');
    }
}

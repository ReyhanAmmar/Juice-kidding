<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPesananOpsi extends Model
{
    protected $table = 'detail_pesanan_opsi';
    protected $primaryKey = 'id_detail_opsi';
    public $timestamps = false;

    protected $fillable = [
        'id_detail', 'id_opsi', 'nama_opsi_snapshot', 'harga_tambahan_snapshot'
    ];

    public function detail_pesanan()
    {
        return $this->belongsTo(DetailPesanan::class, 'id_detail', 'id_detail');
    }

    public function opsi()
    {
        return $this->belongsTo(OpsiKustomisasi::class, 'id_opsi', 'id_opsi');
    }
}

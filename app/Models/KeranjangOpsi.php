<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KeranjangOpsi extends Model
{
    protected $table = 'keranjang_opsi';
    protected $primaryKey = 'id_keranjang_opsi';
    public $timestamps = false;

    protected $fillable = [
        'id_keranjang', 'id_opsi'
    ];

    public function keranjang()
    {
        return $this->belongsTo(Keranjang::class, 'id_keranjang', 'id_keranjang');
    }

    public function opsi()
    {
        return $this->belongsTo(OpsiKustomisasi::class, 'id_opsi', 'id_opsi');
    }
}

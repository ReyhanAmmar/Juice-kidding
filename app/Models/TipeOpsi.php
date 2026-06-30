<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipeOpsi extends Model
{
    protected $table = 'tipe_opsi';
    protected $primaryKey = 'id_tipe_opsi';
    public $timestamps = false;

    protected $fillable = [
        'nama_tipe', 'wajib_pilih', 'pilih_banyak'
    ];

    public function opsi()
    {
        return $this->hasMany(OpsiKustomisasi::class, 'id_tipe_opsi', 'id_tipe_opsi');
    }
}

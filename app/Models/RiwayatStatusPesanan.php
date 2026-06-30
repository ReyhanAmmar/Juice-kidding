<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatStatusPesanan extends Model
{
    protected $table = 'riwayat_status_pesanan';
    protected $primaryKey = 'id_riwayat';
    const UPDATED_AT = null;

    protected $fillable = [
        'id_pesanan', 'id_status_pesanan', 'catatan', 'diubah_oleh'
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan', 'id_pesanan');
    }

    public function pengubah()
    {
        return $this->belongsTo(User::class, 'diubah_oleh', 'id_user');
    }
}

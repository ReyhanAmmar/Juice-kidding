<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KonfigurasiDelivery extends Model
{
    protected $table = 'konfigurasi_delivery';
    protected $primaryKey = 'id_konfigurasi';
    const CREATED_AT = null;

    protected $fillable = [
        'radius_maks_km', 'tarif_0_3km', 'tarif_3_7km', 'latitude_toko', 'longitude_toko', 'alamat_toko'
    ];
}

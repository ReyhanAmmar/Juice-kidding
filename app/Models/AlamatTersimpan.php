<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlamatTersimpan extends Model
{
    protected $table = 'alamat_tersimpan';
    protected $primaryKey = 'id_alamat';

    const UPDATED_AT = null;

    protected $fillable = [
        'id_customer', 'label', 'alamat_lengkap', 'latitude', 'longitude', 'is_utama'
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'id_customer', 'id_user');
    }
}

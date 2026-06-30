<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    protected $table = 'keranjang';
    protected $primaryKey = 'id_keranjang';

    const UPDATED_AT = null;

    protected $fillable = [
        'id_customer', 'id_menu', 'jumlah', 'subtotal'
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'id_customer', 'id_user');
    }

    public function menu()
    {
        return $this->belongsTo(MenuJus::class, 'id_menu', 'id_menu');
    }

    public function opsi()
    {
        return $this->hasMany(KeranjangOpsi::class, 'id_keranjang', 'id_keranjang');
    }
}
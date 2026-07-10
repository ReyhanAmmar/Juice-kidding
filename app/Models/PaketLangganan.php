<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaketLangganan extends Model
{
    protected $table = 'paket_langganan';
    protected $primaryKey = 'id_paket';

    protected $fillable = [
        'nama_paket',
        'harga',
        'total_pengiriman',
        'deskripsi',
        'gratis_ongkir',
        'is_active',
    ];

    protected $casts = [
        'gratis_ongkir' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function menus()
    {
        return $this->belongsToMany(MenuJus::class, 'paket_langganan_menu', 'id_paket', 'id_menu');
    }
}

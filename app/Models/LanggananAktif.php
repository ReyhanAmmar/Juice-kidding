<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LanggananAktif extends Model
{
    protected $table = 'langganan_aktif';
    protected $primaryKey = 'id_langganan';

    protected $fillable = [
        'id_customer',
        'id_paket',
        'id_alamat',
        'hari_pengiriman',
        'id_menu_default',
        'sisa_pengiriman',
        'status_pembayaran',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'id_customer', 'id_user');
    }

    public function paket()
    {
        return $this->belongsTo(PaketLangganan::class, 'id_paket', 'id_paket');
    }

    public function alamat()
    {
        return $this->belongsTo(AlamatTersimpan::class, 'id_alamat', 'id_alamat');
    }

    public function menu_default()
    {
        return $this->belongsTo(MenuJus::class, 'id_menu_default', 'id_menu');
    }
}

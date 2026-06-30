<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $table = 'pesanan';
    protected $primaryKey = 'id_pesanan';

    protected $fillable = [
        'kode_pesanan', 'id_customer', 'id_driver', 'id_tipe_pesanan', 'id_slot', 'tanggal_pesan', 
        'id_alamat', 'alamat_snapshot', 'jarak_km', 'subtotal', 'ongkos_kirim', 'total_bayar', 
        'id_status_pesanan', 'metode_pembayaran', 'id_batch_driver'
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'id_customer', 'id_user');
    }

    public function driver()
    {
        return $this->belongsTo(User::class, 'id_driver', 'id_user');
    }

    public function slot_waktu()
    {
        return $this->belongsTo(SlotWaktu::class, 'id_slot', 'id_slot');
    }

    public function alamat()
    {
        return $this->belongsTo(AlamatTersimpan::class, 'id_alamat', 'id_alamat');
    }

    public function detail_pesanan()
    {
        return $this->hasMany(DetailPesanan::class, 'id_pesanan', 'id_pesanan');
    }

    public function riwayat_status()
    {
        return $this->hasMany(RiwayatStatusPesanan::class, 'id_pesanan', 'id_pesanan');
    }

    public function ulasan()
    {
        return $this->hasMany(Ulasan::class, 'id_pesanan', 'id_pesanan');
    }

    public function notifikasi()
    {
        return $this->hasMany(Notifikasi::class, 'id_pesanan', 'id_pesanan');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SlotWaktu extends Model
{
    protected $table = 'slot_waktu';
    protected $primaryKey = 'id_slot';
    public $timestamps = false;

    protected $fillable = [
        'id_tipe_pesanan', 'jam_mulai', 'jam_selesai', 'kapasitas', 'is_active'
    ];
}

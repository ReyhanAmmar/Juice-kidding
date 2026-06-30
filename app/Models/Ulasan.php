<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ulasan extends Model
{
    protected $table = 'ulasan';
    protected $primaryKey = 'id_ulasan';
    const UPDATED_AT = null;

    protected $fillable = [
        'id_menu', 'id_customer', 'id_pesanan', 'rating', 'komentar'
    ];

    public function menu()
    {
        return $this->belongsTo(MenuJus::class, 'id_menu', 'id_menu');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'id_customer', 'id_user');
    }

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan', 'id_pesanan');
    }
}

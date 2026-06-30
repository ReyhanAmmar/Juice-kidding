<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuJus extends Model
{
    protected $table = 'menu_jus';
    protected $primaryKey = 'id_menu';

    protected $fillable = [
        'nama_jus', 'deskripsi', 'id_kategori', 'harga', 'foto', 'estimasi_kalori', 'rating_rata', 'id_status_stok'
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriMenu::class, 'id_kategori', 'id_kategori');
    }

    public function ulasan()
    {
        return $this->hasMany(Ulasan::class, 'id_menu', 'id_menu');
    }
}
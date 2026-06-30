<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Artikel extends Model
{
    protected $table = 'artikel';
    protected $primaryKey = 'id_artikel';

    protected $fillable = [
        'id_kategori_artikel', 'id_penulis', 'judul', 'slug', 'thumbnail', 'ringkasan', 'konten', 'id_status_artikel', 'dilihat'
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriArtikel::class, 'id_kategori_artikel', 'id_kategori_artikel');
    }

    public function penulis()
    {
        return $this->belongsTo(User::class, 'id_penulis', 'id_user');
    }
}

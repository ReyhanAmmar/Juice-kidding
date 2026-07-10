<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriMenu extends Model
{
    protected $table = 'kategori_menu';
    protected $primaryKey = 'id_kategori';
    
    public $timestamps = false; 

    protected $fillable = ['id_kategori', 'nama_kategori', 'is_active'];
}
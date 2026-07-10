<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlamatToko extends Model
{
    protected $table = 'alamat_toko';
    protected $primaryKey = 'id_alamat_toko';

    protected $fillable = [
        'label', 'alamat_lengkap', 'latitude', 'longitude', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'latitude' => 'float',
        'longitude' => 'float',
    ];
}
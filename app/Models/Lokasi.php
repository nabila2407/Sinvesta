<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lokasi extends Model
{
    // daftarkan kolom-kolom ysng bisa dikelola
    protected $fillable = [
        'kode_lokasi',
        'nama_lokasi',
        'deskripsi',
    ];

    // mengubah route key name menjadi kode_lokasi
    public function getRouteKeyName()
    {
        return 'kode_lokasi';
    }
}

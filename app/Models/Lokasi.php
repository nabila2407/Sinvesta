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

    // relasi antara lokasi dan barang
    public function barangs()
    {
        return $this->hasMany(Barang::class, 'lokasi_id');
    }
}

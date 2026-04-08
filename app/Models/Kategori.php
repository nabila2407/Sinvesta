<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    // daftarkan kolom apa saja yang dapat dikelola datanya
    protected $fillable = [
        'kode_kategori',
        'nama_kategori',
        'deskripsi',
    ];

    // ubah route key name dari id menjadi kode_kategori
    public function getRouteKeyName()
    {
        return 'kode_kategori';
    }

    // relasi antara kategori dan barang
    public function barangs()
    {
        return $this->hasMany(Barang::class, 'kategori_id');
    }
}

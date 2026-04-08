<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'kategori_id',
        'lokasi_id',
        'status_barang',
        'deskripsi',
    ];

    // ubah route key dari id menjadi kode barang
    public function getRouteKeyName()
    {
        return 'kode_barang';
    }
    
    // relasi antara barang dan kategori 
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    // relasi antara barang dan lokasi 
    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'lokasi_id');
    }

    // relasi antara barang dan bast 
    public function basts()
    {
        return $this->hasMany(Barang::class, 'barang_id');
    }
}

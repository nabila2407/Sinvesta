<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bast extends Model
{
    protected $fillable = [
        'barang_id',
        'user_serah_id',
        'user_terima_id',
        'status_serah',
        'status_terima',
        'file_export', 
    ];

    // relasi antara bast dan barang 
    public function kategori()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }

    // relasi antara bast dan user 
    public function userSerah()
    {
        return $this->belongsTo(User::class, 'user_serah_id');
    }

    // relasi antara bast dan user yang menerima
    public function userTerima()
    {
        return $this->belongsTo(User::class, 'user_terima_id');
    }
}

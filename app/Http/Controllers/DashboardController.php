<?php

namespace App\Http\Controllers;

// ! panggil semua model agar bisa digunakan di function index()
use App\Models\Barang;
use App\Models\Bast;
use App\Models\Kategori;
use App\Models\Lokasi;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * ? function index akan menjalankan view 'index.blade.php' di dalam folder 'dashboard'
     * ? lalu mengirimkan data-data yang akan ditampilkan di halaman
     */
    public function index()
    {
        // hitung jumlah data di tabel kategori
        $jumlah_kategori = Kategori::count();

        // hitung jumlah data di tabel lokasi
        $jumlah_lokasi = Lokasi::count();

        // hitung jumlah data di tabel barang
        $jumlah_barang = Barang::count();

        // hitung jumlah data di tabel bast
        $jumlah_bast = Bast::count();

        return view('dashboard.index', [
            'title' => 'Dashboard Sinvesta',
            'jumlah_kategori' => $jumlah_kategori,
            'jumlah_lokasi' => $jumlah_lokasi,
            'jumlah_barang' => $jumlah_barang,
            'jumlah_bast' => $jumlah_bast,

        ]);
    }
}

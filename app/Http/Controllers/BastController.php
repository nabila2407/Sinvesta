<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Bast;
use App\Models\Kategori;
use App\Models\Lokasi;
use App\Models\User;
use Illuminate\Http\Request;

class BastController extends Controller
{
    /**
     * ? menampilkan halaman list berita acara sesuai dengan filter data yang dipilih
     */
    public function index(Request $request)
    {
        // ? hanya admin yang bisa melihat semua data bast
        $this->authorize('viewAny', Bast::class);

        // ? query inti untuk mengambil data bast dari database,
        // ? dengan relasi ke tabel barang, user_serah, user_terima
        $query = Bast::with([
            'barang.kategori',
            'barang.lokasi',
            'userSerah',
            'userTerima',
        ]);

        // ? jika ada filter kategori data yang dipilih, tambahkan kondisi ke query tersebut
        if ($request->filled('kategori')) {
            $query->whereHas('barang', fn ($q) => $q->where('kategori_id', $request->kategori));
        }

        // ? jika ada filter lokasi data yang dipilih, tambahkan kondisi ke query tersebut
        if ($request->filled('lokasi')) {
            $query->whereHas('barang', fn ($q) => $q->where('lokasi_id', $request->lokasi));
        }

        // ? jika ada filter status barang data yang dipilih, tambahkan kondisi ke query tersebut
        if ($request->filled('status_barang')) {
            $query->whereHas('barang', fn ($q) => $q->where('status_barang', $request->status_barang));
        }

        // ? jika ada filter status bast data yang dipilih, tambahkan kondisi ke query tersebut
        if ($request->filled('status_bast')) {
            match ($request->status_bast) {
                'Disetujui' => $query
                    ->where('status_serah', 'Disetujui')
                    ->where('status_terima', 'Disetujui'),

                'Menunggu' => $query->where(fn ($q) => $q->where('status_serah', 'Menunggu')
                    ->orWhere('status_terima', 'Menunggu')
                ),
            };
        }

        // ? ambil data bast sesuai dengan filter yang dipilih, dan urutkan dari yang paling baru
        $basts = $query->latest()->get();

        // ? tampilkan view index.blade.php di folder dashboard/bast, lalu kirimkan data :
        return view('dashboard.bast.index', [
            'title' => 'Daftar Berita Acara Serah Terima', // judul halaman
            'basts' => $basts, // data bast yang diambil dari database
            'kategoris' => Kategori::latest()->get(), // semua data kategori yang ada di database
            'lokasis' => Lokasi::latest()->get(), // semua data lokasi yang ada di database
        ]);
    
    }

    /**
     * ? menampilkan form buat berita acara baru
     */
    public function create()
    {
        // ? hanya admin yang bisa membuka form tambah bast
        $this->authorize('create', Bast::class);

        // ? tampilkan view create.blade.php di folder dashboard/bast, lalu kirimkan data :
        return view('dashboard.bast.create', [
            'title' => 'Buat Berita Acara Serah Terima Baru', // judul halaman
            'users' => User::latest()->select('id', 'nama_lengkap')->get(), // semua data user yang ada di database
            'barangs' => Barang::latest()->select('id', 'kode_barang', 'nama_barang')->get(), // semua data barang yang ada di database
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Bast $bast)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bast $bast)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bast $bast)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bast $bast)
    {
        //
    }
}

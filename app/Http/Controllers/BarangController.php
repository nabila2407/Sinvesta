<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Lokasi;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    /**
     * ? tampilkan semua list barang, karena di soal minta fitur filter, kita tambahkan query untuk filter data
     */
    public function index(Request $request)
    {
        // ? hanya admin yang boleh melihat semua data barang
        $this->authorize('viewAny', Barang::class);

        // ? query untuk mengambil data barang dari database
        $barangs = Barang::query()
            ->with(['kategori', 'lokasi']) // ? sekalian ambil data kategori dan lokasi
            ->when($request->kategori, function ($query, $kategori) { // ? jika ada filter berdasarkan kategori
                $query->where('kategori_id', $kategori); // ? ambil data barang berdasarkan kategori yang dipilih
            })->when($request->lokasi, function ($query, $lokasi) { // ? jika ada filter berdasarkan lokasi
                $query->where('lokasi_id', $lokasi); // ? ambil data barang berdasarkan lokasi yang dipilih
            })->when($request->status, function ($query, $status) { // ? jika ada filter berdasarkan status barang
                $query->where('status_barang', $status); // ? ambil data barang berdasarkan status yang dipilih
            })->latest()->get(); // ? urutkan dari yang terbaru

        // ? tampilkan view index.blade.php di folder dashbiard/barang
        return view('dashboard.barang.index', [
            'title' => 'Daftar Barang', // ? sambil kirim judul halaman
            'barang' => $barangs, // ? kirim data barang
            'kategoris' => Kategori::latest()->get(), // ? kirim semua data kategori (untuk fitur filter)
            'lokasis' => Lokasi::latest()->get(), // ? kirim semua data lokasi (untuk fitur filter)
        ]);
    }

    /**
     * ? tampilkan halaman form tambah barang
     */
    public function create()
    {
        // ? hanya admin yang boleh membuka halaman form tambah barang baru
        $this->authorize('create', Barang::class);

        // ? tampilkan view create.blade.php di folder dashboard/barang
        return view('dashboard.barang.create', [
            'title' => 'Tambah Barang', // kirim judul halaman
            'kategoris' => Kategori::latest()->get(), // ? kirim semua data kategori
            'lokasis' => Lokasi::latest()->get(), // ? kirim semua data lokasi
        ]);
    }

    /**
     * ? simpan data barang baru ke database
     */
    public function store(Request $request)
    {
        // ? 1. buat aturan untuk proses validasi data
        $aturan = [
            'kode_barang' => 'required|string|max:20|unique:barangs,kode_barang',
            'nama_barang' => 'required|string|max:100',
            'kategori_id' => 'required|exists:kategoris,id',
            'lokasi_id'   => 'required|exists:lokasis,id',
            'status_barang' => 'required|in:Baik,Rusak Ringan,Rusak Berat,Hilang',
            'deskripsi'   => 'nullable|string',
        ];

        // ? 2. buat pesan untuk kolom yang tidak valid
        $pesan = [
            'required' => 'Kolom :attribute nggak boleh kosong ya!.',
            'unique'   => 'Kolom :attribute udah ada yang pakai.',
            'max'      => 'Kolom :attribute maksimal :max karakter.',
            'exists'   => 'Kolom :attribute tidak valid.',
            'in'       => 'Kolom :attribute tidak valid.',
            'string'   => 'Kolom :attribute harus berupa teks ya!.',
        ];

        // ? 3. lakukan validasi data
        $validatedData = $request->validate($aturan, $pesan);

        // ? 4. simpan data ke database
        Barang::create($validatedData);

        // ? 5. alihkan ke halaman list data barang dan kirimkan pesan konfirmasi berhasil
        return redirect()->route('barang.index')->with('berhasil', 'Teaay! Barang berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Barang $barang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Barang $barang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Barang $barang)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Barang $barang)
    {
        //
    }
}

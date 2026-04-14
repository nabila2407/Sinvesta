<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

// ! panggil class facade PDF agar bisa digunakan di function exportToPdf()
use Barryvdh\DomPDF\Facade\Pdf;

// ! panggil class kategori export dan facade excel agar bisa digunakan di function exportToExcel()
use App\Exports\KategoriExport;
use Maatwebsite\Excel\Facades\Excel;

class KategoriController extends Controller
{
    /**
     * ? tampilkan semua data kategori barang di view index
     */
    public function index()
    {
        // ? jalankan view index.blade.php di file dashboard/kategori, lalu kirimkan data :
        return view('dashboard.kategori.index', [
            'title' => 'Daftar Kategori Barang', // judul halaman
            'kategoris' => Kategori::latest()->get(), // semua data kategori barang yang ada didatabase
        ]);
    }

    /**
     * ? tampilkan halaman form tambah kategori baru
     */
    public function create()
    {
        // ? jalankan view create.blade.php di folder dashboard/kategori, lalu kirimkan data :
        return view('dashboard.kategori.create', [
            'title' => 'Tambah Kategori Barang', // judul halaman
        ]);
    }

    /**
     * ? simpan data kategori baru ke database
     */
    public function store(Request $request)
    {
        //? 1. membuat aturan validasi data
        $aturan = [
            // kode kategori wajib diisi, maks 20 karakter, harus unik
            'kode_kategori' => 'required|string|max:20|unique:kategoris,kode_kategori',
            // nama kategori wajib diisi, maks 100 karakter
            'nama_kategori' => 'required|string|max:100',
            // deskripsi harus berupa teks, boleh dikosongkan
            'deskripsi' => 'nullable|string',
        ];

        //? 2. membuat pesan validasi custom
        $pesan = [
            'required' => 'Kolom :attribute nggak boleh kosong ya!..',
            'unique'   => 'Kolom :attribute sudah ada yang pakai nih..',
            'max'      => 'Kolom :attribute maksimal :max karakter aja ya!..',
        ];

        //? 3. validasi data berdasarkan aturan dan pesan yang telah dibuat
        $validatedData = $request->validate($aturan, $pesan);

        //? 4. simpan data ke database
        Kategori::create($validatedData);

        //? 5. alihkan ke halaman list kategori dengan pesan sukses
        return redirect()->route('kategori.index')->with('berhasil', 'Yes!! Kategori barang berhasil ditambahkan.');
    
    }

    /**
     * ? menampilkan halaman deatil kategori
     */
    public function show(Kategori $kategori)
    {
        // ? alihkan langsung ke halaman edit kategori
        return redirect()->route('kategori.edit', $kategori);
    }

    /**
     * ? menampilkan form edit data kategori yang dipilih
     */
    public function edit(Kategori $kategori)
    {
        /// ? menampilkan view edit.blade.php di folder dashboard/kategori, sambil kirim data :
        return view('dashboard.kategori.edit', [
            'title' => 'Perbarui Data Kategori', // judul halaman
            'kategori' => $kategori // data kategori yang mau diedit
        ]);
    }

    /**
     * ? memperbarui data kategori yang diedit ke database
     */
    public function update(Request $request, Kategori $kategori)
    {
        // dd($request->all());
        //? 1. membuat aturan validasi data untuk nama kategori dan deskripsi
        $aturan = [
            'nama_kategori' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
        ];

        //? 2. jika kode_kategori diubah, buat aturan untuk kode kategori baru
        if ($request->kode_kategori !== $kategori->kode_kategori) {
            $aturan['kode_kategori'] = 'required|string|max:20|unique:kategoris,kode_kategori';
        }

        //? 3. membuat pesan validasi custom
        $pesan = [
            'required' => 'Kolom :attribute nggak boleh kosong ya!.',
            'unique' => 'Kolom :attribute sudah ada pakai!.',
            'max' => 'Kolom :attribute maksimal :max karakter.',
        ];

        //? 4. validasi data berdasarkan aturan dan pesan yang telah dibuat
        $validatedData = $request->validate($aturan, $pesan);

        

        //? 5. update data ke database
        $kategori->update($validatedData);

        // ? 6. redirect ke halaman kategori dan kirimkan pesan konfirmasi
        return redirect()->route('kategori.index')->with('berhasil', 'Kategori barang berhasil diubah.');
    }

    /**
     * ? hapus data kategori dari database
     */
    public function destroy(Kategori $kategori)
    {
        // ? 1. hapus data kategori dari database
        $kategori->delete();

        // ? 2. redirect ke halaman kategori dan kirimkan pesan konfirmasi berhasil
        return redirect()->route('kategori.index')->with('berhasil', 'Kategori barang berhasil dihapus.');
    }

    /**
     * ? ekspor semua data kategori ke file PDF
     */
    public function exportToPdf()
    {
        // ? 1. Ambil semua data kategori dari database
        $kategoris = Kategori::latest()->get();

        // ? 2. Buat pdf dari view export.blade.php yang ada di folder dashboard/kategori
        $pdf = Pdf::loadView('dashboard.kategori.export', [
            'title' => 'Daftar Kategori Barang', // tampilkan judul halaman
            'kategoris' => $kategoris, // tampilkan semua data kategori yang ada di database
        ])->setPaper('a4', 'potrait'); // set PDF menggunakan ukuran kerta A4 dan potrait

        // ? 3. Download file PDF yang udah dibuat pada langkah no. 2
        return $pdf->download('daftar_kategori_barang.pdf');
    }

    /**
     * ? ekspor semua data kategori ke file Excel
     */
    public function exportToExcel()
    {
        // ? download file excel, isinya sesuai dengan yang dikonfigurasi di file KategoriExport.php
        return Excel::download(new KategoriExport, 'daftar_kategori_barang.xlsx');
    }

    /**
     * ? cetak list data kategori
     */
    public function print()
    {
        // ? ambil semua data kategori dari database
        $kategoris = Kategori::latest()->get();

        // ? jalankan view export.blade.php sambil kirim data :
        return view('dashboard.kategori.export', [
            'title' => 'Daftar Kategori Barang', // judul halaman
            'kategoris' => $kategoris, // semua data kategori
        ]);
    }
}

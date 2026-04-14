<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;
use Illuminate\Http\Request;

// ! panggil facade PDF agar bisa dugunakan di function exportToPdf()
use Barryvdh\DomPDF\Facade\Pdf;

// ! apnggil class facade Excel dan LokasiExport agar bisa digunakan di function exportToExcel()
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LokasiExport;

class LokasiController extends Controller
{
    /**
     * ? menampilkan semua data lokasi dari database di view index
     */
    public function index()
    {
        // ? jalankan view index.blade.php di folder dashboard/lokasi, lalu kirimkan data :
        return view('dashboard.lokasi.index', [
            'title' => 'Daftar Lokasi Barang', // judul halaman
            'lokasis' => Lokasi::latest()->get(), // semua data lokasi barang yang ada di database
        ]);
    }

    /**
     * ? menampilkan halaman form tambah lokasi baru
     */
    public function create()
    {
        // ? tampilkan view create.blade.php yang ada di folder dashboard/lokasi
        return view('dashboard.lokasi.create', [
            'title' => 'Tambah Lokasi Barang', // sambil kirim data judul halaman
        ]);
    }

    /**
     * ? simpan data lokasi baru ke database
     */
    public function store(Request $request)
    {
        //? 1. membuat aturan validasi data
        $aturan = [
            // kode lokasi wajib diisi, maks 20 karakter, harus unik
            'kode_lokasi' => 'required|string|max:20|unique:lokasis,kode_lokasi',
            // nama lokasi wajib diisi, maks 100 karakter
            'nama_lokasi' => 'required|string|:100',
            // deskripsi harus berupa teks, boleh dikosongkan
            'deskripsi' => 'nullable|string',
        ];

        //? 2. membuat pesan validasi custom
        $pesan = [
            'required' => 'Kolom :attribute nggak boleh kosong ya!.',
            'unique' => 'Kolom :attribute maksimal :max karakter aja ya!.',
        ];

        //? 3. validasi data berdasarkan aturan dan pesan yang telah dibuat
        $validatedData = $request->validate($aturan, $pesan);

        //? 4. simpan data ke database
        Lokasi::create($validatedData);

        //? 5. alihkan ke halaman list lokasi dengan pesan sukses
        return redirect()->route('lokasi.index')->with('berhasil', 'Yes!! lokasi barang berhasil ditambahkan.');
    }

    /**
     * ? menampilkan detail 1 data lokasi
     */
    public function show(Lokasi $lokasi)
    {
        //? alihkan langsung ke halaman edit lokasi
        return redirect()->route('lokasi.edit', $lokasi);
    }

    /**
     * ? menampilkan halaman edit lokasi yang dipilih
     */
    public function edit(Lokasi $lokasi)
    {
        // ? tampilkan view edit.blade.php yang ada di folder dashboard/lokasi
        return view('dashboard.lokasi.edit', [
            'title' => 'Edit Lokasi Brang', // kirim data judul halaman
            'lokasi' => $lokasi, // kirim data lokasi yang mau diedit
        ]);
    }

    /**
     * ? perbarui data lokasi yang di edit ke database
     */
    public function update(Request $request, Lokasi $lokasi)
    {
        //? 1. membuat aturan validasi data untuk nama dan deskripsi
        $aturan = [
            'nama_lokasi' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
        ];

        //? 2. jika kode_lokasi diubah, tambahkan aturan validasi untuk kode yang baru
        if ($request->kode_lokasi !== $lokasi->kode_lokasi) {
            $aturan['kode_lokasi'] = 'required|string|max:20|unique:lokasis,kode_lokasi';
        }

        //? 3. membuat pesan validasi custom
        $pesan = [
            'required' => 'Kolom :attribute wajib diisi.',
            'unique' => 'Kolom :attribute sudah digunakan.',
            'max' => 'Kolom :attribute maksimal :max karakter.',
        ];

        //? 4. vlidasi data berdasarkan aturan dan pesan yang telah dibuat
        $validatedData = $request->validate($aturan, $pesan);

        //? 5. update data ke database
        $lokasi->update($validatedData);

        //? 6. alihkan ke halaman lokasi dengan kirim pesan konfirmasi berhasi
        return redirect()->route('lokasi.index')->with('berhasil', 'Lokasi barang berhasil diubah.');
    }

    /**
     * ? hapus 1 data lokasi yang dipilih dari database
     */
    public function destroy(Lokasi $lokasi)
    {
        //? 1. hapus data lokasi dari database
        $lokasi->delete();

        //? 2. redirect ke halaman lokasi dan kirim pesan berhasil
        return redirect()->route('lokasi.index')->with('berhasil', 'Lokasi barang berhasil dihapus.');
    }

    /**
     * ? ekspor semua data lokasi ke file PDF
     */
    public function exportToPdf()
    {
        // ? 1. Ambil semua data lokasi dari database
        $lokasis = Lokasi::latest()->get();

        // ? 2. Buat pdf dari view export.blade.php yang ada di folder dashboard/lokasi
        $pdf = Pdf::loadview('dashboard.lokasi.export', [
            'title' => 'Daftar Lokasi Brang', // tampilkan judul halaman
            'lokasis' => $lokasis, // tampilkan semua data lokasi yang ada di database 
        ])->setPaper('a4', 'potrait'); // set PDF menggunakan ukuran kertas A4 dan potrait

        // ? 3. Download file PDF yang udah dibuat pada langkah no. 2
        return $pdf->download('daftar_lokasi_barang.pdf');
    }

    /**
     * ? ekspor semua data kategori ke file Excel
     */
    public function exportToExcel()
    {
        // ? download file excel, isinya sesuai dengan yang dikonfigurasi di file KategoriExport.php
        return Excel::download(new LokasiExport, 'daftar_lokasi_barang.xlsx');
    }

    /**
     * ? cetak list data lokasi
     */
    public function print()
    {
        // ? ambil semua data lokasi dari database
        $lokasis = lokasi::latest()->get();

        // ? jalankan view export.blade.php sambil kirim data :
        return view('dashboard.lokasi.export', [
            'title' => 'Daftar lokasi Barang', // judul halaman
            'lokasis' => $lokasis, // semua data lokasi
        ]);
    }
}

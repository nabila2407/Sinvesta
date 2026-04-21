<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Bast;
use App\Models\Kategori;
use App\Models\Lokasi;
use App\Models\User;

// ! panggil class facades agar bisa digunakan di function downloadQr
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Riskihajar\Terbilang\Facades\Terbilang;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BastExport;
use Illuminate\Support\Facades\Auth;


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
     * ? simpan berita acara baru ke database
     */
    public function store(Request $request)
    {
        //? 1. membuat aturan validasi data
        $aturan = [
            'barang_id' => 'required|exists:barangs,id',
            'user_serah_id' => 'required|exists:users,id',
            'status_serah' => 'required|in:Menunggu,Disetujui',
            'user_terima_id' => 'required|exists:users,id',
            'status_terima' => 'required|in:Menunggu,Disetujui',
        ];

        //? 2. membuat pesan custom validasi
        $pesan = [
            'required' => ':Attribute wajib diisi!',
            'in' => ':Attribute tidak valid!',
            'exists' => ':Attribute tidak ditemukan di database!',
        ];

        //? 3. lakukan validasi data
        $validatedData = $request->validate($aturan, $pesan);

        //? 4. simpan berita acara ke database
        $bast = Bast::create($validatedData);

        //? 5. ambil tanggal dibuatnya berita acara dari kolom created_at, lalu ubah ke format indonesia
        $tanggal = Carbon::parse($bast->created_at);

        //? 6. buat dokumen berita acara menggunakan format view dokumen.blade.php
        $pdf = Pdf::loadView('dashboard.bast.dokumen', [
            'bast' => $bast, // kirimkan data bast yang baru disimpan ke view dokumen.blade.php
            'hari' => strtoupper($tanggal->translatedFormat('l')), // ambil hari dari tanggal (contoh : Senin)
            'tanggal' => strtoupper(Terbilang::make($tanggal->day)), // ubah tanggal menjadi terbilang (contoh : Lima)
            'bulan' => strtoupper($tanggal->translatedFormat('F')), // ambil bulan dari tanggal (contoh : Januari)
            'tahun_terbilang' => strtoupper(Terbilang::make($tanggal->year)), // ubah tahun menjadi terbilang (contoh : Dua ribu dua puluh enam)
        ])->setPaper('a4', 'portrait'); // set ukuran kertas dan orientasi

        //? 7. simpan dokumen pdf ke storage dengan nama berdasarkan id bast
        $filename = 'Bast-' . $bast->id . '.pdf';
        $path = 'bast-pdf/' . $filename;
        Storage::put($path, $pdf->output());

        //? 8. ubah kolom file_export di tabel bast menjadi nama file pdf yang sudah disimpan di storage,
        //? lalu simpan kembali ke database
        $bast->update([
            'file_export' => $path,
        ]);

        //? 9. alihkan ke halaman index bast, dengan pesan berhasil dibuat
        return redirect()->route('bast.index')->with('berhasil', 'Berita Acara Serah Terima berhasil dibuat.');
    }

    /**
     * ? tampil detail berita acara yang dipilih
     */
    public function show(Bast $bast)
    {
        //? hanya admin atau user penyerah atau user penerima yang bisa membuka detail bast
        $this->authorize('view', $bast);
        
        //? tampilkan view show.blade.php di folder dashboard/bast, lalu kirimkan data
        return view('dashboard.bast.show', [
            'title' => 'Berita Acara Serah Terima', // judul halaman
            'bast' => $bast, // data bast yang akan ditampilkan
        ]);

    }

    /**
     * ? menampilkan form edit berita acara yang dipilih
     */
    public function edit(Bast $bast)
    {
        //? hanya admin yang bisa membuka halaman
        $this->authorize('update', $bast);
        
        //? tampilkan view edit.blade.php di folder dashboard/bast, lalu kirimkan data :
        return view('dashboard.bast.edit', [
            'title' => 'Ubah Berita Acara', // judul halaman
            'bast' => $bast, // data bast yang akan ditampilkan
            'users' => User::latest()->select('id', 'nama_lengkap')->get(), // semua data user yang ada di database
            'barangs' => Barang::latest()->select('id', 'kode_barang', 'nama_barang')->get(), // semua data barang yang ada di database
        ]);

    }


    /**
     * ? perbarui data berita acara yang dipilih ke database,
     * ? lalu buat ulang dokumen pdf yang sesuai dengan data yang sudah diperbarui
     */
    public function update(Request $request, Bast $bast)
    {
        //? 1. membuat aturan validasi
        $aturan = [
            'barang_id' => 'required|exists:barangs,id',
            'user_serah_id' => 'required|exists:users,id',
            'status_serah' => 'required|in:Menunggu,Disetujui',
            'user_terima_id' => 'required|exists:users,id',
            'status_terima' => 'required|in:Menunggu,Disetujui',
        ];

        //? 2. membuat pesan custom validasi
        $pesan = [
            'required' => ':Attribute wajib diisi!',
            'in' => ':Attribute tidak valid!',
            'exists' => ':Attribute tidak ditemukan di database!',
        ];

        //? 3. lakukan validasi data
        $validatedData = $request->validate($aturan, $pesan);

        // ? 4. perbarui data bast ke database
        $bast->update($validatedData);

        // ? 5. ambil tanggal diperbaruinya berita acara dari kolom updated_at, lalu ubah ke format indonesia
        $tanggal = Carbon::parse($bast->updated_at);

        // ? 6. buat ulang dokumen berita acara menggunakan format view dokumen.blade.php
        $pdf = Pdf::loadView('dashboard.bast.dokumen', [
            'bast' => $bast,
            'hari' => strtoupper($tanggal->translatedFormat('l')), // ambil hari dari tanggal (contoh : Senin)
            'tanggal' => strtoupper(Terbilang::make($tanggal->day)), // ubah tanggal menjadi terbilang (contoh : Lima)
            'bulan' => strtoupper($tanggal->translatedFormat('F')), // ambil bulan dari tanggal (contoh : Januari)
            'tahun_terbilang' => strtoupper(Terbilang::make($tanggal->year)), // ubah tahun menjadi terbilang (contoh : Dua ribu dua puluh enam)
        ])->setPaper('a4', 'portrait'); // set ukuran kertas dan orientasi

        // ? 7. simpan ulang dokumen pdf ke storage dengan nama berdasarkan id bast
        $filename = 'Bast-'.$bast->id.'.pdf';
        $path = 'bast-pdf/'.$filename;
        Storage::put($path, $pdf->output());
        
        // ? Simpan kembali path file pdf yang sudah diperbarui ke kolom file_export di tabel bast
        $bast->update([
            'file_export' => $path,
        ]);

        // ? 8. alihkan ke halaman index bast, dengan pesan berhasil diperbarui
        return redirect()->route('bast.index')->with('berhasil', 'Berita Acara Serah Terima berhasil diperbarui.');
    }

    /**
     * ? hapus data berita acara yang dipilih dari database, dan hapus juga file pdf nya dari storage jika ada
     */
    public function destroy(Bast $bast)
    {
        // ? hanya admin yang bisa menghapus bast
        $this->authorize('delete', $bast);
        
        //? 1. cek & hapus file pdf jika ada
        if ($bast->file_export && Storage::exists($bast->file_export)) {
            Storage::delete($bast->file_export);
        }

        // ? 2. hapus data bast
        $bast->delete();

        // ? 3. alihkan ke halaman index bast, dengan pesan berhasil dihapus
        return redirect()->route('bast.index')->with('berhasil', 'Berita Acara Serah Terima berhasil dihapus.');
    }    

    /**
     * ? download file pdf berita acara yang sudah dibuat
     */
    public function downloadPdf(Bast $bast)
    {
        // ? download file dokumen berita acara yang sudah disimpan di storage,
        // ? dengan nama file sesuai dengan nama file yang ada di kolom file_export di tabel bast
        return Storage::download($bast->file_export);
    }

    /**
     * ? ekspor semua data list berita acara
     */
    public function exportToPdf()
    {
        // ? ambil semua data bast beserta relasinya, lalu urutkan dari yang paling baru
        $basts = Bast::with(['barang.kategori', 'barang.lokasi', 'userSerah', 'userTerima'])->latest()->get();

        // ? generate kode QR untuk setiap bast,
        // ? dengan isi QR berupa url ke halaman detail barang yang terkait dengan bast tersebut
        foreach ($basts as $bast) {
            $bast->qr_base64 = base64_encode(
                QrCode::format('svg')->size(80)->generate(
                    route('barang.show', $bast->barang)
                )
            );
        }

        // ? buat dokumen pdf menggunakan format view export.blade.php
        $pdf = Pdf::loadView('dashboard.bast.export', [
            'title' => 'Daftar Berita Acara Serah Terima', // judul halaman
            'basts' => $basts, // data bast yang akan diekspor ke pdf
        ])->setPaper('a4', 'portrait');

        // ? download file pdf yang sudah digenerate, dengan nama file daftar_berita_acara_serah_terima.pdf
        return $pdf->download('daftar_berita_acara_serah_terima.pdf');
    }

    /**
     * ? ekspor semua data list berita acara ke file excel
     */
    public function exportToExcel()
    {
        // ? download file excel yang sudah digenerate, dengan nama file daftar_berita_acara_serah_terima.xlsx
        return Excel::download(new BastExport, 'daftar_berita_acara_serah_terima.xlsx');
    }

    /**
     * ? cetak semua data berita acara
     */
    public function print()
    {
        // ? ambil semua data bast beserta relasinya, lalu urutkan dari yang paling baru
        $basts = Bast::with(['barang.kategori', 'barang.lokasi', 'userSerah', 'userTerima'])->latest()->get();

        // ? generate kode QR untuk setiap bast,
        foreach ($basts as $bast) {
            $bast->qr_base64 = base64_encode(
                QrCode::format('svg')->size(80)->generate(
                    route('barang.show', $bast->barang)
                )
            );
        }

        // ? tampilkan view export.blade.php di folder dashboard/bast, lalu kirimkan data :
        return view('dashboard.bast.export', [
            'title' => 'Daftar Berita Acara Serah Terima', // judul halaman
            'basts' => $basts, // data bast yang akan dicetak, dengan kode QR yang sudah digenerate
        ]);
    }
}

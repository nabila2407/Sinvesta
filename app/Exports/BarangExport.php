<?php

namespace App\Exports;

use App\Models\Barang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BarangExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Barang::with(['kategori', 'lokasi']) // ambil data barang, kategori, dan lokasi
            ->latest() // urutkan dari yang paling baru
            ->get() // ambil semua datanya
            ->map(function ($barang) { // kirimkan data berdasarkan ketentuan dibawah ini.
                return [
                    'kode_barang' =>$barang->kode_barang,
                    'nama_barang' =>$barang->nama_barang,

                    // kategori
                    'kode_kategori' =>$barang->kategori->kode_kategori ?? '-',
                    'nama_kategori' =>$barang->kategori->nama_kategori ?? '-',

                    // lokasi
                    'kode_lokasi' =>$barang->lokasi->kode_lokasi ?? '-',
                    'nama_lokasi' =>$barang->lokasi->nama_lokasi ?? '-',

                    'status_barang' =>$barang->status_barang,
                    'deskripsi' =>$barang->deskripsi,
                ];

            });
    }

    // ? function ini berfungsi untuk membuat judul kolom (baris pertama)
    public function headings(): array
    {
        return [
            'Kode Barang',
            'Nama Barang',
            'Kode Kategori',
            'Nama Kategori',
            'Kode Lokasi',
            'Nama Lokasi',
            'Status Barang',
            'Deskripsi',
        ];
    }
}

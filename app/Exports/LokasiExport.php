<?php

namespace App\Exports;

use App\Models\Lokasi;
use Maatwebsite\Excel\Concerns\FromCollection;

use Maatwebsite\Excel\Concerns\WithHeadings;

class LokasiExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // ? tentukan data apa saja yang akan di ekspor ke Excel
        return Lokasi::select(
            'kode_lokasi',
            'nama_lokasi',
            'deskripsi',
            'created_at'
        )->get();
    }

    public function headings(): array
    {
        // ? berfungsi untuk membuat judul kolom (baris paling atas di excel)
        return [
            'Kode Lokasi',
            'Nama Lokasi',
            'Deskripsi',
            'Tanggal Dibuat',
        ];
    }
}

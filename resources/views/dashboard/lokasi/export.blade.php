{{-- ? Buat struktur HTML baru untuk di ekspor ke PDF --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Data Lokasi Barang' }}</title>

    {{-- Styliong CSS --}}
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #000;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h2 {
            margin: 0;
            font-size: 16px;
            text-transform: uppercase;
        }

        .header p {
            margin: 4px 0 0;
            font-size: 11px;
        }

        .meta {
            margin-bottom: 15px;
            font-size: 11px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table thead th {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
            background-color: #f2f2f2;
        }

        table tbody td {
            border: 1px solid #000;
            padding: 6px;
            vertical-align: top;
        }

        .text-center {
            text-align: center;
        }

        .footer {
            margin-top: 30px;
            font-size: 11px;
        }

        .signature {
            margin-top: 50px;
            width: 100%;
        }

        .signature td {
            width: 50%;
            text-align: center;
        }
    </style>
</head>
<body @if(Request::is('dashboard/print-lokasi')) onload="window.print()" @endif>
<body>

    {{-- HEADER --}}
    <div class="header">
        <h2>{{ $title ?? 'Daftar Lokasi Barang' }}</h2>
        <p>Sistem Manajemen Inventaris</p>
    </div>

    {{-- INFORMASI EKSPOR --}}
    <div class="meta">
        <strong>Tanggal Cetak:</strong> {{ now()->format('d F Y') }} <br>
        <strong>Jumlah Data:</strong> {{ $lokasis->count() }} lokasi
    </div>

    {{-- TABEL DATA --}}
    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="20%">Kode Lokasi</th>
                <th width="25%">Nama Kategori</th>
                <th width="30%">Deskripsi</th>
                <th width="20%">Tanggal Dibuat</th>
            </tr>
        </thead>
        <tbody>
            {{-- ? TAMPILKAN SEMUA DATA LOKASI DI DATABASE SATU PERSATU MENGGUNAKAN PERULANGAN --}}
            @forelse ($lokasis as $lokasi)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $lokasi->kode_lokasi }}</td>
                    <td>{{ $lokasi->nama_lokasi }}</td>
                    <td>{{ $lokasi->deskripsi ?? '-' }}</td>
                    <td class="text-center">
                        {{ $lokasi->created_at->format('d-m-Y') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">
                        Tidak ada data lokasi barang.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- FOOTER --}}
    <div class="footer">
        <table class="signature">
            <tr>
                <td>
                    Mengetahui,<br>
                    <strong>Admin Inventaris</strong>
                    <br><br><br>
                    ( ____________________ )
                </td>
                <td>
                    Dicetak oleh,<br>
                    {{ auth()->user()->nama_lengkap ?? 'Administrator' }}
                    <br><br><br>
                    ( ____________________ )
                </td>
            </tr>
        </table>
    </div>

</body>
</html>
















</style>

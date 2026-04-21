<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Daftar Barang Inventaris' }}</title>

    {{-- ? buat styling css di sini --}}
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        h2 {
            text-align: center;
            margin-bottom: 10px;
        }

        table {
            width: 100%
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #000;
        }

        th {
            background-color: #f2f2f2;
            text-align: center;
            padding: 6px;
        }

        td {
            padding: 5px;
            vertical-align: middle;
        }

        .text-center {
            text-align: center;
        }

        .qr {
            text-align: center;
        }

        .status-baik {
            color:  green;
            font-weight: bold;
        }

        .status-ringan {
            color: orange;
            font-weight: bold;
        }

        .status-berat {
            color:  red;
            font-weight: bold;
        }

        .status-hilang {
            color:  black;
            font-weight: bold;
        }
    </style>
</head>
<body @if(Request::is('dashboard/print-barang')) onload="window.print()" @endif>

    <h2>{{ $title ?? 'Daftar Barang Inventaris' }}</h2>

        <table>
            <thead>
                <tr>
                    <th width="3%">No</th>
                    <th width="10%">QR Code</th>
                    <th width="12%">Kode Barang</th>
                    <th width="18%">Nama Barang</th>
                    <th width="15%">Kategori</th>
                    <th width="15%">Lokasi</th>
                    <th width="12%">Status</th>
                    <th width="15%">Tanggal Input</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($barangs as $barang)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="qr">
                            <img src="data:image/svg+xml;base64,{{ $barang->qr_base64 }}" width="70" height="70">
                        </td>
                        <td>{{ $barang->kode_barang }}</td>
                        <td>{{ $barang->nama_barang }}</td>
                        <td>{{ $barang->kategori->nama_kategori }}</td>
                        <td>{{ $barang->lokasi->nama_lokasi }}</td>

                        <td class="text-center">
                            @if ($barang->status_barang === 'Baik')
                                <span class="status-baik">{{ $barang->status_barang }}</span>
                            @elseif ($barang->status_barang === 'Rusak Ringan')
                                <span class="status-ringan">{{ $barang->status_barang }}</span>
                            @elseif ($barang->status_barang === 'Rusak Berat')
                                <span class="status-berat">{{ $barang->status_barang }}</span>
                            @elseif ($barang->status_barang === 'Hilang')
                                <span class="status-hilang">{{ $barang->status_barang }}</span>
                            @endif
                        </td>

                        <td class="text-center">
                            {{ $barang->created_at->translatedFormat('l, d-m-Y') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">
                            Tidak ada data barang.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

</body>
</html>


</style>

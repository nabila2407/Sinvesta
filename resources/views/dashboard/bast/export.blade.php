<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Berita Acara Serah Terima</title>

    {{-- STYLE --}}
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
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

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th, table td {
            border: 1px solid #000;
            padding: 6px;
            vertical-align: middle;
        }

        table th {
            background-color: #f2f2f2;
            text-align: center;
            font-weight: bold;
        }

        .text-center {
            text-align: center;
        }

        .qr {
            width: 60px;
            height: 60px;
        }

        .footer {
            margin-top: 30px;
            font-size: 10px;
        }
    </style>
</head>
<body @if(Request::is('dashboard/print-bast')) onload="window.print()" @endif>

    {{-- HEADER --}}
    <div class="header">
        <h2>Daftar Berita Acara Serah Terima Barang</h2>
        <p>Dicetak pada: {{ now()->format('d-m-Y') }}</p>
    </div>

        {{-- TABEL DATA --}}
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>QR Code</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Lokasi</th>
                    <th>Status</th>
                    <th>Penyerah</th>
                    <th>Penerima</th>
                    <th>Status BAST</th>
                    <th>Tanggal Dibguat</th>
                </tr>
            </thead>
            <tbody>
                {{-- JIKA DATA BAST ADA, TAMPILKAN SATU PERSATU DENGAN PERULANGAN --}}
                @forelse ($barangs as $barang)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>

                        {{-- TAMPIL QR CODE BASE64   --}}
                        <td class="text-center">
                            <img src="data:image/svg+xml;base64,{{ $baST->qr_base64 }}" width="70" height="70">
                        </td>
                        <td>{{ $bast->barang->nama_barang }}</td>
                        <td>{{ $bast->barang->kategori->nama_kategori }}</td>
                        <td>{{ $bast->barang->lokasi->nama_lokasi }}</td>
                        <td class="text-center">{{ $bast->barang->status_barang }}</td>
                        <td>{{ $bast->userSerah->nama_lengkap }}</td>
                        <td>{{ $bast->userTerima->nama_lengkap }}</td>

                        <td class="text-center">
                            @if ($bast->status_serah === 'Disetujui' && $bast->status_terima === 'Disetujui')
                                Disetujui
                            @else 
                                Menunggu
                            @endif 
                        </td>

                        <td class="text-center">
                            {{ $bast->created_at->format('d-m-Y') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center">
                            Data Berita Acara Serah Terima tidak tersedia.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- FOOTER --}}
        <div class="footer">
            <p>
                Dokumen ini dihasilkan secara otomatis oleh sistem dan sah tanpa tanda tangan.
            </p>
        </div>

</body>
</html>


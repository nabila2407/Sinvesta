<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Berita Acara Serah Terima Barang</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            line-height: 1.6;
        }

        .page-border {
            border: 2px solid #333;
            padding: 30px;
        }

        .doc-number {
            text-align: right;
            font-size: 11px;
            margin-bottom: 30px;
        }

        .title {
            text-align: center;
            font-weight: bold;
            margin-bottom: 30px;
        }

        .title h1 {
            font-size: 16px;
            margin: 0;
        }

        .title h2 {
            font-size: 14px;
            margin: 5px 0 0 0;
        }

        .content {
            text-align: justify;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            margin-bottom: 20px;
        }

        table th,
        table td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
        }

        table th {
            font-weight: bold;
        }

        .signature {
            width: 100%;
            margin-top: 40px;
        }

        .signature td {
            width: 50%;
            vertical-align: top;
            text-align: left;
        }

        .signature .title-sign {
            font-weight: bold;
            margin-bottom: 60px;
        }
    </style>
</head>

<body>

    <div class="page-border">

        {{-- Nomor Dokumen Berita Acara --}}
        {{-- Kode Kategori/Lokasi/Kode Barang --}}
        <div class="doc-number">
            {{ $bast->barang->kategori->kode_kategori }}/{{ $bast->barang->lokasi->kode_lokasi }}/{{ $bast->barang->kode_barang }}
        </div>

        {{-- Judul Dokumen --}}
        <div class="title">
            <h1>BERITA ACARA</h1>
            <h2>SERAH TERIMA BARANG / ASET</h2>
        </div>

        {{-- Paragraf Pembuka --}}
        <div class="content">
            Pada hari ini <b>{{ $hari }}</b> tanggal <b>{{ $tanggal }}</b> bulan <b>{{ $bulan }}</b> tahun <b>{{ $tahun_terbilang }}</b> bertempat di <b>{{ $bast->barang->lokasi->nama_lokasi }}</b>, telah dilakukan serah terima barang antara pihak <b>{{ $bast->userSerah->nama_lengkap }}</b> dengan <b>{{ $bast->userTerima->nama_lengkap }}</b>.
        </div>

        <div class="content">
            Adapun rincian yang diserahterimakan secara lengkap sebagai berikut :
        </div>

        {{-- Tabel Barang --}}
        <table>
            <thead>
                <tr>
                    <th style="width: 50px;">No.</th>
                    <th>Nama Barang</th>
                    <th style="width: 200px;">Checklist / Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td style="text-align: left;">{{ $bast->barang->nama_barang }}</td>
                    <td>{{ $bast->barang->status_barang }}</td>
                </tr>
            </tbody>
        </table>

        {{-- Penutup --}}
        <div class="content">
            Demikian Berita Acara Serah Terima ini dibuat dengan sebenar-benarnya dan
            untuk dipergunakan sebagaimana mestinya, serta ditandatangani oleh kedua
            belah pihak.
        </div>

        {{-- Tanda Tangan --}}
        <table class="signature" border="0">
            <tr>
                <td>
                    <div class="title-sign">Yang Menyerahkan</div>
                    <div>{{ $bast->userSerah->nama_lengkap }}</div>
                    <div>{{ $bast->userSerah->lembaga }}</div>
                </td>
                <td>
                    <div class="title-sign">Yang Menerima</div>
                    <div>{{ $bast->userTerima->nama_lengkap }}</div>
                    <div>{{ $bast->userTerima->lembaga }}</div>
                </td>
            </tr>
        </table>
    </div>

</body>

</html>
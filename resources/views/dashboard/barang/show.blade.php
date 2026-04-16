{{-- ? Panggil file main.blade.php yang ada difolder dashboard/layout --}}
@extends('dashboard.layout.main')

{{-- ? Sisipkan code CSS untuk fitur cetak QRCode --}}
@section('css')
    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            .bar-code,
            .bar-code * {
                visibility: visible;
            }

            .bar-code {
                position: absolute;
                left: 50%;
                top: 50% transform: translate(-50%, -50%);
                text-align: center;
            }
        }
    </style>
@endsection

{{-- ? Tulis kode HTML untuk halaman show barang diantara @section --}}
@section('konten')

    {{-- ! konten utama halaman dashboard ditulis disini --}}

    <div class="page-header">
        {{-- judul halaman --}}
        <div class="page-title">
            <h4>Detail Barang</h4>
            <h6>Lihat detail barang inventaris</h6>
        </div>
    </div>

    {{-- card detail data barang --}}
    <div class="card">
        <div class="card-body">
            <div class="row">

                {{-- kolom kiri, menampilkan detail barang --}}
                <div class="col-lg-8 col-12">
                    <div class="row">
                        {{-- tampil kode barang --}}
                        <div class="col-6">
                            <div class="mb-3">
                                <div>Kode Barang:</div>
                                <h4 class="fw-bold">{{ $barang->kode_barang }}</h4>
                            </div>
                        </div>
                        {{-- tampil nama barang --}}
                        <div class="col-6">
                            <div class="mb-3">
                                <div>Nama Barang:</div>
                                <h4 class="fw-bold">{{ $barang->nama_barang }}</h4>
                            </div>
                        </div>
                        {{-- tampil kategori barang --}}
                        <div class="col-6">
                            <div class="mb-3">
                                <div>Kategori Barang:</div>
                                <h4 class="fw-bold">{{ $barang->kategori->nama_kategori }}</h4>
                            </div>
                        </div>
                        {{-- tampil lokasi barang --}}
                        <div class="col-6">
                            <div class="mb-3">
                                <div>Lokasi Barang:</div>
                                <h4 class="fw-bold">{{ $barang->lokasi_barang }}</h4>
                            </div>
                        </div>

                        {{-- tampil status barang --}}
                        <div class="col-6">
                            <div class="mb-3">
                                <div>Status Barang:</div>
                                <h4 class="fw-bold">
                                    @if ($barang->status_barang == 'Baik')
                                        <span class="btn btn-sm btn-success">Baik</span>
                                    @elseif ($barang->status_barang == 'Rusak Ringan')
                                        <span class="btn btn-sm btn-warning">Rusak Ringan</span>
                                    @elseif ($barang->status_barang == 'Rusak Berat')
                                        <span class="btn btn-sm btn-danger">Rusak Berat</span>
                                    @else
                                        <span class="btn btn-sm btn-dark">Hilang</span>
                                    @endif
                                </h4>
                            </div>
                        </div>
                        {{-- tampil deskripsi --}}
                        <div class="col-6">
                            <div class="mb-3">
                                <div>Deskripsi Barang:</div>
                                <h6 class="fw-bold">{{ $barang->deskripsi ?? '-' }}</h6>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- kolom kanan: menampilkan QRCode --}}
                <div class="col-lg-4 col-12">
                    <div>QR Code Barang:</div>
                    <div class="bar-code-view">
                        {{-- generate QRCode dari data link detail barang --}}
                        <div class="bar-code">
                            {!! QrCode::size(100)->generate(route('barang.show', $barang)) !!}
                        </div>

                        {{-- tombol cetak QRCode --}}
                        <a class="btn btn-secondary mx-0" onclick="window.print()">
                            <i class="bi bi-printer"></i>
                        </a>

                        {{-- tombol download QRCode --}}
                        <a href="{{ route('barang.downloadQr', $barang) }}" class="btn btn-primary">
                            <i class="bi bi-download"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- card footer --}}
        <div class="card-footer">

            {{-- tombol cetak detail barang --}}
            <a href="#" class="btn btn-secondary" target="_blank">
                <i class="bi bi-printer"></i>
            </a>

            {{-- jika user yang login adalah role=admin --}}
            @if (Auth::user()->role == 'admin')
                {{-- tampilkan tombol edit --}}
                <a href="{{ route('barang.edit', $barang) }}" class="btn btn-primary">
                    <i class="bi bi-pencil-square"></i>
                </a>

                {{-- tampilkan tombol hapus --}}
                <form action="{{ route('barang.destroy', $barang) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger"
                        onclick="return confirm('Yakin ingin menghapus barang {{ $barang->nama_barang }}?')">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
            @endif
        </div>
    </div>

    {{-- card untuk menampilkan riwayat berita acara barang --}}
    <div class="card">
        <div class="card-body">
            {{-- jika tidak ada berita acara untuk barang ini --}}
            @if ($basts->isEmpty())
                {{-- tampilkan pesan informasi --}}
                <div class="card-title">
                    Belum Ada Riwayat Serah Terima Barang untuk {{ $barang->nama_barang }} dengan
                    Kode {{ $barang->kode_barang }}
                </div>

            {{-- jika ada berita acara untuk barang ini --}}
            @else
                {{-- judul card --}}
                <div class="card-title">
                    Riwayat Berita Acara Serah Terima Barang : {{ $barang->nama_barang }}
                </div>

                {{-- kolom pencarian --}}
                <div class="table-top">
                    <div class="search-set">
                        <div class="search-input">
                            <a class="btn btn-searchset"><i class="bi bi-search"></i></a>
                        </div>
                    </div>
                </div>

                {{-- table riwayat berita acara --}}
                <div class="table-responsive">
                    <table class="table datanew">

                        {{-- judul kolom --}}
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Barang</th>
                                <th>Penyerah</th>
                                <th>Penerima</th>
                                <th>Status</th>
                                {{-- jika user yang login adalah role=admin --}}
                                @if (Auth::user()->role == 'admin')
                                    <th>Aksi</th>
                                @endif
                            </tr>
                        </thead>

                        {{-- isi table --}}
                        <tbody>
                            {{-- tampilan berita acara satu persatu menggunakan perulangan --}}
                            @foreach ($basts as $bast)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $bast->barang->nama_barang }}</td>
                                    <td>
                                        @if ($bast->status_serah == 'Menunggu')
                                            <span class="btn btn-sm text-white bg-secondary">
                                                <i class="bi bi-hourglass-split"></i>
                                            </span>
                                        @else
                                            <span class="btn btn-sm text-white bg-success">
                                                <i class="bi bi-check-circle"></i>
                                            </span>
                                        @endif
                                        <span class="ms-2">{{ $bast->userSerah->nama_lengkap }}</span>
                                    </td>
                                    <td>
                                        @if ($bast->status_terima == 'Menunggu')
                                            <span class="btn btn-sm text-white bg-secondary">
                                                <i class="bi bi-hourglass-split"></i>
                                            </span>
                                        @else
                                            <span class="btn btn-sm text-white bg-success">
                                                <i class="bi bi-check-circle"></i>
                                            </span>
                                        @endif
                                        <span class="ms-2">{{ $bast->userTerima->nama_lengkap }}</span>
                                    </td>
                                    <td>
                                        @if ($bast->status_serah == 'Disetujui' && $bast->status_terima == 'Disetujui')
                                            <span class="btn btn-sm text-white bg-success">
                                                <i class="bi bi-check-circle"></i> Disetujui
                                            </span>
                                        @else
                                            <span class="btn btn-sm text-white bg-secondary">
                                                <i class="bi bi-hourglass-splitt">Menunggu</i>
                                            </span>
                                        @endif
                                    </td>

                                    {{-- jika user yang login adalah role=admin --}}
                                    @if (Auth::user()->role == 'admin')
                                        <td>
                                            {{-- tampilkan tombol cetak berita acara --}}
                                            <a href="#" class="me-3">
                                                <i class="bi bi-download"></i>
                                            </a>

                                            {{-- tampilkan tombol detail berita acara --}}
                                            <a href="#" class="me-3">
                                                <i class="bi bi-eye"></i>
                                            </a>

                                            {{-- tombol edit berita acara --}}
                                            <a href="#" class="me-3">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>

                                            {{-- tombol hapus berita acara --}}
                                            <form action="#" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    type="submit"
                                                    class="confirm-text btn p-0 m-0"
                                                    onclick="return confirm('Yakin ingin menghapus berita acara {{ $bast->kode_barang }}?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection
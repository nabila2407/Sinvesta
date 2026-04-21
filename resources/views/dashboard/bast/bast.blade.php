{{-- ? Panggil file main.blade.php yang ada difolder dashboard/layout --}}
@extends('dashboard.layout.main')

{{-- ? Tulis kode HTML untuk halaman index bast diantara @section --}}
@section('konten')

    {{-- ! konten utama ditulis disini --}}
    <div class="page-header">
        {{-- Judul Halaman --}}
        <div class="page-title">
            <h4>Daftar Berita Acara Serah Terima</h4>
            <h6>{{ $deskripsi }}</h6>
        </div>
    </div>

    {{-- card list BAST --}}
    <div class="card">
        <div class="card-body">

            {{-- jika BAST tidak ada didatabase --}}
            @if ($basts->isEmpty())
                {{-- tampilkan informasinya --}}
                <div class="alert alert-info" role="alert">
                    Tidak ada berita acara tersedia.
                </div>
            {{-- jika BAST ada didatabase --}}
            @else
                {{-- kolom pencarian --}}
                <div class="table-top">
                    <div class="search-set">
                        <div class="search-input">
                            <a class="btn btn-searchset"><i class="bi bi-search"></i></a>
                        </div>
                    </div>
                </div>

                {{-- tabel list BAST --}}
                <div class="table-responsive">
                    <table class="table datanew">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Barang</th>
                                <th>Kategori Barang</th>
                                <th>Lokasi Barang</th>
                                <th>Status Barang</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <body>
                            {{-- tampilan BAST atau persatu menggunakan perulangan --}}
                            @foreach ($basts as $bast )
                                <tr>
                                    <td>{{ $loop->interation }}</td>
                                    <td>{{ $bast->barang->nama_barang }}</td>
                                    <td>{{ $bast->barang->kategori->nama_kategori }}</td>
                                    <td>{{ $bast->barang->lokasi->nama_lokasi }}</td>
                                    <td>
                                        @if ($bast->barang->status_barang == 'Baik')
                                            <span class="btn btn-sm btn-success">Baik</span>
                                        @elseif ($bast->barang->status_barang == 'Rusak Ringan')
                                            <span class="btn btn-sm btn-warning">Rusak Ringan</span>
                                        @elseif ($bast->barang->status_barang == 'Rusak Berat')
                                            <span class="btn btn-sm btn-danger">Rusak Berat</span>
                                        @else 
                                            <span class="btn btn-sm btn-dark">Hilang</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if (auth()->user()->id == $bast->user_serah_id)
                                            @if ($bast->status_serah == 'Menunggu')
                                                <span class="btn btn-sm text-white bg-secondary">
                                                    <i class="bi bi-hourglass-split"></i> {{ $bast->status_serah }}
                                                </span>
                                            @else
                                                <span class="btn btn-sm text-white bg-success">
                                                    <i class="bi bi-check-circle-fill"></i> {{ $bast->status_serah }}
                                                </span>
                                            @endif
                                        @else
                                            @if ($bast->status_terima == 'Menunggu')
                                                <span class="btn btn-sm text-white bg-secondary">
                                                    <i class="bi bi-hourglass-split"></i> {{ $bast->status_terima }}
                                                </span>
                                            @else
                                                <span class="btn btn-sm text-white bg-success">
                                                    <i class="bi bi-check-circle-fill"></i> {{ $bast->status_terima }}
                                                </span>
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('bast.show', $bast) }}" class="me-3">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </body>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection


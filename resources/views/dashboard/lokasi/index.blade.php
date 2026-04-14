{{-- ? Panggil file main.blade.php yang ada difolder dashboard/layout --}}
@extends('dashboard.layout.main')

{{-- ? Tulis kode HTML untuk halaman index user diantara @section --}}
@section('konten')

    {{-- ! konten utama halaman dashboard ditulis disini --}}

    <div class="page-header">

        {{-- judul halaman --}}
        <div class="page-title">
            <h4>List Lokasi Barang</h4>
            <h6>Lihat atau cari lokasi barang</h6>
        </div>

        {{-- tombol tambah lokasi baru --}}
        <div class="page-btn">
            <a href="{{ route('lokasi.create') }}" class="btn btn-added">
                <i class="bi bi-plus-circle"></i>Tambah Lokasi
            </a>
        </div>

    </div>

    {{-- card list data lokasi --}}
    <div class="card">
        <div class="card-body">

            {{-- ? jika data lokasi tidak ada didatabase --}}
            @if ($lokasis->isEmpty())
                {{-- tampilkan informasi --}}
                <div class="alert alert-info" role="alert">
                    Tidak ada lokasi barang tersedia.
                </div>

                {{-- ? jika data lokasi ada didatabase --}}
            @else
                <div class="table-top">

                    {{-- kolom pencarian --}}
                    <div class="search-set">
                        <div class="search-input">
                            <a class="btn btn-searchset"><i class="bi bi-search"></i></a>
                        </div>
                    </div>

                    {{-- menu ekspor data lokasi ke PDF, Excel dan Print --}}
                    <div class="wordset">
                        <ul>

                            {{-- ekspor ke pdf --}}
                            <li>
                                <a href="{{ route('lokasi.exportToPdf') }}">
                                    <img src="{{ asset('assets/icon/pdf.svg') }}" alt="img" />
                                </a>
                            </li>

                            {{-- ekspor ke excel --}}
                            <li>
                                <a href="{{ route('kategori.exportToExcel') }}">
                                    <img src="{{ asset('assets/icon/excel.svg') }}" alt="">
                                </a>
                            </li>

                            {{-- cetak --}}
                            <li>
                                <a href="{{ route('lokasi.print') }}" target="_blank">
                                    <img src="{{ asset('assets/icon/printer.svg') }}" alt="">
                                </a>
                            </li>

                        </ul>
                    </div>
                </div>
                <div class="table-responsive">

                    {{-- tabel list data lokasi --}}
                    <table class="table datanew">

                        {{-- judul kolom --}}
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Kode</th>
                                <th>Nama Lokasi</th>
                                <th>Keterangan</th>
                                <th>Dibuat</th>
                                <th>Aksi</th>
                            </tr>                       
                        </thead>

                        {{-- isi tabel --}}
                        <tbody>

                            {{-- ? tampilkan semua data lokasi atau persatu menggunakan perulangan --}}
                            @foreach ($lokasis as $lokasi)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $lokasi->kode_lokasi }}</td>
                                    <td>{{ $lokasi->nama_lokasi }}</td>
                                    <td>{{ $lokasi->deskripsi }}</td>
                                    <td>{{ $lokasi->created_at }}</td>
                                    <td>
                                        {{-- tombol edit lokasi --}}
                                        <a href="{{ route('lokasi.edit', $lokasi) }}" class="me-3">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        {{-- tombol hapus lokasi --}}
                                        <form action="{{ route('lokasi.destroy', $lokasi) }}" method="POST" class="d-inline">
                                            @csrf
                                            {{-- ubah method post -> delete --}}
                                            @method('DELETE')
                                            <button
                                                type="submit"\
                                                class="confirm-text btn p0 m0"
                                                onclick="return confirm('Lokasi: {{ $lokasi->nama_lokasi }} memiliki barang terkait. Yakin ingin dihapus?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>

                                    </td>
                                </tr> 
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection

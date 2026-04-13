{{-- ? Panggil file main.blade.php yang ada difolder dashboard/layout --}}
@extends('dashboard.layout.main')

{{-- ? Tulis kode HTML untuk halaman index user diantara @section --}}
@section('konten')
    {{-- ! konten utama halaman dashboard ditulis disini --}}

    <div class="page-header">

        {{-- judul halaman --}}
        <div class="page-title">
            <h4>List Kategori Barang</h4>
            <h6>Lihat atau cari kategori barang</h6>
        </div>

        {{-- tombol tambah data kategori baru --}}
        <div class="page-btn">
            <a href="{{ route('kategori.create') }}" class="btn btn-added">
                <i class="bi bi-plus-circle"></i>Tambah Kategori
            </a>
        </div>
    </div>

    {{-- card menampilkan daftar kategori barang --}}
    <div class="card">
        <div class="card-body">

            {{-- ? jika kategori barang tidak ada didatabase --}}
            @if ($kategoris->isEmpty())
                {{-- * tampilkan informasi --}}
                <div class="alert alert-info" role="alert">
                    Tidak ada kategori barang tersedia.
                </div>

                {{-- ? jika data kategori barang ada di database --}}
            @else
                <div class="table-top">

                    {{-- kolom pencarian kategori --}}
                    <div class="search-set">
                        <div class="search-input">
                            <a class="btn btn-searchset"><i class="bi bi-search"></i></a>
                        </div>
                    </div>

                    {{-- menu eksport data kategori ke PDF, EXCEL, dan Cetak --}}
                    <div class="wordset">
                        <ul>

                            {{-- tombol eksport ke pdf --}}
                            <li>
                                <a href="{{ route('kategori.exportToPdf') }}">
                                    <img src="{{ asset('assets/icon/pdf.svg') }}" alt="img" />
                                </a>
                            </li>

                            {{-- tombol eksport ke excel --}}
                            <li>
                                <a href="#">
                                    <img src="{{ asset('assets/icon/excel.svg') }}" alt="img" />
                                </a>
                            </li>

                            {{-- tombol cetak --}}
                            <li>
                                <a href="#">
                                    <img src="{{ asset('assets/icon/printer.svg') }}" alt="img" />
                                </a>
                            </li>

                        </ul>
                    </div>
                </div>

                <div class="table-responsive">

                    {{-- tabel daftar kategori barang --}}
                    <table class="table datanew">

                        {{-- judul kolom tabel --}}
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Kode</th>
                                <th>Nama Kategori</th>
                                <th>Keterangan</th>
                                <th>Dibuat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        {{-- isi tabel --}}
                        <tbody>

                            {{-- tampilkan semua data kategori satu persatu menggunakan perulangan foreach --}}
                            @foreach ($kategoris as $kategori)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $kategori->kode_kategori }}</td>
                                    <td>{{ $kategori->nama_kategori }}</td>
                                    <td>{{ $kategori->deskripsi }}</td>
                                    <td>{{ $kategori->created_at }}</td>
                                    <td>
                                        {{-- tombol edit kategori --}}
                                        <a class="me-3" href="{{ route('kategori.edit', $kategori) }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        {{-- tombol hapus kategori --}}
                                        <form action="{{ route('kategori.destroy', $kategori) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="confirm-text btn p-0 m-0"
                                                onclick="return confirm('Kategori: {{ $kategori->nama_kategori }} memiliki barang terkait. Yakin ingin dihapus?')">
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

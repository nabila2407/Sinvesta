{{-- ? Panggil file main.blade.php yang ada difolder dashboard/layout --}}
@extends('dashboard.layout.main')

{{-- ? Tulis kode HTML untuk halaman index user diantara @section --}}
@section('konten')

    {{-- ! konten utama halaman dashboard ditulis disini --}}

    <div class="page-header">
        {{-- judul halaman --}}
        <div class="page-title">
            <h4>Daftar Barang</h4>
            <h6>Lihat atau cari barang inventaris</h6>
        </div>
        {{-- tombol tambah barang baru --}}
        <div class="page-btn">
            <a href="{{ route('barang.create') }}" class="btn btn-added">
                <i class="bi bi-plus-circle"></i>Tambah Barang
            </a>
        </div>
    </div>

    {{-- card list barang --}}
    <div class="card">
        <div class="card-body">
            <div class="table-top">

                {{-- kolom pencarian --}}
                <div class="search-set">
                    <div class="search-input">
                        <a class="btn btn-searchset"><i class="bi bi-search"></i></a>
                    </div>
                </div>

                {{-- menu ekspor barang --}}
                <div class="wordset">
                    <ul>

                        {{-- tombol ekspor pdf --}}
                        <li>
                            <a href="#">
                                <img src="{{ asset('assets/icon/pdf.svg') }}" alt="img" />
                            </a>
                        </li>

                        {{-- tombol ekspor excel --}}
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

            {{-- form filter data --}}
            <form action="{{ route('barang.index') }}" method="GET">
                <div class="row">

                    {{-- kolom filter berdasarkan kategori --}}
                    <div class="col-lg-4 col-6 mb-3">
                        <select class="select2 placeholder form-control" id="kategori_id" name="kategori">
                            <option value="">Semua Kategori</option>
                            @forelse ($kategoris as $kategori)
                                <option value="{{ $kategori->id }}"
                                    {{ request('kategori') == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->nama_kategori }}</option>
                            @empty
                                <option>Data Kategori Tidak Ditemukan!</option>
                            @endforelse
                        </select>
                    </div>

                    {{-- kolom filter berdasarkan lokasi --}}
                    <div class="col-lg-4 col-6 mb-3">
                        <select class="select2 placeholder form-control" id="lokasi_id" name="lokasi">
                            <option value="">Semua Lokasi</option>
                            @forelse ($lokasis as $lokasi)
                                <option value="{{ $lokasi->id }}"
                                    {{ request('lokasi') == $lokasi->id ? 'selected' : '' }}>
                                    {{ $lokasi->nama_lokasi }}</option>
                            @empty
                                <option>Data Lokasi Tidak Ditemukan!</option>
                            @endforelse
                        </select>
                    </div>

                    {{-- kolom filter bersarakan status --}}
                    <div class="col-lg-2 col-6 mb-3">
                        <select class="select2 placeholder form-control" id="status" name="status">
                            <option value="">Semua Status</option>
                            <option value="Baik" {{ request('status') == 'Baik' ? 'selected' : '' }}>
                                Baik
                            </option>
                            <option value="Rusak Ringan" {{ request('status') == 'Rusak Ringan' ? 'selected' : '' }}>
                                Rusak Ringan
                            </option>
                            <option value="Rusak Berat" {{ request('status') == 'Rusak Berat' ? 'selected' : '' }}>
                                Rusak Berat
                            </option>
                            <option value="Hilang" {{ request('status') == 'Hilang' ? 'selected' : '' }}>
                                Hilang
                            </option>
                        </select>
                    </div>

                    {{-- tombol filter --}}
                    <div class="col-lg-2 col-6 mb-3">

                        {{-- tombol cari data berdasarkan filter yang dipilih --}}
                        <button class="btn btn-warning" type="submit"><i class="bi bi-funnel"></i></button>

                        {{-- jika ada request filter data --}}
                        @if (request('kategori') || request('lokasi') || request('status'))
                            {{-- tombol hapus semua filter data --}}
                            <a href="{{ route('barang.index') }}" class="btn btn-danger">
                                <i class="bi bi-x-lg"></i>
                            </a>
                        @endif

                    </div>
                </div>
            </form>
            {{-- form filter sampe sini --}}

            {{-- jika data barang tidak ada di database --}}
            @if ($barang->isEmpty())
                {{-- tampilkan informasi --}}
                <div class="alert alert-info" role="alert">
                    Tidak ada barang tersedia.
                </div>

            {{-- jika data barang ada didatabase --}}
            @else
                {{-- tampilkan tabel list barang --}}
                <div class="table-responsive">
                    <table class="table datanew">

                        {{-- judul kolom --}}
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Kode</th>
                                <th>Nama Barang</th>
                                <th>Kategori</th>
                                <th>Lokasi</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        {{-- isi table --}}
                        <tbody>

                            {{-- ? tampilan semua data barang satu persatu menggunakan perulangan --}}
                            @foreach ($barangs as $barang)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $barang->kode_barang }}</td>
                                    <td>{{ $barang->nama_barang }}</td>
                                    <td>{{ $barang->kategori->nama_kategori }}</td>
                                    <td>{{ $barang->lokasi->nama_lokasi }}</td>
                                    <td>
                                        @if ($barang->status_barang == 'Baik')
                                            <span class="btn btn-sm text-white bg-success">{{ $barang->status_barang }}</span>
                                        @elseif ($barang->status_barang == 'Rusak Ringan')
                                            <span class="btn btn-sm text-white bg-warning">{{ $barang->status_barang }}</span>
                                        @elseif ($barang->status_barang == 'Rusak Berat')
                                            <span class="btn btn-sm text-white bg-danger">{{ $barang->status_barang }}</span>
                                        @else
                                            <span class="btn btn-sm text-white bg-secondary">{{ $barang->status_barang }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{-- tombol lihat detail barang --}}
                                        <a class="me-3" href="{{ route('barang.show', $barang) }}">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        {{-- tombol edit barang --}}
                                        <a class="me-3" href="{{ route('barang.edit', $barang) }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        {{-- tombol hapus barang --}}
                                        <form action="{{ route('barang.destroy', $barang) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="confirm-text btn p-0 m-0"
                                                onclick="return confirm('Yakin ingin menghapus barang {{ $barang->nama_barang }}?')">
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

{{-- tambahkan javascript untuk library select2 --}}
@section('js')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                allowClear: true,
                width: '100%'
            });
        });
    </script>
@endsection    

{{-- ? Panggil file main.blade.php yang ada difolder dashboard/layout --}}
@extends('dashboard.layout.main')

{{-- ? Tulis kode HTML untuk halaman index bast diantara @section --}}
@section('konten')

    {{-- ! konten utama halaman dashboard ditulis disini --}}
    <div class="page-header">

        {{-- judul halaman --}}
        <div class="page-title">
            <h4>Daftar Berita Acara Serah Terima</h4>
            <h6>Lihat atau cari berita acara serah terima</h6>
        </div>

        {{-- tombol buat berita acara --}}
        <div class="page-btn">
            <a href="{{ route('bast.create') }}" class="btn btn-added">
                <i class="bi bi-plus-circle"></i>Buat Berita Acara
            </a>
        </div>

    </div>

    {{-- card list berita acara --}}
    <div class="card">
        <div class="card-body">
            <div class="table-top">

                {{-- kolom pencarian --}}
                <div class="search-set">
                    <div class="search-input">
                        <a class="btn btn-searchset"><i class="bi bi-search"></i></a>
                    </div>
                </div>

                {{-- menu ekspor data --}}
                <div class="wordset">
                    <ul>
                        {{-- ekspor ke PDF --}}
                        <li>
                            <a href="#">
                                <img src="{{ asset('assets/icon/pdf.svg') }}" alt="img" />
                            </a>
                        </li>

                        {{-- ekspor ke Excel --}}
                        <li>
                            <a href="#">
                                <img src="{{ asset('assets/icon/excel.svg') }}" alt="img" />
                            </a>
                        </li>

                        {{-- print --}}
                        <li>
                            <a href="#">
                                <img src="{{ asset('assets/icon/printer.svg') }}" alt="img" />
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- form filter data --}}
            <form action="{{ route('bast.index') }}" method="GET">
                <div class="row">

                    {{-- kolom filter data berdasarkan kategori --}}
                    <div class="col-lg-3 col-6 mb-3">
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

                    {{-- kolom filter data berdasarkan lokasi --}}
                    <div class="col-lg-3 col-6 mb-3">
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

                    {{-- kolom filter data berdasarkan status barang --}}
                    <div class="col-lg-2 col-6 mb-3">
                        <select class="select2 placeholder form-control" id="status_barang" name="status_barang">
                            <option value="">Semua Status Barang</option>
                            <option value="Baik" {{ request('status_barang') == 'Baik' ? 'selected' : '' }}>
                                Baik
                            </option>
                            <option value="Rusak Ringan" {{ request('status_barang') == 'Rusak Ringan' ? 'selected' : '' }}>
                                Rusak Ringan
                            </option>
                            <option value="Rusak Berat" {{ request('status_barang') == 'Rusak Berat' ? 'selected' : '' }}>
                                Rusak Berat
                            </option>
                            <option value="Hilang" {{ request('status_barang') == 'Hilang' ? 'selected' : '' }}>
                                Hilang
                            </option>
                        </select>
                    </div>

                    {{-- kolom filter data berdasarkan status bast --}}
                    <div class="col-lg-2 col-6 mb-3">
                        <select class="select2 placeholder form-control" id="status_bast" name="status_bast">
                            <option value="">Semua Status BAST</option>
                            <option value="Disetujui" {{ request('status_bast') == 'Disetujui' ? 'selected' : '' }}>
                                Disetujui
                            </option>
                            <option value="Menunggu" {{ request('status_bast') == 'Menunggu' ? 'selected' : '' }}>
                                Menunggu
                            </option>
                        </select>
                    </div>

                    {{-- tombol filter data --}}
                    <div class="col-lg-2 col-6 mb-3">
                        <button class="btn btn-warning" type="submit"><i class="bi bi-funnel"></i></button>

                        {{-- jika ada request filter --}}
                        @if (request('kategori') || request('lokasi') || request('status_barang') || request('status_bast'))
                            <a href="{{ route('bast.index') }}" class="btn btn-danger">
                                <i class="bi bi-x-lg"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </form>
            {{-- akhir form filter data --}}

            {{-- jika data berita acara tidak ada didatabase --}}
            @if ($basts->isEmpty())
                {{-- tampilkan informasi --}}
                <div class="alert alert-info" role="alert">
                    Tidak ada berita acara tersedia.
                </div>
            {{-- jika data berita acara ada didatabase --}}
            @else
                {{-- tampilkan dalam table --}}
                <div class="table-responsive">
                    <table class="table datanew">
                        {{-- judul tabel --}}
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Barang</th>
                                <th>Kategori Barang</th>
                                <th>Lokasi Barang</th>
                                <th>Status Barang</th>
                                <th>Penyerah</th>
                                <th>Penerima</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        {{-- isi tabel --}}
                        <tbody>
                            {{-- tampilan bast satu persatu menggunakan perulangan --}}
                            @foreach ($basts as $bast)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $bast->barang->nama_barang }}</td>
                                    <td>{{ $bast->barang->kategori->nama_kategori }}</td>
                                    <td>{{ $bast->barang->lokasi->nama_lokasi }}</td>
                                    <td>
                                        @if ($bast->barang->status_barang == "Baik")
                                            <span class="btn btn-sm btn-success">Baik</span>
                                        @elseif ($bast->barang->status_barang == "Rusak Ringan")
                                            <span class="btn btn-sm btn-warning">Rusak Ringan</span>
                                        @elseif ($bast->barang->status_barang == "Rusak Berat")
                                            <span class="btn btn-sm btn-danger">Rusak Berat</span>
                                        @else
                                            <span class="btn btn-sm btn-dark">Hilang</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($bast->status_serah == "Menunggu")
                                            <span class="btn btn-sm text-white bg-secondary"><i class="bi bi-hourglass-split"></i></span>
                                        @else
                                            <span class="btn btn-sm text-white bg-success"><i class="bi bi-check-circle"></i></span>
                                        @endif
                                        <span class="ms-2">{{ $bast->userSerah->nama_lengkap }}</span>
                                    </td>
                                    <td>
                                        @if ($bast->status_terima == "Menunggu")
                                            <span class="btn btn-sm text-white bg-secondary"><i class="bi bi-hourglass-split"></i></span>
                                        @else
                                            <span class="btn btn-sm text-white bg-success"><i class="bi bi-check-circle"></i></span>
                                        @endif
                                        <span class="ms-2">{{ $bast->userTerima->nama_lengkap }}</span>
                                    </td>
                                    <td>
                                        {{-- tombol download dokumen berita acara --}}
                                        <a class="me-3" href="#">
                                            <i class="bi bi-download"></i>
                                        </a>

                                        {{-- tombol lihat detail berita acara --}}
                                        <a class="me-3" href="{{ route('bast.show', $bast) }}">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        {{-- tombol edit berita acara --}}
                                        <a class="me-3" href="{{ route('bast.edit', $bast) }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        
                                        {{-- tombol hapus berita acara --}}
                                        <form action="{{ route('bast.destroy', $bast) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="confirm-text btn p-0 m-0"
                                                onclick="return confirm('Yakin ingin menghapus berita acara ini?')">
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
</div>
@endsection

{{-- ? Tulis kode JS di bawah ini --}}
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

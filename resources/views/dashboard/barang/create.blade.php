{{-- ? Panggil file main.blade.php yang ada difolder dashboard/layout --}}
@extends('dashboard.layout.main')

{{-- ? Tulis kode HTML untuk halaman index user diantara @section --}}
@section('konten')

    {{-- ! konten utama halaman dashboard ditulis disini --}}

    <div class="page-header">
        {{-- judul halaman --}}
        <div class="page-title">
            <h4>Tambah Barang</h4>
            <h6>Buat Data Barang Baru</h6>
        </div>
    </div>

    {{-- card form tambah barang baru --}}
    <div class="card">
        <div class="card-body">

            {{-- form tambah barang baru --}}
            <form action="{{ route('barang.store') }}" method="POST">

                {{-- csrf untuk keamanan form --}}
                @csrf

                <div class="row">

                    {{-- kolom nama barang --}}
                    <div class="col-12">
                        <div class="form-group">
                            <label for="nama_barang">Nama Barang *</label>
                            <input 
                                type="text" 
                                class="form-control @error('nama_barang') is-invalid @enderror" 
                                id="nama_barang" 
                                name="nama_barang" 
                                value="{{ old('nama_barang') }}"
                            />
                            {{-- jika kolom nama tidak valid --}}
                            @error('nama_barang')
                                {{-- tampilkan pesan error --}}
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- kolom kode barang --}}
                    <div class="col-lg-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label for="kode_barang">Kode Barang *</label>
                            <input 
                                type="text" 
                                class="form-control @error('kode_barang') is-invalid @enderror" 
                                id="kode_barang" 
                                name="kode_barang" 
                                value="{{ old('kode_barang') }}"
                            />
                            {{-- jika kode barang tidak valid --}}
                            @error('kode_barang')
                                {{-- tampilkan pesan error --}}
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- kolom kategori barang --}}
                    <div class="col-lg-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label for="kategori_id">Kategori *</label>
                            <select 
                                class="select2 placeholder form-control @error('kategori_id') is-invalid @enderror" 
                                id="kategori_id" 
                                name="kategori_id">
                                <option>Pilih Kategori...</option>
                                {{-- ? tampilkan semua kategori satu persatu menggunakan perulangan --}}
                                @forelse ($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                        {{ $kategori->nama_kategori }}
                                    </option>
                                {{-- ? jika data kategori tidak ada didatabase --}}
                                @empty
                                    {{-- tampilkan informasi --}}
                                    <option>Data Kategori Tidak Ditemukan!</option>
                                @endforelse
                            </select>
                            {{-- jika kategori yang dipilih tidak valid --}}
                            @error('kategori_id')
                                {{-- tampilkan pesan error --}}
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- kolom lokasi barang --}}
                    <div class="col-lg-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label for="lokasi_id">Lokasi *</label>
                            <select 
                                class="select2 placeholder form-control @error('lokasi_id') is-invalid @enderror" 
                                id="lokasi_id" 
                                name="lokasi_id">
                                <option>Pilih Lokasi...</option>
                                {{-- ? tampilkan semua data lokasi satu persatu menggunakan perulangan --}}
                                @forelse ($lokasis as $lokasi)
                                    <option value="{{ $lokasi->id }}" {{ old('lokasi_id') == $lokasi->id ? 'selected' : '' }}>
                                        {{ $lokasi->nama_lokasi }}
                                    </option>
                                {{-- ? jika data lokasi tidak ada di database --}}
                                @empty
                                    {{-- tampilkan informasi --}}
                                    <option>Data Lokasi Tidak Ditemukan!</option>
                                @endforelse
                            </select>
                            {{-- jika lokasi yang dipilih tidak valid --}}
                            @error('lokasi_id')
                                {{-- tampilkan pesan error --}}
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- kolom status barang --}}
                    <div class="col-lg-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label for="status">Status Barang: *</label>
                            <div class="form-check form-check-inline">
                                <input 
                                    class="form-check-input" 
                                    type="radio" 
                                    name="status_barang" 
                                    id="status_baik" 
                                    value="Baik" 
                                    {{ old('status_barang') == 'Baik' ? 'checked' : '' }}
                                >
                                <label class="form-check-label" for="status_baik">Baik</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input 
                                    class="form-check-input" 
                                    type="radio" 
                                    name="status_barang" 
                                    id="status_rusak_ringan" 
                                    value="Rusak Ringan" 
                                    {{ old('status_barang') == 'Rusak Ringan' ? 'checked' : '' }}
                                >
                                <label class="form-check-label" for="status_rusak_ringan">Rusak Ringan</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input 
                                    class="form-check-input" 
                                    type="radio" 
                                    name="status_barang" 
                                    id="status_rusak_berat" 
                                    value="Rusak Berat" 
                                    {{ old('status_barang') == 'Rusak Berat' ? 'checked' : '' }}
                                >
                                <label class="form-check-label" for="status_rusak_berat">Rusak Berat</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input 
                                    class="form-check-input" 
                                    type="radio" 
                                    name="status_barang" 
                                    id="status_hilang" 
                                    value="Hilang" 
                                    {{ old('status_barang') == 'Hilang' ? 'checked' : '' }}
                                >
                                <label class="form-check-label" for="status_hilang">Hilang</label>
                            </div>
                            {{-- jika status barang yang dipilih tidak valid --}}
                            @error('status_barang')
                                {{-- tampilkan pesan error --}}
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- kolom deskripsi --}}
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea 
                                class="form-control @error('deskripsi') is-invalid @enderror" 
                                id="deskripsi" 
                                name="deskripsi">{{ old('deskripsi') }}</textarea>
                            {{-- jika kolom deskripsi tidak valid --}}
                            @error('deskripsi')
                                {{-- tampilkan pesan error --}}
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <button type="submit" class="btn btn-submit me-2">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

{{-- javascript untuk library select2 --}}
@section('js')
    <script>
        $(document).ready(function () {
            $('.select2').select2({
                placeholder: "Cari barang...",
                allowClear: true,
                width: '100%'
            });
        });
    </script>
@endsection
{{-- ? Panggil file main.blade.php yang ada difolder dashboard/layout --}}
@extends('dashboard.layout.main')

{{-- ? Tulis kode HTML untuk halaman index user diantara @section --}}
@section('konten')

    {{-- ! konten utama halaman dashboard ditulis disini --}}

    {{-- judul halaman --}}
    <div class="page-header">
        <div class="page-title">
            <h4>Tambah Lokasi Barang</h4>
            <h6>Tambahkan Data Lokasi Barang Baru</h6>
        </div>
    </div>

    {{-- card form tambah data --}}
    <div class="card">
        <div class="card-body">

            {{-- form tambah data lokasi --}}
            <form action="{{ route('lokasi.store') }}" method="POST">

                {{-- csrf untuk keamanan form --}}
                @csrf

                <div class="row">

                    {{-- kolom kode lokasi --}}
                    <div class="col-lg-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label for="kode_lokasi">Kode Lokasi *</label>
                            <input
                                type="text"
                                class="form-control @error('kode_lokasi') is-invalid @enderror"
                                id="kode_lokasi"
                                name="kode_lokasi"
                                value="{{ old('kode_lokasi') }}"
                            />
                            {{-- jika kolom kode lokasi tidak valid --}}
                            @error('kode_lokasi')
                                {{-- tampilkan pesan error --}}
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- kolom nama lokasi --}}
                    <div class="col-lg-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label for="nama_lokasi">Nama Lokasi *</label>
                            <input
                                type="text"
                                class="form-control @error('nama_lokasi') is-invalid @enderror"
                                id="nama_lokasi"
                                name="nama_lokasi"
                                value="{{ old('nama_lokasi') }}"
                            />
                            {{-- jika kolom nama lokasi tidak valid --}}
                            @error('nama_lokasi')
                                {{-- tampilkan pesan error --}}
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- kolom deskripsi lokasi --}}
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

                    {{-- tombol simpan data --}}
                    <div class="col-lg-12">
                        <button type="submit" class="btn btn-submit me-2">Simpan</button>
                    </div>

                </div>
            </form>
        </div>
    </div>
@endsection                    
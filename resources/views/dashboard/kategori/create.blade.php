{{-- ? Panggil file main.blade.php yang ada difolder dashboard/layout --}}
@extends('dashboard.layout.main')

{{-- ? Tulis kode HTML untuk halaman index user diantara @section --}}
@section('konten')

    {{-- ! konten utama halaman dashboard ditulis disini --}}

    {{-- judul kategori --}}
    <div class="page-header">
        <div class="page-title">
            <h4>Tambah Kategori Barang</h4>
            <h6>Buat Kategori Barang Baru</h6>
        </div>
    </div>

    {{-- card form tambah data --}}
    <div class="card">
        <div class="card-body">

            {{-- form tambah data kategori --}}
            <form action="{{ route('kategori.store') }}" method="POST">

                {{-- csrf untuk keamanan form --}}
                @csrf

                <div class="row">

                    {{-- kolom kode kategori --}}
                    <div class="col-lg-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label for="kode_kategori">Kode Kategori *</label>
                            <input 
                                type="text" 
                                class="form-control @error('kode_kategori') is-invalid @enderror"
                                id="kode_kategori" 
                                name="kode_kategori" 
                                value="{{ old('kode_kategori') }}" 
                            />
                            {{-- jika kolom kode kategori tidak valid --}}
                            @error('kode_kategori')
                                {{-- tampilkan pesan error --}}
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- kolom nama kategori --}}
                    <div class="col-lg-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label for="nama_kategori">Nama Kategori *</label>
                            <input 
                                type="text" 
                                class="form-control @error('nama_kategori') is-invalid @enderror"
                                id="nama_kategori" 
                                name="nama_kategori" 
                                value="{{ old('nama_kategori') }}" 
                            />
                            {{-- jika kolom nama kategori tidak valid --}}
                            @error('nama_kategori')
                                {{-- tampilkan pesan error --}}
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    {{-- kolom deskripsi kategori --}}
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

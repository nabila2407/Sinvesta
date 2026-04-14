{{-- ? Panggil file main.blade.php yang ada difolder dashboard/layout --}}
@extends('dashboard.layout.main')

{{-- ? Tulis kode HTML untuk halaman index user diantara @section --}}
@section('konten')

    {{-- ! konten utama halaman dashboard ditulis disini --}}

    {{-- judul halaman --}}
    <div class="page-header">
        <div class="page-title">
            <h4>Edit Lokasi Barang</h4>
            <h6>Perbarui Data Lokasi Barang</h6>
        </div>
    </div>

    {{-- card form edit data --}}
    <div class="card">
        <div class="card-body">

            {{-- form edit data lokasi --}}
            <form action="{{ route('lokasi.update', $lokasi) }}" method="POST">

                {{-- csrf untuk keamanan form --}}
                @csrf

                {{-- ubah method POST -> PUT --}}
                @method('put')

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
                                value="{{ old('kode_lokasi', $lokasi->kode_lokasi) }}" 
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
                            <label for="nama_lokasi">nama Lokasi *</label>
                            <input 
                                type="text" 
                                class="form-control @error('nama_lokasi') is-invalid @enderror" 
                                id="nama_lokasi" 
                                name="nama_lokasi" 
                                value="{{ old('nama_lokasi', $lokasi->nama_lokasi) }}" 
                            />
                            {{-- jika kolom nama lokasi tidak valid --}}
                            @error('nama_lokasi')
                                {{-- tampilkan pesan error --}}
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- kolom deskripsi lokasi --}}
                    <div class="col-lg-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea 
                                class="form-control @error('deskripsi') is-invalid @enderror" 
                                id="deskripsi" 
                                name="deskripsi">{{ old('deskripsi', $lokasi->deskripsi) }}</textarea>  
                            {{-- jika kolom deskripsi lokasi tidak valid --}}
                            @error('deskripsi')
                                {{-- tampilkan pesan error --}}
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- tombol siap data --}}
                    <div class="col-lg-12">
                        <button type="submit" class="btn btn-submit me-2">Simpan</button>
                    </div>

                </div>
            </form>
        </div>
    </div>
@endsection                    
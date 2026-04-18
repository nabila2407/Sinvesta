{{-- ? Panggil file main.blade.php yang ada difolder dashboard/layout --}}
@extends('dashboard.layout.main')

{{-- ? Tulis kode HTML untuk halaman create bast diantara @section --}}
@section('konten')

    {{-- ! konten utama halaman dashboard ditulis disini --}}
    <div class="page-header">
        {{-- judul halaman --}}
        <div class="page-title">
            <h4>Berita Acara Serah Terima</h4>
            <h6>Buat Berita Acara Baru</h6>
        </div>
    </div>

    {{-- card form buat berita acara --}}
    <div class="card">
        <div class="card-body">

            {{-- form buat berita acara --}}
            <form action="{{ route('bast.store') }}" method="POST">
                {{-- token untuk proteksi form dari CSRF (Cross Site Request Forgery) --}}
                @csrf

                <div class="row">
                    <div class="col-lg-8 col-12">
                        {{-- kolom pencarian barang --}}
                        <div class="form-group">
                            <label for="barang_id">Barang Inventaris *</label>
                            <select
                                class="form-control select2 @error('barang_id') is-invalid @enderror"
                                id="barang_id"
                                name="barang_id">
                                <option placeholder>Pilih Barang...</option>
                                @forelse ($barangs as $barang)
                                    <option value="{{ $barang->id }}" {{ old('barang_id') == $barang->id ? 'selected' : '' }}>
                                        {{ $barang->nama_barang }}
                                    </option>
                                @empty
                                    <option>Data Barang Tidak Ditemukan!</option>
                                @endforelse
                            </select>
                            @error('barang_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- kolom user penyerah --}}
                    <div class="col-lg-6 col-cm-6 col-12">
                        <div class="form-group">
                            <label for="user_serah_id">Penyerah *</label>
                            <select 
                                class="select2 form-control @error('user_serah_id') is-invalid @enderror"
                                id="user_serah_id"
                                name="user_serah_id">
                                <option>Pilih Penyerah...</option>
                                @forelse ($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_serah_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->nama_lengkap }}
                                    </option>
                                @empty
                                    <option>Data Kategori Tidak Ditemukan!</option>
                                @endforelse
                            </select>
                            @error('user_serah_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- kolom status penyerah --}}
                    <div class="col-lg-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label for="status_serah">Status Serah: *</label>
                            <div class="form-check form-check-inline">
                                <input 
                                    class="form-check-input" 
                                    type="radio" 
                                    name="status_serah" 
                                    id="status_menunggu1" 
                                    value="Menunggu" {{ old('status_serah') == 'Menunggu' ? 'checked' : '' }}>
                                <label class="form-check-label" for="status_menunggu1">
                                    <span class="btn btn-secondary">Menunggu</span>
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input 
                                    class="form-check-input" 
                                    type="radio" 
                                    name="status_serah" 
                                    id="status_disetujui1" 
                                    value="Disetujui" {{ old('status_serah') == 'Disetujui' ? 'checked' : '' }}>
                                <label class="form-check-label" for="status_disetujui1">
                                    <span class="btn btn-success">Disetujui</span>
                                </label>
                            </div>
                            @error('status_serah')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- kolom user penerima --}}
                    <div class="col-lg-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label for="user_terima_id">Penerima *</label>
                            <select 
                                class="select2 form-control @error('user_terima_id') is-invalid @enderror"
                                id="user_terima_id"
                                name="user_terima_id">
                                <option>Pilih Penerima...</option>
                                @forelse ($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_terima_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->nama_lengkap }}
                                    </option>
                                @empty
                                    <option>Data Kategori Tidak Ditemukan!</option>
                                @endforelse
                            </select>
                            @error('user_terima_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- kolom status penerima --}}
                    <div class="col-lg-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label for="status_terima">Status Terima: *</label>
                            <div class="form-check form-check-inline">
                                <input 
                                    class="form-check-input" 
                                    type="radio" 
                                    name="status_terima" 
                                    id="status_menunggu2" 
                                    value="Menunggu" {{ old('status_terima') == 'Menunggu' ? 'checked' : '' }}>
                                <label class="form-check-label" for="status_menunggu2">
                                    <span class="btn btn-secondary">Menunggu</span>
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input 
                                    class="form-check-input" 
                                    type="radio" 
                                    name="status_terima" 
                                    id="status_disetujui2" 
                                    value="Disetujui" {{ old('status_terima') == 'Disetujui' ? 'checked' : '' }}>
                                <label class="form-check-label" for="status_disetujui2">
                                    <span class="btn btn-success">Disetujui</span>
                                </label>
                            </div>
                            @error('status_terima')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- tombol simpan --}}
                    <div class="col-lg-12">
                        <button type="submit" class="btn btn-submit me-2">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

{{-- ? Tulis kode JavaScript untuk halaman craete bast diantara @section --}}
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
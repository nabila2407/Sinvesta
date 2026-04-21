@extends('dashboard.layout.main')

@section('konten')
    <div class="page-header">
        <div class="page-title">
            <h4>Berita Acara Serah Terima</h4>
            <h6>Edit Berita Acara</h6>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('bast.update', $bast) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    {{-- 1. Baris Barang Inventaris --}}
                    <div class="col-lg-12 mb-3">
                        <div class="form-group">
                            <label for="barang_id">Barang Inventaris *</label>
                            <select class="form-control select2 @error('barang_id') is-invalid @enderror" id="barang_id" name="barang_id">
                                <option value="">Pilih Barang...</option>
                                @foreach ($barangs as $barang)
                                    <option value="{{ $barang->id }}" {{ old('barang_id', $bast->barang_id) == $barang->id ? 'selected' : '' }}>
                                        {{ $barang->nama_barang }}
                                    </option>
                                @endforeach
                            </select>
                            @error('barang_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- 2. Baris Penyerah & Statusnya --}}
                    <div class="col-lg-8 col-md-7">
                        <div class="form-group">
                            <label for="user_serah_id">Penyerah *</label>
                            <select class="select2 form-control @error('user_serah_id') is-invalid @enderror" id="user_serah_id" name="user_serah_id">
                                <option value="">Pilih Penyerah...</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_serah_id', $bast->user_serah_id) == $user->id ? 'selected' : '' }}>
                                        {{ $user->nama_lengkap }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-5">
                        <div class="form-group">
                            <label>Status Serah: *</label>
                            <div class="d-flex align-items-center pt-2">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status_serah" id="serah_m" value="Menunggu" {{ old('status_serah', $bast->status_serah) == 'Menunggu' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="serah_m"><span class="btn btn-sm btn-secondary">Menunggu</span></label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status_serah" id="serah_d" value="Disetujui" {{ old('status_serah', $bast->status_serah) == 'Disetujui' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="serah_d"><span class="btn btn-sm btn-success">Disetujui</span></label>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- 3. Baris Penerima & Statusnya --}}
                    <div class="col-lg-8 col-md-7">
                        <div class="form-group">
                            <label for="user_terima_id">Penerima *</label>
                            <select class="select2 form-control @error('user_terima_id') is-invalid @enderror" id="user_terima_id" name="user_terima_id">
                                <option value="">Pilih Penerima...</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_terima_id', $bast->user_terima_id) == $user->id ? 'selected' : '' }}>
                                        {{ $user->nama_lengkap }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-5">
                        <div class="form-group">
                            <label>Status Terima: *</label>
                            <div class="d-flex align-items-center pt-2">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status_terima" id="terima_m" value="Menunggu" {{ old('status_terima', $bast->status_terima) == 'Menunggu' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="terima_m"><span class="btn btn-sm btn-secondary">Menunggu</span></label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status_terima" id="terima_d" value="Disetujui" {{ old('status_terima', $bast->status_terima) == 'Disetujui' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="terima_d"><span class="btn btn-sm btn-success">Disetujui</span></label>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Tombol Submit --}}
                    <div class="col-lg-12 mt-4">
                        <button type="submit" class="btn btn-submit me-2" style="background-color: #ff9f43; color: white;">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
<script>
    $(document).ready(function () {
        $('.select2').select2({
            width: '100%'
        });
    });
</script>
@endsection
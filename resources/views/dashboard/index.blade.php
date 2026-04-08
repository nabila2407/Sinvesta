{{-- ? @extends() digunakan untuk memanggil dashboard/layout/main.blade.php --}}
@extends('dashboard.layout.main')

{{-- 
? konten utama view halaman dashboard harus di tulis diantara @section('konten')
* 'konten' adalah nama dari @yield('konten') yang ada di file main.blade.php
--}}
@section('konten')
    {{-- ! konten utama halaman dashboard ditulis disini --}}
    <h6>Selamat Datang</h6>
    <h2 class="fw-bold mb-5">{{ Auth::user()->nama_lengkap }}</h2>

    {{-- Menampilkan jumlah data di database --}}
    <div class="row">

        {{-- card jumlah kategori --}}
        <div class="col-lg-3 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex gap-3">
                        {{-- icon kategori --}}
                        <div class="p-3 bg-warning rounded-3">
                            <i class="bi bi-card-list"></i>
                        </div>

                        {{-- jumlah data kategori --}}
                        <div>
                            <h4 class="fw-bold">{{ $jumlah_kategori }}</h4>
                            <div>Total Data Kategori</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- card jumlah lokasi --}}
        <div class="col-lg-3 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex gap-3">
                        {{-- icon lokasi --}}
                        <div class="p-3 bg-warning rounded-3">
                            <i class="bi bi-card-list"></i>
                        </div>

                        {{-- jumlah data lokasi --}}
                        <div>
                            <h4 class="fw-bold">{{ $jumlah_lokasi }}</h4>
                            <div>Total Data Lokasi</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- card jumlah barang --}}
        <div class="col-lg-3 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex gap-3">
                        {{-- icon barang --}}
                        <div class="p-3 bg-warning rounded-3">
                            <i class="bi bi-card-list"></i>
                        </div>

                        {{-- jumlah data barang --}}
                        <div>
                            <h4 class="fw-bold">{{ $jumlah_barang }}</h4>
                            <div>Total Data Barang</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- card jumlah bast --}}
        <div class="col-lg-3 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex gap-3">
                        {{-- icon bast --}}
                        <div class="p-3 bg-warning rounded-3">
                            <i class="bi bi-card-list"></i>
                        </div>

                        {{-- jumlah data bast --}}
                        <div>
                            <h4 class="fw-bold">{{ $jumlah_bast }}</h4>
                            <div>Total Data BAST</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    
@endsection

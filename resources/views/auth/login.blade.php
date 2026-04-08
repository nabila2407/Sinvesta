{{-- 
? @extends() digunakan untuk memanggil auth/layout/main.blade.php
* jika penamaan folder dan file yang dipanggil tidak sama, maka layouting tidak dapat berjalan 
--}}
@extends('auth.layout.main')

{{-- 
? konten utama view form login harus di tulis diantara @section('konten')
* 'konten' adalah nama dari @yield('konten') yang ada di file main.blade.php
--}}
@section('konten')

    {{-- ! konten utama halaman form login ditulis disini!! --}}
    <div class="col-12 col-lg-4 m-auto py-3 py-lg-5">


        {{-- ?jika ada sesion dengan nama 'berhasil' dikirim dari Controller --}}
        @session('berhasil')
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{-- ? tampilkan pesannya --}}
                {{ session('berhasil') }}
                <button type="button" class="btn-close" data-bs-dimiss="alert" aria-label="Close"></button>
            </div>
        @endsession 

        {{-- Judul Halaman Login --}}
        <span class="mb-0 fs-1">👋</span>
        <h1 class="fs-2">Masuk Ke SINVESTA!</h1>
        <p class="lead mb-4">Senang melihat Anda kembali, silahkan masuk menggunakan Akun Anda!</p>

        <hr>

        {{-- Form Login --}}
        <form action="{{ route('login.store') }}" method="POST">
             
            @csrf

            {{-- Username --}}
            <div class="mb-4">
                <label for="username" class="form-label">Username</label>
                <input 
                    type="text"
                    id="username"
                    class="form-control @error('username') is-invalid @enderror"
                    name="username"
                    placeholder="Masukan Username Anda!"
                />
                {{-- jika username tidak valid --}}
                @error('username')
                {{-- tampilkan pesan errornya --}}
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            {{-- Password --}}
            <div class="mb-4">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <input
                        type="password"
                        id="password"
                        class="pass-input form-control @error('password') is-invalid @enderror"
                        name="password"
                        placeholder="Masukan Password Anda!"
                    />
                    <span class="bi toggle-password bi-eye-slash input-group-text"></span>
                </div>
                {{-- jika password tidak valid --}}
                <div id="password" class="text-danger">
                    {{-- tampilkan pesan errornya --}}
                    @error('password') {{ $message }} @enderror
                </div>
            </div>

            <hr>

            {{-- Tombol Login --}}
            <div class="align-items-center mt-0">
                <div class="d-grid">
                    <button class="btn btn-primary mb-0" type="submit">Login</button>
                </div>
            </div>
        </form>
        {{-- Form Selesai --}}
        
        {{-- Link menuju halman daftar user --}}
        {{-- <div class="mt-4 text-center">
            <span>Belum punya akun? <a href="">Daftar</a></span>
        </div> --}}
    </div>
@endsection          
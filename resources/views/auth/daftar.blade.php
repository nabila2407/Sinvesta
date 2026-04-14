{{-- 
? @extends() digunakan untuk memanggil auth/layout/main.blade.php
* jika penamaan folder dan file yang dipanggil tidak sama, maka layouting tidak dapat berjalan
--}}
@extends('auth.layout.main')

{{-- 
? konten utama view form login harus di tulis diantara @sextion('konten')
* 'konten' adalah nama dari @yield('konten') yang ada di file main.blade.php
--}}
@section('konten')
    {{-- ! konten utama halaman form pendaftran user ditulis disini!! --}}
    <div class="col-13 col-lg-5 m-auto py-3 py-lg-5">

        {{-- Judul halaman Daftarr --}}
        <span class="mb-0 fs-1">👋</span>
        <h1 class="fs-2">Daftar ke SINVIESTA!</h1>
        <p class="lead mb-4">Buat akun baru untuk mengakses sitem inventaris aset dan berita acara.</p>

        <hr>

        {{-- Formulir Pendaftaran --}}
        <form action="{{ route('daftar.store') }}" method="POST">

            {{-- CSRF Token untuk keamanan --}}
            @csrf

            {{-- Nama Lengkap --}}
            <div class="mb-4">
                <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                <input type="text" id="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror"
                    name="nama_lengkap" placeholder="Masukkan Nama Lengkap" value="{{ old('nama_lengkap') }}" autofocus />
                {{-- jika nama_lengkap tidak valid --}}
                @error('nama_lengkap')
                    <div id="nama_lengkap" class="invalid-feedback">
                        {{-- tampilkan pesan error --}}
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Username --}}
            <div class="mb-4">
                <label for="username" class="form-label">Username</label>
                <input type="text" id="username" class="form-control @error('username') is-invalid @enderror"
                    name="username" placeholder="Masukkkan Username" value="{{ old('username') }}" />
                {{-- jika usernmae tidak valid --}}
                @error('username')
                    <div id="username" class="invalid-feedback">
                        {{-- tampilkan pesan eror --}}
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Email --}}
            <div class="mb-4">
                <label for="email" class="form-label">email</label>
                <input type="text" id="email" class="form-control @error('email') is-invalid @enderror"
                    name="email" value="{{ old('email') }}" placeholder="Masukkan alamat emailmu" />
                {{-- jika usernmae tidak valid --}}
                @error('email')
                    <div id="email" class="invalid-feedback">
                        {{-- tampilkan pesan eror --}}
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Role --}}
            <div class="mb-4">
                <label class="d-block form-label">Daftar Sebagai:</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="role" id="role_admin" value="admin"
                        {{ old('role') == 'admin' ? 'checked' : '' }}> {{-- Cara lebih simpel --}}
                    <label class="form-check-label" for="role_admin">Admin</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="role" id="role_user" value="user"
                        @if (old('role' == 'user')) checked @endif />
                    <label class="form-check-label" for="role_user">User</label>
                </div>

                {{-- jika role tidak valid --}}
                @error('role')
                    <div id="role" class="text-danger">
                        {{-- tampilkan pesan error --}}
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Lembaga --}}
            <div class="mb-4">
                <label for="lembaga" class="form-label">Lembaga</label>
                <input type="text" id="lembaga" class="form-control @error('lembaga') is-invalid @enderror"
                    placeholder="Tata Usaha / Jurusan / Lainnya" name="lembaga" value="{{ old('lembaga') }}" />
                {{-- jika lembaga tidak valid --}}
                @error('lembaga')
                    <div id="lembaga" class="invalid-feedback">
                        {{-- tampilkan pesan error --}}
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Password --}}
            <div class="mb-4">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <input type="password" class="pass-input form-control @error('password') is-invalid @enderror"
                        name="password" id="password" />
                    <span class="bi toggle-password bi-eye-slash input-group-text"></span>
                </div>
                {{-- jika password tidak aktif --}}
                @error('password')
                    <div id="password" class="text-danger">
                        {{-- tampilkan pesan error --}}
                        {{ $message }}
                    </div>
                @enderror
            </div>
            {{-- Konfirmasi Password --}}
            <div class="mb-4">
                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                <div class="input-group">
                    <input type="password"
                        class="pass-input form-control @error('password_confirmation') is-invalid @enderror"
                        name="password_confirmation" id="password_confirmation" />
                    <span class="bi toggle-password bi-eye-slash input-group-text"></span>
                </div>
                {{-- jika password tidak valid --}}
                @error('password_confirmation')
                    <div id="password_confirmation" class="text-danger">
                        {{-- tampilkan pesan error --}}
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <hr>

            {{-- Tombol Daftar --}}
            <div class="align-items-center mt-0">
                <div class="d-grid">
                    <button class="btn btn-primary mb-0" type="submit">Daftar</button>
                </div>
            </div>
        </form>
        {{-- Form Pendaftaran Selesai --}}
        {{-- Link menuju halaman login --}}
        <div class="mt-4 text-center">
            <span>Sudah punya akun? <a href="{{ route('login') }}">Login</a></span>
        </div>
    </div>
@endsection

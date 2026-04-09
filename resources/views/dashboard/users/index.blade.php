{{-- ? Panggil file layout.blade.php yang ada difolder dashboard/layout --}}
@extends('dashboard.layout.main')

{{-- ? Tulis kode HTML untuk halaman index user diantara @section --}}
@section('konten')

    {{-- ! konten utama halaman dashboard ditulis disini --}}

    {{-- Judul Halaman --}}
    <div class="page-header">
        <div class="page-title">
            <h4>List Pengguna</h4>
            <h6>Lihat atau cari pengguna</h6>
        </div>

        {{-- tombol tambah user baru --}}
        <div class="page-btn">
            <a href="{{ route('users.create') }}" class="btn btn-added">
                <i class="bi bi-plus-circle"></i>Tambah Pengguna
            </a>
        </div>

    </div>

    {{-- card list pengguna --}}
    <div class="card">
        <div class="card-body">

            {{-- ! jika data user tidak ada di database --}}
            @if ($users->isEmpty())
                {{-- tampilkan informasi ini --}}
                <div class="alert alert-info" role="alert">
                    Tidak ada pengguna tersedia.
                </div>
            @else
                {{-- ! jika data user ada di database --}}
                <div class="table-top">

                    {{-- kolom pencarian --}}
                    <div class="search-set">
                        <div class="search-input">
                            <a class="btn btn-searchset"><i class="bi bi-search"></i></a>
                        </div>
                    </div>

                </div>

                {{-- tabel daftar user --}}
                <div class="table-responsive">
                    <table class="table datanew">

                        {{-- judul kolom --}}
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Lengkap</th>
                                <th>Username</th>
                                <th>Lembaga</th>
                                <th>Role</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        {{-- isi kolom --}}
                        <tbody>
                            {{-- tampilkan data user satu persatu menggunakan perulangan foreach --}}
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->nama_lengkap }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->lembaga }}</td>
                                    <td>{{ $user->role }}</td>
                                    <td>
                                        {{-- tombol edit user --}}
                                        <a class="me-3" href="{{ route('users.edit', $user) }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        {{-- tombol hapus user --}}
                                        <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button 
                                                type="submit" 
                                                class="confirm-text btn p-0 m-0"
                                                onclick="return confirm('Yakin ingin menghapus data user {{ $user->username }}?')">
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

@endsection

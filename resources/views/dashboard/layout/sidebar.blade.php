{{-- ? Bagian menu sidebar dashboard --}}
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">

        {{-- menu sidebar dimulai dari sini --}}
        <div id="sidebar-menu" class="sidebar-menu">

            {{-- jika user yang login adalah admin --}}
            @if (Auth::user()->role == 'admin')
                {{-- tampilkan menu khusus untuk admin --}}
                <ul>

                    {{-- Menu Halaman Dashboard --}}
                    <li class="{{ Request::is('dashboard') ? 'active' : '' }}">
                        <a href="{{ route('dashboard') }}">
                            <i class="bi bi-speedometer2"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    {{-- Menu Halaman Kategori Barang --}}
                    <li class="submenu">
                        <a href="#">
                            <i class="bi bi-card-list"></i>
                            <span>Kategori Barang</span>
                            <span class="ms-auto bi bi-caret-down"></span>
                        </a>
                        <ul>
                            <li>
                                <a  href="{{ route('kategori.index') }}"
                                    class="{{ Request::is('dashboard/kategori*') ? 'active' : '' }}">
                                    List Kategori
                                </a>
                            </li>
                            <li>
                                <a  href="{{ route('kategori.create') }}"
                                    class="{{ Request::is('dashboard/kategori/create') ? 'active' : '' }}">
                                    Tambah Kategori
                                </a>
                            </li>
                        </ul>
                    </li>

                    {{-- Menu Halaman Lokasi Barang --}}
                    <li class="submenu">
                        <a href="#">
                            <i class="bi bi-buildings"></i>
                            <span>Lokasi Barang</span>
                            <span class="ms-auto bi bi-caret-down"></span>
                        </a>
                        <ul>
                            <li><a href="#">List Lokasi</a></li>
                            <li><a href="#">Tambah Lokasi</a></li>
                        </ul>
                    </li>

                    {{-- Menu Halaman Barang --}}
                    <li class="submenu">
                        <a href="#">
                            <i class="bi bi-box-seam"></i>
                            <span>Barang</span>
                            <span class="ms-auto bi bi-caret-down"></span>
                        </a>
                        <ul>
                            <li><a href="#">List Barang</a></li>
                            <li><a href="#">Tambah Barang</a></li>
                        </ul>
                    </li>

                    {{-- Menu Halaman Barang --}}
                    <li class="submenu">
                        <a href="#">
                            <i class="bi bi-file-earmark-medical"></i>
                            <span>BAST</span>
                            <span class="ms-auto bi bi-caret-down"></span>
                        </a>
                        <ul>
                            <li><a href="#">List Berita Acara</a></li>
                            <li><a href="#">Tambah Berita Acara</a></li>
                        </ul>
                    </li>

                    {{-- Menu Halaman Pengguna --}}
                    <li class="submenu">
                        <a href="#">
                            <i class="bi bi-people"></i>
                            <span>Pengguna</span>
                            <span class="ms-auto bi bi-caret-down"></span>
                        </a>

                        <ul>
                            <li>
                                <a href="{{ route('users.index') }}" class="{{ Request::is('dashboard/users*') ? 'active' : '' }}">
                                    List Pengguna
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('users.create') }}" class="{{ Request::is('dashboard/users/create') ? 'active' : '' }}">
                                    Tambah Pengguna
                                </a>
                            </li>
                        </ul>    


                    {{-- jika user yang login adalah 'user' --}}
                    @else
                    {{-- tampilkan menu sidebar khusus untuk 'user' --}}
                    <ul>

                        {{-- Menu dashboard --}}
                        <li class="active">
                            <a href="#">
                                <i class="bi bi-speedometer2"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>

                        {{-- Menu halaman berita acara sebagai penyerah --}}
                        <li class="submenu">
                            <a href="#">
                                <i class="bi bi-person-down"></i>
                                <span>BAST Penyerah</span>
                                <span class="ms-auto bi bi-caret-down"></span>
                            </a>
                            <ul>
                                <li><a href="#">Menunggu Disetujui</a></li>
                                <li><a href="#">Riwayat BAST</a></li>
                            </ul>
                        </li>

                        {{-- Menu halaman berita acara sebagai penerima --}}
                        <li class="submenu">
                            <a href="#">
                                <i class="bi bi-person-up"></i>
                                <span>BAST Penerima</span>
                                <span class="ms-auto bi bi-caret-down"></span>
                            </a>
                            <ul>
                                <li><a href="#">Menunggu Disetujui</a></li>
                                <li><a href="Riwayat BAST"></a></li>
                            </ul>
                        </li>

                    </ul>
                </ul>
            @endif

        </div>
    </div>
</div>

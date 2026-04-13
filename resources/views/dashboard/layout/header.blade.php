{{-- ? Bagian header dashboard --}}
<div class="header">
    <div class="header-left">
        {{-- Logo Dashboard --}}
        <a href="{{ route('dashboard') }}" class="logo">
            <img src="{{ asset('assets/icon/logo.png') }}" alt="Sinvesta">
        </a>

        {{-- Logo Dashboard saat sidebar desembunyikan --}}
        <a href="{{ route('dashboard') }}" class="logo-small">
            <img src="{{ asset('assets/icon/favicon.png') }}" alt="Sinvesta">
        </a>

        {{-- Tombol Toggle muncul / Sembunyi --}}
        <a id="toggle_btn" href="#"> </a>
    </div>

    {{-- Tombol khusus untuk mobile --}}
    <a id="mobile_btn" class="mobile_btn" href="#sidebar">
        <span class="bar_icon">
            <span></span>
            <span></span>
            <span></span>
        </span>
    </a>

    {{-- Menu bagian kanan --}}
    <ul class="nav user-menu">

        {{-- alert pemberitahuan saat ada update data (store/update/delete) --}}
        @session('berhasil')
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('berhasil') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endsession

        {{-- Menu Profil --}}
        <li class="nav-item dropdown has-arrow min-drop">

            {{-- tombol toggle profil --}}
            <a href="#" class="dropdown-toggle nav-link userset" data-bs-toggle="dropdown">
                <span class="user.img">
                    <i class="bi bi-person-circle"></i>
                    <span class="status online"></span>
                </span>
            </a>

            {{-- menu profil user --}}
            <div class="dropdown-menu menu-drop-user">
                <div class="profilename">

                    {{-- menampilkan info user --}}
                    <div class="profileset">
                        <span class="user-img">
                            <i class="bi bi-person-circle"></i>
                            <span class="status online"></span>
                        </span>
                        <div class="profilesets">
                            <h6>{{ Auth::user()->username }}</h6>
                            <h5>{{ Auth::user()->role }}</h5>
                        </div>
                    </div>

                    <hr class="m-0" />

                    {{-- tombol edit profil --}}
                    <a class="dropdown-item" href="{{ route('users.edit', Auth::user()) }}">Profil Ku</a>

                    {{-- tombol logout --}}
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="dropdown-item logout pb-0" type="submit">Logout</button>
                    </form>

                </div>
            </div>
        </li>
    </ul>

    {{-- menu profil khusu untuk di mobile --}}
    <div class="dropdown mobile-user-menu">

        {{-- tombol toggle menu profil --}}
        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fa fa-elilipsis-v"></i>
        </a>

        {{-- menu profil khusu mobile --}}
        <div class="dropdown-menu deopdown-menu-right">

            {{-- tombol edit profil khusu mobile --}}
            <a href="{{ route('users.edit', Auth::user()) }}" class="dropdown-item">Profil Ku</a>

            {{-- tombol logout khusus mobile --}}
            <form action="{{ route('logout') }}" method="POST"></form>
                @csrf
                <button class="dropdown-item py-0" type="submit">Logout</button>
            </form>
            
        </div>
    </div>
</div>

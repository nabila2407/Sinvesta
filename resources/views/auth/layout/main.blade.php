<!DOCTYPE html>
<html lang="en">

<head>

    {{-- ? variable title akan dikirim dari Controller --}}
    <title>{{ $title ?? "SINVESTA" }}</title>

    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Anto Kriswandiyanto">
    <meta name="description" content="Uji Kompetensi Keahlian - Pengembangan Perangkat Lunak dan Gim">

    {{-- ? memanggil icon website (logo sekolah) --}}
    <link rel="shortcut icon" href="{{ asset('assets/icon/favicon.png') }}">

    {{-- ? memanggil file CSS BOOTSTRAP --}}
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">

    {{-- ? memanggil CSS ICON BOOTSTRAP menggunakan CDN, hati-hati jangan sampai typo / copy langsung dari web bootstrap --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    {{-- ? memanggil file CSS TEMA DASHBOARD --}}
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>

<body>

    <main>
        <section class="p-0 d-flex align-items-center position-relative overflow-hidden">

            <div class="container-fluid">
                <div class="row">

                    {{-- 
                    ? @yield adalah perintah Blade yang berfungsi sebagai :
                    * Tenampilkan isi dari halaman lain ke dalam layout utama
                    * 'konten' adalah nama dari @yield
                    ! @yield hanya digunakan di file layout
                    --}}
                    @yield('konten')

                </div>    
            </div>
        </section>
    </main>      
    
    {{-- ? JAVASCRIPT AKAN DI PANGGIL BAGIAN PALING BAWAH SEBELUM PENUTUP BODY --}}
    {{-- ? JAVASCRIPT JQUERY 3.6.0 --}}
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>

    {{-- ? JAVASCRIPT FEATHER --}}
    <script src="{{ asset('assets/js/feather.min.js') }}"></script>

    {{-- ? JAVASCRIPT BOOTSTRAP --}}
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

    {{-- ? JAVASCRIPT TEMA DASHBOARD --}}
    <script src="{{ asset('assets/js/script.js') }}"></script>

</body>

</html>
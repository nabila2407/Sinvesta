{{-- ? Panggil file main.blade.php yang ada difolder dashboard/layout --}}
@extends('dashboard.layout.main')

{{-- ? code styling css untuk halaman detail berita acara --}}
@section('css')
    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            .bar-code,
            .bar-code * {
                visibility: visible;
            }

            .bar-code {
                position: absolute;
                left: 50%;
                top: 50%;
                transform: translate(-50%, -50%);
                text-align: center;
            }
        }
    </style>
@endsection

@section('konten')
    <div class="page-header">
        {{-- judul halaman --}}
        <div class="page-title">
            <h4>Berita Acara Serah Terima</h4>
            <h6>Lihat detail Berita Acara Serah Terima</h6>
        </div>
    </div>

    {{-- card detail berita acara --}}
    <div class="card">
        {{-- card header --}}
        <div class="card-header pb-0">
            <h5>
                Kode Kategori: {{ $bast->barang->kategori->kode_kategori }} | Kode Lokasi: {{ $bast->barang->lokasi->kode_lokasi }} | Kode Barang: {{ $bast->barang->kode_barang }}
            </h5>
        </div>
        <hr>
        {{-- card body --}}
        <div class="card-body">
            <div class="fw-bold text-secondary mb-3">Detail Barang Inventaris:</div>
            <div class="row">
                {{-- kolom kiri menampilkan data barang --}}
                <div class="col-lg-8 col-12">
                    <div class="row">
                        {{-- tampil kode barang --}}
                        <div class="col-6">
                            <div class="mb-3">
                                <div>Kode Barang:</div>
                                <h4 class="fw-bold">{{ $bast->barang->kode_barang }}</h4>
                            </div>
                        </div>

                        {{-- tampil nama barang --}}
                        <div class="col-6">
                            <div class="mb-3">
                                <div>Nama barang:</div>
                                <h4 class="fw-bold">{{ $bast->barang->nama_barang }}</h4>
                            </div>
                        </div>

                        {{-- tampil kategori barang --}}
                        <div class="col-6">
                            <div class="mb-3">
                                <div>Kategori Barang:</div>
                                <h4 class="fw-bold">{{ $bast->barang->kategori->nama_kategori }}</h4>
                            </div>
                        </div>

                        {{-- tampil lokasi barang --}}
                        <div class="col-6">
                            <div class="mb-3">
                                <div>Lokasi Barang:</div>
                                <h4 class="fw-bold">{{ $bast->barang->lokasi->nama_lokasi }}</h4>
                            </div>
                        </div>

                        {{-- tampil status barang --}}
                        <div class="col-6">
                            <div class="mb-3">
                                <div>Status Barang:</div>
                                <h4 class="fw-bold">
                                    @if ($bast->barang->status_barang == 'Baik')
                                        <span class="btn btn-sm btn-success">Baik</span>
                                    @elseif ($bast->barang->status_barang == 'Rusak Ringan')
                                        <span class="btn btn-sm btn-warning">Rusak Ringan</span>
                                    @elseif ($bast->barang->status_barang == 'Rusak Berat')
                                        <span span class="btn btn-sm btn-danger">Rusak Ringan</span>
                                    @else
                                        <span class="btn btn-sm btn-dark">Hilang</span>
                                    @endif
                                </h4>
                            </div>
                        </div>

                        {{-- deskripsi barang --}}
                        <div class="col-6">
                            <div class="mb-3">
                                <div>Deskripsi Barang:</div>
                                <h6 class="fw-bold">{{ $bast->barang->deskripsi ?? '-' }}</h6>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- kolom kanan menampilkan QRCode Barang --}}
                <div class="col-lg-4 col-12">
                    <div>QR Code Barang:</div>
                    <div class="bar-code-view">
                        {{-- tampil QR Code barang --}}
                        <div class="bar-code">
                            {{-- generate dari link detail barang --}}
                            {!! QrCode::size(100)->generate(route('barang.show', $bast->barang)) !!}
                        </div>

                        {{-- cetak QR Code --}}
                        <a class="btn btn-secondary mx-0" onclick="window.print()">
                            <i class="bi bi-printer"></i>
                        </a>

                        {{-- Download QR Code --}}
                        <a href="{{ route('barang.downloadQr', $bast->barang) }}" class="btn btn-primary">
                            <i class="bi bi-download"></i>
                        </a>
                    </div>
                </div>
            </div>
            <hr>

            {{-- detail penyerah dan penerima --}}
            <div class="fw-bold text-secondary mb-3">Detail Penyerah dan Penerima:</div>
            <div class="row">

                {{-- kolom user penyerah barang --}}
                <div class="col-lg-4 col-6">
                    <div class="mb-3">
                        <div>Nama Penyerah:</div>
                        <h4 class="fw-bold">{{ $bast->userSerah->nama_lengkap }}</h4>
                    </div>
                    <div class="mb-3">
                        <div>Status Penyerah:</div>
                        <h4 class="fw-bold">
                            @if ($bast->status_serah == 'Menunggu')
                                <span class="btn btn-sm text-white bg-secondary">
                                    <i class="bi bi-hourglass-split"></i> Menunggu
                                </span>
                            @else
                                <span class="btn btn-sm text-white bg-success">
                                    <i class="bi bi-check-circle"></i> Disetujui
                                </span>
                            @endif
                        </h4>
                    </div>
                </div>

                {{-- kolom user penerima barang --}}
                <div class="col-lg-4 col-6">
                    <div class="mb-3">
                        <div>Nama Penerima:</div>
                        <h4 class="fw-bold">{{ $bast->userTerima->nama_lengkap }}</h4>
                    </div>
                    <div class="mb-3">
                        <div>Status Penerima:</div>
                        <h4 class="fw-bold">
                            @if ($bast->status_terima == 'Menunggu')
                                <span class="btn btn-sm text-white bg-secondary">
                                    <i class="bi bi-hourglass-split"></i> Menunggu
                                </span>
                            @else
                                <span class="btn btn-sm text-white bg-success">
                                    <i class="bi bi-check-circle"></i> Disetujui
                                </span>
                            @endif
                        </h4>
                    </div>
                </div>

                {{-- kolom waktu dibuatnya berita acara --}}
                <div class="col-lg-4 col-12">
                    <div class="mb-3">
                        <div>Waktu Dibuat:</div>
                        <h4 class="fw-bold">{{ $bast->created_at->translatedFormat('l, d M Y') }}</h4>
                    </div>
                </div>
            </div>
        </div>

        {{-- card footer --}}
        <div class="card-footer">
            {{-- jika user yang login adalah admin --}}
            @if (auth()->user()->role == 'admin')
                {{-- tombol download dokumen berita acara --}}
                <a href="{{ route('bast.downloadPdf', $bast) }}" class="btn btn-secondary" target="_blank">
                    <i class="bi bi-download"></i>
                </a>

                {{-- tombol edit bast --}}
                <a href="{{ route('bast.edit', $bast) }}" class="btn btn-primary">
                    <i class="bi bi-pencil-square"></i>
                </a>

                {{-- tombol hapus bast --}}
                <form action="{{ route('bast.destroy', $bast) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger"
                        onclick="return confirm('Yakin ingin menghapus Berita Acara ini?')">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
                @endif

                {{-- jika user yang login adalah user penyerah dan status_serah = menunggu --}}
                @if (auth()->user()->id == $bast->user_serah_id && $bast->status_serah == "Menunggu")
                    {{-- munculkan tombol untuk penyerah menyetujui bast --}}
                    <form action="#" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-success"
                            onclick="return confirm('Anda akan menyetujui Berita Acara ini sebagai pihak Penyerah! Lanjutkan?')">
                            <i class="bi bi-check-circle"> Setujui Penyerah</i>
                        </button>
                    </form>
                @endif

            {{-- jika user yang login adalah user penerima dan status_serah = menunggu --}}
            @if (auth()->user()->id == $bast->user_terima_id && $bast->status_terima == "Menunggu")
                {{-- munculkan tombol untuk penerima menyetujui bast --}}
                <form action="#" method="POST" class="d-inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-success"
                        onclick="return confirm('Anda akan menyetujui Berita Acara ini sebagai pihak Penerima! Lanjutkan?')">
                        <i class="bi bi-check-circle"> Setujui Penerima</i>
                    </button>
                </form>
            @endif
        </div>
    </div>
@endsection

            
                    


                  
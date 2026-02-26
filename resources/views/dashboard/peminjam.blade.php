<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Peminjam</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    {{-- HEADER --}}
    <nav class="navbar navbar-light bg-light px-4">
        <span class="navbar-brand">📚 Perpustakaan</span>
        <div>
            {{ auth()->user()->nama }}
            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <button class="btn btn-sm btn-danger">Logout</button>
            </form>
        </div>
    </nav>

    {{-- CONTENT --}}
    <div class="container">
        <h4 class="mb-3 mt-3">Buku yang Sedang Dipinjam</h4>

        @if($dipinjam->count())
        <div class="row">
            @foreach($dipinjam as $item)
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm h-100">

                    <div class="card-body">
                        <h6 class="fw-bold mb-1">
                            {{ $item->buku->judul }}
                        </h6>

                        <small class="text-muted d-block mb-2">
                            Jatuh Tempo:
                            {{ \Carbon\Carbon::parse($item->tanggal_jatuh_tempo)->translatedFormat('d F Y') }}
                        </small>

                        {{-- STATUS --}}
                        @if($item->jumlah_perpanjangan >= 2)
                        <span class="badge bg-secondary">
                            Maksimal Perpanjangan
                        </span>

                        @elseif($item->status_perpanjangan === 'menunggu')
                        <span class="badge bg-warning text-dark">
                            Menunggu Verifikasi
                        </span>

                        @elseif($item->status_perpanjangan === 'ditolak')
                        <span class="badge bg-danger d-block mb-2">
                            Perpanjangan Ditolak
                        </span>
                        <small class="text-muted">
                            Alasan: {{ $item->alasan_penolakan }}
                        </small>
                        @else
                        <button class="btn btn-sm btn-warning"
                            data-bs-toggle="modal"
                            data-bs-target="#modalPerpanjang{{ $item->id_detail }}">
                            Perpanjang
                        </button>
                        @endif
                    </div>
                    <div class="modal fade" id="modalPerpanjang{{ $item->id_detail }}" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h5 class="modal-title">Konfirmasi Perpanjangan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    <p>
                                        Yakin ingin memperpanjang buku
                                        <strong>{{ $item->buku->judul }}</strong>?
                                    </p>
                                    <small class="text-muted">
                                        Jatuh tempo akan bertambah 7 hari.
                                    </small>
                                </div>

                                <div class="modal-footer">
                                    <button class="btn btn-secondary" data-bs-dismiss="modal">
                                        Batal
                                    </button>

                                    <form action="{{ route('peminjam.perpanjang', $item->id_detail) }}"
                                        method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button class="btn btn-success">
                                            Ya, Perpanjang
                                        </button>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <p class="text-muted">Tidak ada buku yang sedang dipinjam.</p>
        @endif


        <h4 class="mb-4">Katalog Buku</h4>

        <div class="row">
            @forelse($buku as $item)
            <div class="col-md-3 mb-4">
                <div class="card h-100 shadow-sm">

                    {{-- Gambar Buku --}}
                    @if($item->foto)
                    <img src="{{ asset('storage/'.$item->foto) }}"
                        class="card-img-top"
                        style="height:200px; object-fit:cover">
                    @else
                    <img src="https://via.placeholder.com/300x200?text=No+Image"
                        class="card-img-top">
                    @endif

                    <div class="card-body d-flex flex-column">
                        <h6 class="mb-1">{{ $item->judul }}</h6>

                        <small class="text-muted">
                            {{ $item->penulis->nama ?? '-' }}
                        </small>

                        <p class="mt-2 mb-2">
                            Stok:
                            @if($item->stok > 0)
                            <span class="badge bg-success">{{ $item->stok }}</span>
                            @else
                            <span class="badge bg-danger">Habis</span>
                            @endif
                        </p>

                        <button class="btn btn-sm btn-outline-primary mt-auto"
                            data-bs-toggle="modal"
                            data-bs-target="#modalBuku{{ $item->id_buku }}">
                            Lihat Detail
                        </button>

                    </div>
                </div>
            </div>
            {{-- MODAL DETAIL BUKU --}}
            <div class="modal fade" id="modalBuku{{ $item->id_buku }}" tabindex="-1">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title">{{ $item->judul }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <div class="row">

                                <div class="col-md-4">
                                    @if($item->foto)
                                    <img src="{{ asset('storage/'.$item->foto) }}"
                                        class="img-fluid rounded">
                                    @else
                                    <img src="https://via.placeholder.com/300x400?text=No+Image"
                                        class="img-fluid rounded">
                                    @endif
                                </div>

                                <div class="col-md-8">
                                    <table class="table table-sm table-borderless">
                                        <tr>
                                            <th>Judul</th>
                                            <td>{{ $item->judul }}</td>
                                        </tr>
                                        <tr>
                                            <th>Penulis</th>
                                            <td>{{ $item->penulis->nama ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Rak</th>
                                            <td>{{ $item->rak ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Stok</th>
                                            <td>{{ $item->stok }}</td>
                                        </tr>
                                    </table>

                                    <hr>

                                    <h6>Deskripsi</h6>
                                    <p class="text-muted">
                                        {{ $item->deskripsi ?? 'Tidak ada deskripsi.' }}
                                    </p>
                                </div>

                            </div>
                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-bs-dismiss="modal">
                                Tutup
                            </button>
                        </div>

                    </div>
                </div>
            </div>
            @empty
            <p class="text-muted">Belum ada buku.</p>

            @endforelse
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</html>
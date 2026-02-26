@extends('layouts.app')

@section('title', 'Detail Buku')

@section('content')
<div class="card shadow-sm">
    <div class="card-header">
        <h5 class="mb-0">Detail Buku</h5>
    </div>

    <div class="card-body">
        <div class="row">

            {{-- FOTO --}}
            <div class="col-md-3 text-center">
                @if($buku->foto)
                <img src="{{ asset('storage/' . $buku->foto) }}"
                     class="img-fluid rounded mb-3">
                @else
                <div class="text-muted">Tidak ada foto</div>
                @endif
            </div>

            {{-- INFO --}}
            <div class="col-md-9">
                <table class="table table-borderless">
                    <tr>
                        <th width="30%">Judul</th>
                        <td>{{ $buku->judul }}</td>
                    </tr>
                    <tr>
                        <th>Kategori</th>
                        <td>{{ $buku->kategori->nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Penulis</th>
                        <td>{{ $buku->penulis->nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Penerbit</th>
                        <td>{{ $buku->penerbit->nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Tahun Terbit</th>
                        <td>{{ $buku->tahun_terbit ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Jumlah Halaman</th>
                        <td>{{ $buku->jumlah_halaman ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>ISBN</th>
                        <td>{{ $buku->isbn ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Rak</th>
                        <td>{{ $buku->rak ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Stok</th>
                        <td>
                            @if($buku->stok > 0)
                                <span class="badge bg-success">Tersedia</span>
                            @else
                                <span class="badge bg-danger">Habis</span>
                            @endif
                            ({{ $buku->stok }})
                        </td>
                    </tr>
                    <tr>
                        <th>Deskripsi</th>
                        <td>{{ $buku->deskripsi ?? '-' }}</td>
                    </tr>
                </table>
            </div>

        </div>

        <div class="mt-3">
            <a href="{{ route('buku.index') }}" class="btn btn-secondary">
                Kembali
            </a>
        </div>
    </div>
</div>
@endsection

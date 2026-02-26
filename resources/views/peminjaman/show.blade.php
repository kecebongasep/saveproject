@extends('layouts.app')

@section('title', 'Detail Peminjaman')

@section('content')
<div class="card shadow-sm">

    {{-- HEADER --}}
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Detail Peminjaman</h5>
        <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary btn-sm">
            Kembali
        </a>
    </div>

    <div class="card-body">

        {{-- ALERT --}}
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        {{-- INFO PEMINJAMAN --}}
        <table class="table table-bordered mb-4">
            <tr>
                <th width="200">Nama Peminjam</th>
                <td>{{ $peminjaman->user->nama }}</td>
            </tr>
            <tr>
                <th>Tanggal Pinjam</th>
                <td>
                    {{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->translatedFormat('d F Y') }}
                </td>
            </tr>
        </table>

        {{-- DETAIL BUKU --}}
        <h6 class="mb-3">Daftar Buku yang Dipinjam</h6>

        <table class="table table-striped table-bordered">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Judul Buku</th>
                    <th>Jatuh Tempo</th>
                    <th>Tanggal Kembali</th>
                    <th>Denda</th>
                    <th width="120">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($peminjaman->detail as $detail)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $detail->buku->judul }}</td>
                    <td>
                        {{ \Carbon\Carbon::parse($detail->tanggal_jatuh_tempo)->translatedFormat('d F Y') }}
                    </td>
                    <td>
                        {{ \Carbon\Carbon::parse($detail->tanggal_kembali)->translatedFormat('d F Y') }}
                    </td>
                    <td>
                        {{ number_format($detail->denda ?? 0) }} Hari
                    </td>
                    <td>
                        @if(is_null($detail->tanggal_kembali))

                        {{-- TOMBOL KEMBALIKAN --}}
                        <form action="{{ route('detail.kembalikan', $detail->id_detail) }}"
                            method="POST"
                            class="mb-1"
                            onsubmit="return confirm('Kembalikan buku ini?')">
                            @csrf
                            @method('PUT')
                            <button class="btn btn-success btn-sm w-100">
                                Kembalikan
                            </button>
                        </form>

                        @else
                        <span class="badge bg-success">
                            Dikembalikan
                        </span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">
                        Tidak ada detail buku
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

    </div>
</div>
@endsection
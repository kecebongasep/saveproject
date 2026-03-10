@extends('layouts.app')

@section('title', 'Peminjaman')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Peminjaman</h3>
</div>

<div class="card shadow-sm">
    <div class="card-body">

        {{-- ALERT SUCCESS --}}
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        {{-- SEARCH + TAMBAH --}}
        <form method="GET" class="mb-3">
            <div class="d-flex justify-content-between align-items-center gap-2">

                {{-- SEARCH --}}
                <div class="d-flex" style="max-width: 350px;">
                    <input type="text"
                        name="search"
                        class="form-control me-2"
                        placeholder="Cari peminjam / buku..."
                        value="{{ request('search') }}">
                </div>

                {{-- TOMBOL TAMBAH --}}
                <a href="{{ route('peminjaman.create') }}"
                    class="btn btn-primary">
                    Tambah Peminjaman
                </a>

            </div>
        </form>

        {{-- TABLE --}}
        <table class="table table-bordered table-hover">
            <thead class="table-dark text-center">
                <tr>
                    <th width="5%">No</th>
                    <th>Buku</th>
                    <th>Peminjam</th>
                    <th>Tgl Pinjam</th>
                    <th>Tgl Jatuh Tempo</th>
                    <th>Status</th>
                    <th width="25%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($peminjaman as $item)
                <tr>
                    <td class="text-center">
                        {{ $peminjaman->firstItem() + $loop->index }}
                    </td>
                    <td>
                        @foreach($item->detail as $detail)
                        <div>{{ $detail->buku->judul }}</div>
                        @endforeach
                    </td>
                    <td>{{ $item->user->nama ?? '-'}}</td>
                    <td class="text-center">
                        {{ \Carbon\Carbon::parse($item->tanggal_pinjam)->translatedFormat('d F Y') }}
                    </td>
                    <td class="text-center">
                        @foreach($item->detail as $detail)
                        <div>
                            {{ \Carbon\Carbon::parse($detail->tanggal_jatuh_tempo)->translatedFormat('d F Y') }}
                        </div>
                        @endforeach
                    </td>
                    <td class="text-center">
                        <span class="badge
                            {{ $item->status == 'dipinjam' ? 'bg-warning' : 'bg-success' }}">
                            {{ ucfirst($item->status) }}
                        </span>
                    </td>
                    <td class="text-center">

                        {{-- JIKA MASIH DIPINJAM --}}
                        @if($item->status === 'dipinjam')

                        <a href="{{ route('peminjaman.show', $item->id_peminjaman) }}"
                            class="btn btn-sm btn-success">
                            Kembalikan
                        </a>

                        <form action="{{ route('peminjaman.destroy', $item->id_peminjaman) }}"
                            method="POST"
                            class="d-inline"
                            onsubmit="return confirm('Yakin hapus data ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">
                                Hapus
                            </button>
                        </form>

                        @else
                        {{-- JIKA SUDAH DIKEMBALIKAN --}}

                        <a href="{{ route('peminjaman.show', $item->id_peminjaman) }}"
                            class="btn btn-sm btn-warning">
                            Lihat
                        </a>

                        <form action="{{ route('peminjaman.destroy', $item->id_peminjaman) }}"
                            method="POST"
                            class="d-inline"
                            onsubmit="return confirm('Yakin hapus data ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">
                                Hapus
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">
                        Data peminjaman belum ada
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{-- PAGINATION --}}
        <div class="d-flex justify-content-center mt-3">
            {{ $peminjaman->links() }}
        </div>

    </div>
</div>
@endsection
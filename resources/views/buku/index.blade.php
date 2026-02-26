@extends('layouts.app')

@section('title', 'Buku')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Data Buku</h3>
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

        {{-- SEARCH & TAMBAH --}}
        <form method="GET" class="mb-3">
            <div class="d-flex justify-content-between align-items-center gap-2">

                {{-- SEARCH --}}
                <div class="d-flex" style="max-width: 350px;">
                    <input type="text"
                        name="search"
                        class="form-control me-2"
                        placeholder="Cari data..."
                        value="{{ request('search') }}">
                </div>

                {{-- TAMBAH --}}
                <a href="{{ route('buku.create') }}" class="btn btn-primary">
                    Tambah Buku
                </a>

            </div>
        </form>

        {{-- TABLE --}}
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th width="5%">No</th>
                        <th>Judul</th>
                        <th>Penulis</th>
                        <th>Penerbit</th>
                        <th>Tahun</th>
                        <th>Stok</th>
                        <th width="20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($buku as $item)
                    <tr>
                        <td class="text-center">
                            {{ $buku->firstItem() + $loop->index }}
                        </td>
                        <td>{{ $item->judul }}</td>
                        <td>{{ $item->penulis->nama ?? '-' }}</td>
                        <td>{{ $item->penerbit->nama ?? '-' }}</td>
                        <td class="text-center">{{ $item->tahun_terbit ?? '-' }}</td>
                        <td class="text-center">{{ $item->stok }}</td>
                        <td class="text-center">
                            <a href="{{ route('buku.show', $item->id_buku) }}"
                                class="btn btn-sm btn-info text-white">
                                Detail
                            </a>

                            <a href="{{ route('buku.edit', $item->id_buku) }}"
                                class="btn btn-sm btn-warning">
                                Edit
                            </a>

                            <form action="{{ route('buku.destroy', $item->id_buku) }}"
                                method="POST"
                                class="d-inline"
                                onsubmit="return confirm('Yakin hapus buku ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">
                            Data buku belum ada
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        <div class="d-flex justify-content-center mt-3">
            {{ $buku->links() }}
        </div>

    </div>
</div>
@endsection
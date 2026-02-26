@extends('layouts.app')

@section('title', 'Kategori Buku')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Kategori Buku</h3>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <form method="GET" class="mb-3">
            <div class="d-flex justify-content-between align-items-center gap-2">

                {{-- SEARCH --}}
                <div class="d-flex" style="max-width: 350px;">
                    <input type="text"
                        name="search"
                        class="form-control me-2"
                        placeholder="Cari kategori..."
                        value="{{ request('search') }}">
                </div>

                {{-- TOMBOL TAMBAH --}}
                <a href="{{ route('kategori.create') }}"
                    class="btn btn-primary">
                    Tambah Kategori
                </a>

            </div>
        </form>


        <table class="table table-bordered table-hover">
            <thead class="table-dark text-center">
                <tr>
                    <th width="5%">No</th>
                    <th>Nama Kategori</th>
                    <th width="25%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kategori as $item)
                <tr>
                    <td>{{ $kategori->firstItem() + $loop->index }}</td>
                    <td>{{ $item->nama }}</td>
                    <td class="text-center">
                        <a href="{{ route('kategori.edit', $item->id_kategori) }}"
                            class="btn btn-sm btn-warning">
                            Edit
                        </a>

                        <form action="{{ route('kategori.destroy', $item->id_kategori) }}"
                            method="POST"
                            class="d-inline"
                            onsubmit="return confirm('Yakin hapus kategori ini?')">
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
                    <td colspan="3" class="text-center text-muted">
                        Data kategori belum ada
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="d-flex justify-content-center mt-3">
            {{ $kategori->links() }}
        </div>

    </div>
</div>
@endsection
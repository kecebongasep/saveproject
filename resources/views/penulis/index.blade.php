@extends('layouts.app')

@section('title', 'Penulis')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Penulis</h3>
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
                        placeholder="Cari penulis..."
                        value="{{ request('search') }}">
                </div>

                {{-- TOMBOL TAMBAH --}}
                <a href="{{ route('penulis.create') }}"
                    class="btn btn-primary">
                    Tambah Penulis
                </a>

            </div>
        </form>


        <table class="table table-bordered table-hover">
            <thead class="table-dark text-center">
                <tr>
                    <th width="5%">No</th>
                    <th>Nama Penulis</th>
                    <th>Asal Negara</th>
                    <th width="25%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($penulis as $item)
                <tr>
                    <td>{{ $penulis->firstItem() + $loop->index }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->asal_negara }}</td>
                    <td class="text-center">
                        <a href="{{ route('penulis.edit', $item->id_penulis) }}"
                            class="btn btn-sm btn-warning">
                            Edit
                        </a>

                        <form action="{{ route('penulis.destroy', $item->id_penulis) }}"
                            method="POST"
                            class="d-inline"
                            onsubmit="return confirm('Yakin hapus penulis ini?')">
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
                        Data penulis belum ada
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="d-flex justify-content-center mt-3">
            {{ $penulis->links() }}
        </div>

    </div>
</div>
@endsection
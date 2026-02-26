@extends('layouts.app')

@section('title', 'Penerbit')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="mb-0">Penerbit</h3>
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
                        placeholder="Cari penerbit..."
                        value="{{ request('search') }}">
                </div>

                {{-- TOMBOL TAMBAH --}}
                <a href="{{ route('penerbit.create') }}"
                    class="btn btn-primary">
                    Tambah Penerbit
                </a>

            </div>
        </form>


        <table class="table table-bordered table-hover">
            <thead class="table-dark text-center">
                <tr>
                    <th width="5%">No</th>
                    <th>Nama Penerbit</th>
                    <th width="25%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($penerbit as $item)
                <tr>
                    <td>{{ $penerbit->firstItem() + $loop->index }}</td>
                    <td>{{ $item->nama }}</td>
                    <td class="text-center">
                        <a href="{{ route('penerbit.edit', $item->id_penerbit) }}"
                            class="btn btn-sm btn-warning">
                            Edit
                        </a>

                        <form action="{{ route('penerbit.destroy', $item->id_penerbit) }}"
                            method="POST"
                            class="d-inline"
                            onsubmit="return confirm('Yakin hapus penerbit ini?')">
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
                        Data penerbit belum ada
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="d-flex justify-content-center mt-3">
            {{ $penerbit->links() }}
        </div>

    </div>
</div>
@endsection
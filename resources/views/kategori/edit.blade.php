@extends('layouts.app')

@section('title', 'Edit Kategori')

@section('content')
<div class="card shadow-sm">
    <div class="card-header">
        <h5 class="mb-0">✏️ Edit Kategori</h5>
    </div>

    <div class="card-body">
        <form action="{{ route('kategori.update', $kategori->id_kategori) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Nama Kategori</label>
                <input type="text"
                       name="nama"
                       class="form-control"
                       value="{{ $kategori->nama }}"
                       required>
            </div>

            <div class="d-flex gap-2">
                <button class="btn btn-success">Update</button>
                <a href="{{ route('kategori.index') }}" class="btn btn-secondary">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection


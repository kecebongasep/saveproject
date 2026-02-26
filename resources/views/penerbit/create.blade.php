@extends('layouts.app')

@section('title', 'Tambah Penerbit')

@section('content')
<div class="card shadow-sm">
    <div class="card-header">
        <h5 class="mb-0">Tambah Penerbit</h5>
    </div>

    <div class="card-body">
        <form action="{{ route('penerbit.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Nama Penerbit</label>
                <input type="text"
                       name="nama"
                       class="form-control"
                       required>
            </div>

            <div class="d-flex gap-2">
                <button class="btn btn-primary">Simpan</button>
                <a href="{{ route('penerbit.index') }}" class="btn btn-secondary">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection


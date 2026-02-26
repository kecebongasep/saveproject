@extends('layouts.app')

@section('title', 'Edit Penulis')

@section('content')
<div class="card shadow-sm">
    <div class="card-header">
        <h5 class="mb-0">✏️ Edit Penulis</h5>
    </div>

    <div class="card-body">
        <form action="{{ route('penulis.update', $penulis->id_penulis) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Nama Penulis</label>
                <input type="text"
                       name="nama"
                       class="form-control"
                       value="{{ $penulis->nama }}"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">Asal Negara</label>
                <input type="text"
                       name="asal_negara"
                       class="form-control"
                       value="{{ $penulis->asal_negara }}"
                       required>
            </div>

            <div class="d-flex gap-2">
                <button class="btn btn-warning">Update</button>
                <a href="{{ route('penulis.index') }}" class="btn btn-secondary">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection


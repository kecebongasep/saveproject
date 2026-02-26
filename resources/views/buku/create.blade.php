@extends('layouts.app')

@section('title', 'Tambah Buku')

@section('content')
<div class="card shadow-sm">
    <div class="card-header">
        <h5 class="mb-0">Tambah Buku</h5>
    </div>

    <div class="card-body">
        <form action="{{ route('buku.store') }}"
            method="POST"
            enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">Judul Buku</label>
                <input type="text" name="judul" class="form-control" required>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Kategori</label>
                    <select name="id_kategori" class="form-select" required>
                        <option value="">-- Pilih --</option>
                        @foreach($kategori as $item)
                        <option value="{{ $item->id_kategori }}">
                            {{ $item->nama }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Penulis</label>
                    <select name="id_penulis" class="form-select" required>
                        <option value="">-- Pilih --</option>
                        @foreach($penulis as $item)
                        <option value="{{ $item->id_penulis }}">
                            {{ $item->nama }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Penerbit</label>
                    <select name="id_penerbit" class="form-select" required>
                        <option value="">-- Pilih --</option>
                        @foreach($penerbit as $item)
                        <option value="{{ $item->id_penerbit }}">
                            {{ $item->nama }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3 mb-3">
                    <label class="form-label">Tahun Terbit</label>
                    <input type="number" name="tahun_terbit" class="form-control">
                </div>

                <div class="col-md-3 mb-3">
                    <label class="form-label">Jumlah Halaman</label>
                    <input type="number" name="jumlah_halaman" class="form-control">
                </div>

                <div class="col-md-3 mb-3">
                    <label class="form-label">ISBN</label>
                    <input type="text" name="isbn" class="form-control">
                </div>

                <div class="col-md-3 mb-3">
                    <label class="form-label">Stok</label>
                    <input type="number" name="stok" class="form-control" value="0">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Rak</label>
                <input type="text" name="rak" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="deskripsi" rows="3" class="form-control"></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Foto Buku</label>
                <input type="file" name="foto" class="form-control">
            </div>

            <div class="d-flex gap-2">
                <button class="btn btn-primary">Simpan</button>
                <a href="{{ route('buku.index') }}" class="btn btn-secondary">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
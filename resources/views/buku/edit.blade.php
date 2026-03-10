@extends('layouts.app')

@section('title', 'Edit Buku')

@section('content')
<div class="card shadow-sm">
    <div class="card-header">
        <h5 class="mb-0">Edit Buku</h5>
    </div>

    <div class="card-body">
        <form action="{{ route('buku.update', $buku->id_buku) }}"
            method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Judul Buku</label>
                <input type="text"
                    name="judul"
                    class="form-control"
                    value="{{ $buku->judul }}"
                    required>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Kategori</label>
                    <select name="id_kategori" class="form-select" required>
                        @foreach($kategori as $item)
                        <option value="{{ $item->id_kategori }}"
                            @selected($buku->id_kategori == $item->id_kategori)>
                            {{ $item->nama_kategori }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Penulis</label>
                    <select name="id_penulis" class="form-select" required>
                        @foreach($penulis as $item)
                        <option value="{{ $item->id_penulis }}"
                            @selected($buku->id_penulis == $item->id_penulis)>
                            {{ $item->nama }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Penerbit</label>
                    <select name="id_penerbit" class="form-select" required>
                        @foreach($penerbit as $item)
                        <option value="{{ $item->id_penerbit }}"
                            @selected($buku->id_penerbit == $item->id_penerbit)>
                            {{ $item->nama }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3 mb-3">
                    <label class="form-label">Tahun Terbit</label>
                    <input type="number"
                        name="tahun_terbit"
                        class="form-control"
                        value="{{ $buku->tahun_terbit }}">
                </div>

                <div class="col-md-3 mb-3">
                    <label class="form-label">Jumlah Halaman</label>
                    <input type="number"
                        name="jumlah_halaman"
                        class="form-control"
                        value="{{ $buku->jumlah_halaman }}">
                </div>

                <div class="col-md-3 mb-3">
                    <label class="form-label">ISBN</label>
                    <input type="text"
                        name="isbn"
                        class="form-control"
                        value="{{ $buku->isbn }}">
                </div>

                <div class="col-md-3 mb-3">
                    <label class="form-label">Stok</label>
                    <input type="number"
                        name="stok"
                        class="form-control"
                        value="{{ $buku->stok }}">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Rak</label>
                <input type="text"
                    name="rak"
                    class="form-control"
                    value="{{ $buku->rak }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="deskripsi"
                    rows="3"
                    class="form-control">{{ $buku->deskripsi }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Foto Buku</label>
                <input type="file" name="foto" class="form-control">

                @if($buku->foto)
                <img src="{{ asset('storage/' . $buku->foto) }}"
                    class="img-thumbnail mt-2"
                    width="120">
                @endif
            </div>

            <div class="d-flex gap-2">
                <button class="btn btn-success">Update</button>
                <a href="{{ route('buku.index') }}" class="btn btn-secondary">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
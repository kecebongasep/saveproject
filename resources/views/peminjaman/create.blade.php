@extends('layouts.app')

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>

@section('title', 'Tambah Peminjaman')

@section('content')
<div class="card shadow-sm">
    <div class="card-header">
        <h5 class="mb-0">Tambah Peminjaman</h5>
    </div>

    <div class="card-body">

        @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif

        <form action="{{ route('peminjaman.store') }}" method="POST">
            @csrf

            {{-- NAMA PEMINJAM --}}
            <div class="mb-3">
                <label class="form-label">Peminjam</label>
                <select name="id_peminjam" class="form-select select2" required>
                    <option value="">-- Pilih Peminjam --</option>
                    @foreach($users as $user)
                    <option value="{{ $user->id }}">
                        {{ $user->nama }} ({{ $user->email }})
                    </option>
                    @endforeach
                </select>
            </div>

            {{-- PILIH BUKU --}}
            <div class="mb-3">
                <label class="form-label">Buku</label>

                <div id="buku-wrapper">
                    <div class="input-group mb-2 buku-item">
                        <select name="buku[]" class="form-select" required>
                            <option value="">-- Pilih Buku --</option>
                            @foreach($buku as $item)
                            <option value="{{ $item->id_buku }}">
                                {{ $item->judul }} (Stok: {{ $item->stok }})
                            </option>
                            @endforeach
                        </select>
                        <button type="button" class="btn btn-success tambah-buku">
                            +
                        </button>
                    </div>
                </div>

                <small class="text-muted">
                    Maksimal 2 buku per peminjaman
                </small>
            </div>

            {{-- TANGGAL PINJAM --}}
            <div class="mb-3">
                <label class="form-label">Tanggal Pinjam</label>
                <input type="date"
                    name="tanggal_pinjam"
                    class="form-control"
                    value="{{ date('Y-m-d') }}"
                    required>
            </div>

            <div class="d-flex gap-2">
                <button class="btn btn-primary">
                    Simpan
                </button>
                <a href="{{ route('peminjaman.index') }}"
                    class="btn btn-secondary">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('click', function(e) {

        // tambah dropdown
        if (e.target.classList.contains('tambah-buku')) {

            const wrapper = document.getElementById('buku-wrapper');
            const total = wrapper.querySelectorAll('.buku-item').length;

            if (total >= 2) {
                alert('Maksimal 2 buku');
                return;
            }

            const first = wrapper.querySelector('.buku-item');
            const clone = first.cloneNode(true);

            clone.querySelector('select').value = '';
            clone.querySelector('.tambah-buku').classList.remove('btn-success');
            clone.querySelector('.tambah-buku').classList.add('btn-danger');
            clone.querySelector('.tambah-buku').textContent = '−';
            clone.querySelector('.tambah-buku').classList.remove('tambah-buku');
            clone.querySelector('.btn-danger').classList.add('hapus-buku');

            wrapper.appendChild(clone);
        }

        // hapus dropdown
        if (e.target.classList.contains('hapus-buku')) {
            e.target.closest('.buku-item').remove();
        }
    });
</script>

@endsection
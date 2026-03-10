@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">

    {{-- JUDUL --}}
    <div class="mb-4">
        <h4 class="fw-bold">Dashboard Perpustakaan</h4>
        <small class="text-muted">Ringkasan aktivitas perpustakaan</small>
    </div>

    {{-- CARD STATISTIK --}}
    <div class="row g-3 mb-4">

        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Total Buku</h6>
                    <h3 class="fw-bold">{{ $totalBuku }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Buku Dipinjam</h6>
                    <h3 class="fw-bold">{{ $bukuDipinjam }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Peminjaman Hari Ini</h6>
                    <h3 class="fw-bold">{{ $pinjamHariIni }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-danger">
                <div class="card-body">
                    <h6 class="text-danger">Buku Terlambat</h6>
                    <h3 class="fw-bold text-danger">{{ $bukuTerlambat }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row">

        {{-- GRAFIK (KIRI) --}}
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">Grafik Peminjaman per Bulan</h6>
                    <canvas id="chartPinjam"></canvas>
                </div>
            </div>
        </div>

        {{-- PERMINTAAN PERPANJANGAN (KANAN) --}}
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">

                <div class="card-body">
                    <h5 class="fw-bold mb-3">Permintaan Perpanjangan</h5>

                    {{-- LIST PERMINTAAN --}}
                    <div class="mt-3">

                        @foreach($permintaan as $item)
                        <div class="card mb-3">
                            <div class="card-body">

                                <strong>{{ $item->buku->judul }}</strong><br>
                                Peminjam: {{ $item->peminjaman->user->nama }}<br>

                                Jatuh Tempo:
                                {{ \Carbon\Carbon::parse($item->tanggal_jatuh_tempo)->translatedFormat('d F Y') }}
                                <br><br>

                                <form action="{{ route('admin.perpanjang.setujui', $item->id_detail) }}"
                                    method="POST" class="d-inline">
                                    @csrf
                                    <button class="btn btn-sm btn-success">Setujui</button>
                                </form>

                                <button class="btn btn-sm btn-danger"
                                    data-bs-toggle="modal"
                                    data-bs-target="#tolak{{ $item->id_detail }}">
                                    Tolak
                                </button>

                            </div>
                        </div>
                        @endforeach

                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

{{-- CHART JS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', () => {

        const canvas = document.getElementById('chartPinjam');
        if (!canvas) return;

        new Chart(canvas, {
            type: 'bar',
            data: {
                labels: @json($bulan),
                datasets: [{
                    label: 'Jumlah Peminjaman',
                    data: @json($jumlahPinjam),
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

    });
</script>

@endsection
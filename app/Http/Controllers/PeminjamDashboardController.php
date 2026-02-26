<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\DetailPeminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeminjamDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 📚 Buku yang sedang dipinjam oleh user login
        $dipinjam = DetailPeminjaman::with([
            'buku',
            'peminjaman'
        ])
            ->whereHas('peminjaman', function ($q) use ($user) {
                $q->where('id_peminjam', $user->id)
                    ->where('status', 'dipinjam');
            })
            ->whereNull('tanggal_kembali')
            ->get();

        // 📦 Katalog buku (sementara)
        $buku = Buku::with('penulis')->orderBy('judul')->get();

        return view('dashboard.peminjam', compact(
            'dipinjam',
            'buku'
        ));
    }
}

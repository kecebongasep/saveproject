<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\DetailPeminjaman;
use App\Models\Peminjaman;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        /* =====================
         |  STATISTIK UTAMA
         ===================== */

        // Total buku (stok + dipinjam)
        $totalBuku = Buku::sum('stok');

        // Buku yang sedang dipinjam
        $bukuDipinjam = DetailPeminjaman::whereNull('tanggal_kembali')->count();

        // Peminjaman hari ini
        $pinjamHariIni = Peminjaman::whereDate(
            'tanggal_pinjam',
            Carbon::today()
        )->count();

        // Buku terlambat
        $bukuTerlambat = DetailPeminjaman::whereNull('tanggal_kembali')
            ->whereDate('tanggal_jatuh_tempo', '<', Carbon::today())
            ->count();


        /* =====================
         |  CHART PER BULAN
         ===================== */

        $dataChart = Peminjaman::select(
            DB::raw('MONTH(tanggal_pinjam) as bulan'),
            DB::raw('COUNT(*) as total')
        )
            ->whereYear('tanggal_pinjam', Carbon::now()->year)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $bulan = [];
        $jumlahPinjam = [];

        foreach ($dataChart as $item) {
            $bulan[] = Carbon::create()->month($item->bulan)->translatedFormat('F');
            $jumlahPinjam[] = $item->total;
        }

        $permintaan = DetailPeminjaman::with(['buku', 'peminjaman.user'])
            ->where('status_perpanjangan', 'menunggu')
            ->get();


        return view('dashboard.index', compact(
            'totalBuku',
            'bukuDipinjam',
            'pinjamHariIni',
            'bukuTerlambat',
            'bulan',
            'jumlahPinjam',
            'permintaan'
        ));
    }

    public function setujui($id)
    {
        $detail = DetailPeminjaman::findOrFail($id);

        if ($detail->status_perpanjangan !== 'menunggu') {
            return back();
        }

        $detail->update([
            'tanggal_jatuh_tempo' =>
            Carbon::parse($detail->tanggal_jatuh_tempo)->addDays(7),

            'jumlah_perpanjangan' =>
            $detail->jumlah_perpanjangan + 1,

            'status_perpanjangan' => null,
            'alasan_penolakan' => null
        ]);

        return back()->with('success', 'Perpanjangan disetujui');
    }

    public function tolak(Request $request, $id)
    {
        $request->validate([
            'alasan' => 'required|string'
        ]);

        $detail = DetailPeminjaman::findOrFail($id);

        $detail->update([
            'status_perpanjangan' => 'ditolak',
            'alasan_penolakan' => $request->alasan
        ]);

        return back()->with('success', 'Perpanjangan ditolak');
    }
}

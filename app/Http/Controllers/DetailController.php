<?php

namespace App\Http\Controllers;

use App\Models\DetailPeminjaman;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DetailController extends Controller
{
    /**
     * Kembalikan buku
     */
    public function kembalikan($id)
    {
        $detail = DetailPeminjaman::with([
            'buku',
            'peminjaman.detail'
        ])->findOrFail($id);

        if ($detail->tanggal_kembali) {
            return back();
        }

        // hitung keterlambatan
        $hariTerlambat = Carbon::now()
            ->diffInDays($detail->tanggal_jatuh_tempo, false);

        $hariBlokir = $hariTerlambat < 0 ? abs($hariTerlambat) : 0;

        $detail->update([
            'tanggal_kembali' => now(),
            'denda'           => $hariBlokir
        ]);

        // tambah stok
        $detail->buku->increment('stok');

        // cek apakah semua buku sudah kembali
        $sisa = $detail->peminjaman
            ->detail()
            ->whereNull('tanggal_kembali')
            ->count();

        if ($sisa === 0) {
            $detail->peminjaman->update([
                'status' => 'dikembalikan'
            ]);

            return redirect()
                ->route('peminjaman.index')
                ->with('success', 'Semua buku telah dikembalikan');
        }

        return redirect()
            ->route('peminjaman.show', $detail->peminjaman->id_peminjaman)
            ->with('success', 'Buku berhasil dikembalikan');

        return back()->with('success', 'Buku berhasil dikembalikan');
    }

    public function ajukanPerpanjangan($id)
    {
        $detail = DetailPeminjaman::findOrFail($id);

        if ($detail->jumlah_perpanjangan >= 2) {
            return back()->with('error', 'Maksimal perpanjangan tercapai');
        }

        if ($detail->status_perpanjangan === 'menunggu') {
            return back();
        }

        if (now()->gt($detail->tanggal_jatuh_tempo)) {
            return back()->with('error', 'Buku sudah terlambat');
        }

        $detail->update([
            'status_perpanjangan' => 'menunggu'
        ]);

        return back()->with('success', 'Permintaan perpanjangan dikirim');
    }

    public function setujuiPerpanjangan($id)
    {
        $detail = DetailPeminjaman::findOrFail($id);

        if ($detail->status_perpanjangan !== 'menunggu') {
            return back();
        }

        $detail->update([
            'tanggal_jatuh_tempo' => now()->parse($detail->tanggal_jatuh_tempo)->addDays(7),
            'jumlah_perpanjangan' => $detail->jumlah_perpanjangan + 1,
            'status_perpanjangan' => null,
            'alasan_penolakan'    => null
        ]);

        return back()->with('success', 'Perpanjangan disetujui');
    }

    public function tolakPerpanjangan(Request $request, $id)
    {
        $detail = DetailPeminjaman::findOrFail($id);

        $detail->update([
            'status_perpanjangan' => 'ditolak',
            'alasan_penolakan' => $request->alasan
        ]);

        return back()->with('success', 'Perpanjangan ditolak');
    }
}

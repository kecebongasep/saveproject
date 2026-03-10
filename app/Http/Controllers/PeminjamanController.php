<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\DetailPeminjaman;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    /**
     * List peminjaman
     */
    public function index()
    {
        $peminjaman = Peminjaman::with([
            'user',
            'detail.buku'
        ])
            ->orderByDesc('tanggal_pinjam')
            ->paginate(10);

        return view('peminjaman.index', compact('peminjaman'));
    }

    /**
     * Form tambah peminjaman
     */
    public function create()
    {
        $buku  = Buku::where('stok', '>', 0)->get();
        $users = User::where('peran', 'peminjam')->get();

        return view('peminjaman.create', compact('buku', 'users'));
    }

    /**
     * Simpan peminjaman
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_peminjam'    => 'required',
            'buku'           => 'required|array|min:1|max:2',
            'tanggal_pinjam' => 'required|date'
        ]);

        /* =====================
       CEK BLOKIR (DI LUAR TRANSAKSI)
    ===================== */

        $blokir = DetailPeminjaman::whereHas('peminjaman', function ($q) use ($request) {
            $q->where('id_peminjam', $request->id_peminjam);
        })
            ->whereNotNull('denda')
            ->latest('tanggal_kembali')
            ->first();

        if ($blokir) {

            $bolehPinjam = Carbon::parse($blokir->tanggal_kembali)
                ->addDays($blokir->denda);

            if (now()->lessThan($bolehPinjam)) {
                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'Peminjam masih diblokir sampai ' .
                            $bolehPinjam->format('d-m-Y')
                    );
            }
        }

        /* =====================
       BARU MASUK TRANSAKSI
    ===================== */

        DB::transaction(function () use ($request) {

            $peminjaman = Peminjaman::create([
                'id_peminjam'    => $request->id_peminjam,
                'tanggal_pinjam' => $request->tanggal_pinjam,
                'status'         => 'dipinjam'
            ]);

            foreach ($request->buku as $id_buku) {

                $buku = Buku::findOrFail($id_buku);

                if ($buku->stok < 1) {
                    throw new \Exception("Stok {$buku->judul} habis");
                }

                DetailPeminjaman::create([
                    'id_peminjaman'        => $peminjaman->id_peminjaman,
                    'id_buku'              => $id_buku,
                    'jumlah'               => 1,
                    'tanggal_jatuh_tempo' => Carbon::parse($request->tanggal_pinjam)->addDays(7),
                    'tanggal_kembali'      => null,
                    'denda'                => null
                ]);

                $buku->decrement('stok');
            }
        });

        return redirect()
            ->route('peminjaman.index')
            ->with('success', 'Peminjaman berhasil disimpan');
    }

    /**
     * Detail peminjaman
     */
    public function show($id)
    {
        $peminjaman = Peminjaman::with([
            'user',
            'detail.buku'
        ])->findOrFail($id);

        return view('peminjaman.show', compact('peminjaman'));
    }

    /**
     * Hapus peminjaman
     */
    public function destroy($id)
    {
        Peminjaman::destroy($id);

        return redirect()
            ->route('peminjaman.index')
            ->with('success', 'Peminjaman dihapus');
    }
}

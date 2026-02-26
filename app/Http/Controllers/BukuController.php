<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Penerbit;
use App\Models\Penulis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Buku::with(['kategori', 'penulis', 'penerbit']);

        if ($request->search) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('judul', 'like', "%$search%")
                    ->orWhere('isbn', 'like', "%$search%")
                    ->orWhere('rak', 'like', "%$search%")

                    // 🔍 SEARCH NAMA PENULIS
                    ->orWhereHas('penulis', function ($q) use ($search) {
                        $q->where('nama', 'like', "%$search%");
                    })

                    // 🔍 SEARCH NAMA PENERBIT
                    ->orWhereHas('penerbit', function ($q) use ($search) {
                        $q->where('nama', 'like', "%$search%");
                    })

                    // 🔍 SEARCH NAMA KATEGORI
                    ->orWhereHas('kategori', function ($q) use ($search) {
                        $q->where('nama', 'like', "%$search%");
                    });
            });
        }

        $buku = $query->orderBy('judul')->paginate(10);
        $buku->appends($request->all());

        return view('buku.index', compact('buku'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('buku.create', [
            'kategori' => Kategori::all(),
            'penulis' => Penulis::all(),
            'penerbit' => Penerbit::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'judul' => 'required',
            'id_kategori' => 'required',
            'id_penulis' => 'required',
            'id_penerbit' => 'required',
            'tahun_terbit' => 'nullable|digits:4',
            'jumlah_halaman' => 'nullable|integer',
            'isbn' => 'nullable|string',
            'deskripsi' => 'nullable|string',
            'rak' => 'nullable|string',
            'stok' => 'required|integer|min:0',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('buku', 'public');
        }

        Buku::create($data);

        return redirect()->route('buku.index')
            ->with('success', 'Buku berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $buku = Buku::with(['kategori', 'penulis', 'penerbit'])
            ->findOrFail($id);

        return view('buku.show', compact('buku'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('buku.edit', [
            'buku' => Buku::findOrFail($id),
            'kategori' => Kategori::all(),
            'penulis' => Penulis::all(),
            'penerbit' => Penerbit::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $buku = Buku::findOrFail($id);

        $data = $request->validate([
            'judul' => 'required',
            'id_kategori' => 'required',
            'id_penulis' => 'required',
            'id_penerbit' => 'required',
            'tahun_terbit' => 'nullable|digits:4',
            'jumlah_halaman' => 'nullable|integer',
            'isbn' => 'nullable|string',
            'deskripsi' => 'nullable|string',
            'rak' => 'nullable|string',
            'stok' => 'required|integer|min:0',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            if ($buku->foto) {
                Storage::disk('public')->delete($buku->foto);
            }
            $data['foto'] = $request->file('foto')->store('buku', 'public');
        }

        $buku->update($data);

        return redirect()->route('buku.index')
            ->with('success', 'Buku berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $buku = Buku::findOrFail($id);

        if ($buku->foto) {
            Storage::disk('public')->delete($buku->foto);
        }

        $buku->delete();

        return back()->with('success', 'Buku berhasil dihapus');
    }
}

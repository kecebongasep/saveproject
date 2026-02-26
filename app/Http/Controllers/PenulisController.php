<?php

namespace App\Http\Controllers;

use App\Models\Penulis;
use Illuminate\Http\Request;

class PenulisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Penulis::query();

        $columns = ['nama', 'asal_negara'];

        if ($request->search) {
            $query->where(function ($q) use ($request, $columns) {
                foreach ($columns as $col) {
                    $q->orWhere($col, 'like', '%' . $request->search . '%');
                }
            });
        }

        $penulis = $query->orderBy('nama')->paginate(10);
        $penulis->appends($request->all());

        return view('penulis.index', compact('penulis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('penulis.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Penulis::create($request->validate([
            'nama' => 'required',
            'asal_negara' => 'required'
        ]));

        return redirect()->route('penulis.index')
            ->with('success', 'Penulis berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $penulis = Penulis::findOrFail($id);
        return view('penulis.edit', compact('penulis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $penulis = Penulis::findOrFail($id);
        $penulis->update($request->validate([
            'nama' => 'required',
            'asal_negara' => 'required'
        ]));

        return redirect()->route('penulis.index')
            ->with('success', 'penulis berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Penulis::destroy($id);
        return redirect()->route('penulis.index')
            ->with('success', 'Penulis berhasil dihapus');
    }
}

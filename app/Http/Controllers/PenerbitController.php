<?php

namespace App\Http\Controllers;

use App\Models\Penerbit;
use Illuminate\Http\Request;

class PenerbitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Penerbit::query();

        if ($request->search) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        $penerbit = $query->orderBy('nama')->paginate(10);
        $penerbit->appends($request->all());

        return view('penerbit.index', compact('penerbit'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('penerbit.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Penerbit::create($request->validate([
            'nama' => 'required'
        ]));

        return redirect()->route('penerbit.index')
            ->with('success', 'Penerbit berhasil ditambahkan');
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
        $penerbit = Penerbit::findOrFail($id);
        return view('penerbit.edit', compact('penerbit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $penerbit = Penerbit::findOrFail($id);
        $penerbit->update($request->validate([
            'nama' => 'required'
        ]));

        return redirect()->route('penerbit.index')
            ->with('success', 'Penerbit berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Penerbit::destroy($id);
        return redirect()->route('penerbit.index')
            ->with('success', 'Penerbit berhasil dihapus');
    }
}

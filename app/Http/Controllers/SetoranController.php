<?php

namespace App\Http\Controllers;

use App\Models\Setoran;
use App\Http\Requests\StoreSetoranRequest;
use App\Http\Requests\UpdateSetoranRequest;

class SetoranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $setorans = Setoran::orderByDesc('jumlah')->get();

        $labels = $setorans->pluck('nama');
        $values = $setorans->pluck('jumlah');

        return view('setoran.index', compact('setorans', 'labels', 'values'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('setoran.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSetoranRequest $request)
    {
        Setoran::create([
            "nama" => $request->nama,
            "jumlah" => $request->jumlah,
        ]);

        return redirect()->route('setorans.index')->with('success', 'setoran berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(Setoran $setoran)
    {
        return view('setoran.show', compact('setoran'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Setoran $setoran)
    {
        return view('setoran.edit', compact('setoran'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSetoranRequest $request, Setoran $setoran)
    {
        $setoran->update([
            "nama" => $request->nama,
            "jumlah" => $request->jumlah,
        ]);

        return redirect()->route('setorans.index')->with('success', 'setoran berhasil diperbaiki');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Setoran $setoran)
    {
        $setoran->delete();
        return redirect()->route('setorans.index')->with('success', 'setoran berhasil dihapus');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLaporanRequest;
use App\Http\Requests\UpdateLaporanRequest;
use App\Http\Requests\IndexLaporanRequest;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Laporan::with('user')->orderBy('tanggal', 'desc');

        if (auth()->user()->is_admin) {
            if ($request->filled('user_id')) {
                $query->where('user_id', $request->user_id);
            }
        } else {
            $query->where('user_id', auth()->id());
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal', $request->bulan);
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        $laporan = $query->get();

        return view('laporan', compact('laporan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLaporanRequest $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jenis_barang' => 'required|string',
            'jumlah_barang' => 'required|integer',
            'user_id' => auth()->user()->is_admin ? 'required|exists:users,id' : '',
        ]);

        Laporan::create([
            'tanggal' => $request->tanggal,
            'jenis_barang' => $request->jenis_barang,
            'jumlah_barang' => $request->jumlah_barang,
            'user_id' => auth()->user()->is_admin ? $request->user_id : auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Laporan harian berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Laporan $laporan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Laporan $laporan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLaporanRequest $request, Laporan $laporan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Laporan $laporan)
    {
        //
    }

    public function verifikasi($id)
    {
        $laporan = Laporan::findOrFail($id);
        $laporan->verifikasi = true;
        $laporan->save();

        return redirect()->back()->with('success', 'Laporan berhasil diverifikasi.');
    }

    public function laporanHarian(Request $request)
    {
        $tanggal = $request->tanggal ?? now()->toDateString();

        $query = Laporan::select('user_id')
            ->selectRaw('SUM(jumlah_barang) as total')
            ->whereDate('tanggal', $tanggal)
            ->groupBy('user_id')
            ->with('user');

        if (!auth()->user()->is_admin) {
            $query->where('user_id', auth()->id());
        } elseif ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $data = $query->get();

        return view('harian', compact('data', 'tanggal'));
    }

    public function laporanBulanan(Request $request)
    {
        $bulan = $request->bulan ?? now()->month;

        $query = Laporan::select('user_id')
            ->selectRaw('SUM(jumlah_barang) as total')
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', now()->year)
            ->groupBy('user_id')
            ->with('user');

        if (!auth()->user()->is_admin) {
            $query->where('user_id', auth()->id());
        } elseif ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $data = $query->get();

        return view('bulanan', compact('data', 'bulan'));
    }


}

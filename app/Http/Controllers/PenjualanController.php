<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PenjualanController extends Controller
{
    public function index()
    {
        $penjualans = Penjualan::with('details')->latest()->get();
        return view('penjualan.index', compact('penjualans'));
    }

    public function create()
    {
        return view('penjualan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'nama_tengkulak' => 'required|string',
            'bukti' => 'nullable|image|max:2048',
            'jenis_sampah.*' => 'required|string',
            'jumlah.*' => 'required|numeric',
            'total_penjualan.*' => 'required|numeric',
        ]);

        // simpan file bukti
        $filename = null;
        if ($request->hasFile('bukti')) {
            $file = $request->file('bukti');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('bukti/', $filename, 'public'); // ini yang penting
        }

        // hitung toal penjualan
        $totalSemua = array_sum($request->total_penjualan);


        $penjualan = Penjualan::create([
            'tanggal' => $request->tanggal,
            'nama_tengkulak' => $request->nama_tengkulak,
            'total_penjualan' => $totalSemua,
            'bukti' => $filename
        ]);


        foreach ($request->jenis_sampah as $i => $jenis) {
            PenjualanDetail::create([
                'penjualan_id' => $penjualan->id,
                'jenis_sampah' => $jenis,
                'jumlah' => $request->jumlah[$i],
                'total_penjualan' => $request->total_penjualan[$i]
            ]);
        }

        return redirect()->route('sales.index')->with('success', 'Data penjualan berhasil disimpan!');
    }

    public function edit($id)
    {
        $penjualan = Penjualan::with('details')->findOrFail($id);
        return view('penjualan.edit', compact('penjualan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'nama_tengkulak' => 'required|string',
            'bukti' => 'nullable|image|max:2048',
            'jenis_sampah.*' => 'required|string',
            'jumlah.*' => 'required|numeric',
            'total_penjualan.*' => 'required|numeric',
        ]);

        $penjualan = Penjualan::findOrFail($id);
        $penjualan->tanggal = $request->tanggal;
        $penjualan->nama_tengkulak = $request->nama_tengkulak;

        //edit bukti baru
        if ($request->hasFile('bukti')) {
            if ($penjualan->bukti) {
                Storage::delete('bukti/' . $penjualan->bukti);
            }
            $file = $request->file('bukti');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('bukti/', $filename, 'public'); // ini yang penting
            $penjualan->bukti = $filename;
        }

        $penjualan->save();


        $penjualan->details()->delete();

        foreach ($request->jenis_sampah as $i => $jenis) {
            PenjualanDetail::create([
                'penjualan_id' => $penjualan->id,
                'jenis_sampah' => $jenis,
                'jumlah' => $request->jumlah[$i],
                'harga' => $this->hargaSampah($jenis),
                'total_penjualan' => $request->total_penjualan[$i],
            ]);
        }

        return redirect()->route('sales.index')->with('success', 'Data berhasil diperbarui.');
    }

    private function hargaSampah($jenis)
    {
        $harga = [
            'kardus' => 1500,
            'botol' => 2000,
            'logam' => 4500,
            'kertas hvs' => 900,
            'kertas duplex' => 1200,
            'tembaga' => 7500,
            'ban motor' => 700,
        ];

        return $harga[$jenis] ?? 0;
    }

    public function destroy($id)
    {
        $penjualan = Penjualan::findOrFail($id);


        if ($penjualan->bukti) {
            Storage::delete('bukti/' . $penjualan->bukti);
        }


        $penjualan->details()->delete();


        $penjualan->delete();

        return redirect()->route('sales.index')->with('success', 'Data berhasil dihapus.');
    }
}

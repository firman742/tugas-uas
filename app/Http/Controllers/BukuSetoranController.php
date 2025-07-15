<?php

namespace App\Http\Controllers;

use App\Models\BukuSetoran;
use Illuminate\Http\Request;
use App\Models\Setoran;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
// use Maatwebsite\Excel\Facades\Excel;
// use App\Exports\SetoranExport;
use App\Models\JenisSampah;


class BukuSetoranController extends Controller
{
    public function index(Request $request)
    {
        $query = BukuSetoran::with('user', 'jenisSampah')->latest();

        if (auth()->user()->role === 'nasabah') {
            $query->where('user_id', auth()->id());
        }

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('tanggal_setor', [$request->tanggal_awal, $request->tanggal_akhir]);
        }

        if ($request->filled('jenis')) {
            $query->where('jenis_sampah', 'like', '%' . $request->jenis . '%');
        }

        $setorans = $query->get();

        $labels = $setorans->pluck('nama');
        $values = $setorans->pluck('jumlah');

        return view('setoran.index', compact('setorans', 'labels', 'values'));
    }

    public function create()
    {
        $nasabahs = User::where('role', 'nasabah')->get();
        $jenisSampahs = \App\Models\JenisSampah::all();
        return view('setoran.create', compact('nasabahs', 'jenisSampahs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'tanggal_setor' => 'required|date',
            'jenis_sampah_id' => 'required|exists:jenis_sampahs,id',
            'berat' => 'required|numeric|min:0.1',
            'harga_per_kg' => 'required',
            'foto_bukti' => 'nullable|image|max:2048', // max 2MB
        ]);

        $hargaPerKg = (int) preg_replace('/[^0-9]/', '', $request->harga_per_kg);

        $total = $request->berat * $hargaPerKg;

        $fotoPath = null;
        if ($request->hasFile('foto_bukti')) {
            $fotoPath = $request->file('foto_bukti')->store('bukti', 'public');
        }

        $jenis = JenisSampah::findOrFail($request->jenis_sampah_id);

        BukuSetoran::create([
            'user_id' => $request->user_id,
            'tanggal_setor' => $request->tanggal_setor,
            'jenis_sampah_id' => $jenis->id,
            'berat' => $request->berat,
            'harga_per_kg' => $hargaPerKg,
            'total' => $total,
            'foto_bukti' => $fotoPath,
        ]);

        return redirect()->route('setoran.index')->with('success', 'Setoran berhasil disimpan.');
    }

    public function edit($id)
    {
        $setoran = BukuSetoran::findOrFail($id);
        $nasabahs = User::where('role', 'nasabah')->get();
        $jenisSampahs = JenisSampah::all();

        return view('setoran.edit', compact('setoran', 'nasabahs', 'jenisSampahs'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'tanggal_setor' => 'required|date',
            'jenis_sampah' => 'required|string',
            'berat' => 'required|numeric|min:0.1',
            'harga_per_kg' => 'required|numeric|min:1',
            'foto_bukti' => 'nullable|image|max:2048',
        ]);

        $setoran = BukuSetoran::findOrFail($id);

        $total = $request->berat * $request->harga_per_kg;

        if ($request->hasFile('foto_bukti')) {
            // hapus lama
            if ($setoran->foto_bukti) {
                \Storage::disk('public')->delete($setoran->foto_bukti);
            }

            $fotoPath = $request->file('foto_bukti')->store('bukti', 'public');
            $setoran->foto_bukti = $fotoPath;
        }

        $setoran->update([
            'user_id' => $request->user_id,
            'tanggal_setor' => $request->tanggal_setor,
            'jenis_sampah' => $request->jenis_sampah,
            'berat' => $request->berat,
            'harga_per_kg' => $request->harga_per_kg,
            'total' => $total,
        ]);

        return redirect()->route('setoran.index')->with('success', 'Setoran berhasil diupdate.');
    }

    public function destroy($id)
    {
        $setoran = BukuSetoran::findOrFail($id);

        if ($setoran->foto_bukti) {
            \Storage::disk('public')->delete($setoran->foto_bukti);
        }

        $setoran->delete();

        return redirect()->route('setoran.index')->with('success', 'Setoran berhasil dihapus.');
    }

    // public function exportPdf(Request $request)
    // {
    //     $setorans = $this->filterSetoran($request); // kita pakai helper biar konsisten

    //     $pdf = PDF::loadView('setoran.pdf', compact('setorans'));
    //     return $pdf->download('riwayat-setoran.pdf');
    // }

    // public function exportExcel(Request $request)
    // {
    //     return Excel::download(new SetoranExport($request), 'setoran.xlsx');
    // }

    public function updateStatus(Request $request, $id)
    {
        $setoran = BukuSetoran::findOrFail($id);
        $setoran->status = $request->status;
        $setoran->save();

        return redirect()->back()->with('success', 'Status berhasil diperbarui.');
    }

    public function ranking()
    {
        // Ambil total setoran per user (untuk ranking nasabah)
        $rankingNasabah = BukuSetoran::selectRaw('user_id, SUM(total) as jumlah')
            ->groupBy('user_id')
            ->with('user')
            ->orderByDesc('jumlah')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->user_id,
                    'nama' => $item->user->name ?? '-',
                    'jumlah' => $item->jumlah,
                ];
            });

        $labelsNasabah = $rankingNasabah->pluck('nama');
        $valuesNasabah = $rankingNasabah->pluck('jumlah');

        // Ambil total setoran per jenis sampah
        $rankingJenis = BukuSetoran::selectRaw('jenis_sampah_id, SUM(total) as jumlah')
            ->groupBy('jenis_sampah_id')
            ->with('jenisSampah')
            ->get()
            ->map(function ($item) {
                return [
                    'nama' => $item->jenisSampah->nama ?? '-',
                    'jumlah' => $item->jumlah,
                ];
            });

        $labelsJenis = $rankingJenis->pluck('nama');
        $valuesJenis = $rankingJenis->pluck('jumlah');

        return view('setoran.ranking-setoran', [
            'setorans' => $rankingNasabah,
            'labelsNasabah' => $labelsNasabah,
            'valuesNasabah' => $valuesNasabah,
            'labelsJenis' => $labelsJenis,
            'valuesJenis' => $valuesJenis,
        ]);
    }
}

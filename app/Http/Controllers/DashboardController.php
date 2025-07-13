<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setoran;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Kalau admin, tampilkan semua data seperti sebelumnya
        if ($user->role !== 'nasabah') {
            $totalSetoran = \App\Models\Setoran::sum('total');

            $perBulan = \App\Models\Setoran::selectRaw('MONTH(tanggal_setor) as bulan, SUM(total) as total')
                ->whereYear('tanggal_setor', now()->year)
                ->groupBy('bulan')
                ->orderBy('bulan')
                ->get();

            $labels = [];
            $data = [];

            for ($i = 1; $i <= 12; $i++) {
                $labels[] = date('F', mktime(0, 0, 0, $i, 1));
                $bulanData = $perBulan->firstWhere('bulan', $i);
                $data[] = $bulanData ? $bulanData->total : 0;
            }

            return view('dashboard', compact('totalSetoran', 'labels', 'data'));
        }

        // Kalau nasabah, tampilkan data pribadi
        else {
            $totalSetoran = \App\Models\Setoran::where('user_id', $user->id)->sum('total');
            $riwayat = \App\Models\Setoran::where('user_id', $user->id)->orderByDesc('tanggal_setor')->take(10)->get();

            return view('dashboard', compact('totalSetoran', 'riwayat'));
        }
    }
}
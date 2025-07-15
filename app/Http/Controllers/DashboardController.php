<?php

namespace App\Http\Controllers;

use App\Models\BukuSetoran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Kalau admin, tampilkan semua data seperti sebelumnya
        if ($user->role !== 'nasabah') {
            $totalSetoran = BukuSetoran::sum('total');

            $perBulan = BukuSetoran::selectRaw('MONTH(tanggal_setor) as bulan, SUM(total) as total')
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
            $totalSetoran = BukuSetoran::where('user_id', $user->id)->sum('total');
            $riwayat = BukuSetoran::where('user_id', $user->id)->orderByDesc('tanggal_setor')->take(10)->get();

            return view('dashboard', compact('totalSetoran', 'riwayat'));
        }
    }
}
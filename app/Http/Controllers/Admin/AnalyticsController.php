<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Distribusi;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function summary()
    {
        $totalDistribusi = Distribusi::count();
        $distribusiHariIni = Distribusi::whereDate('tanggal_pengiriman', today())->count();
        $distribusiPending = Distribusi::where('status', 'Pending')->count();
        $distribusiDalamPerjalanan = Distribusi::where('status', 'Di Perjalanan')->count();
        $distribusiTerkirim = Distribusi::where('status', 'Terkirim')->count();
        $totalPorsi = Distribusi::sum('jumlah_porsi');

        return response()->json([
            'total_distribusi' => $totalDistribusi,
            'distribusi_hari_ini' => $distribusiHariIni,
            'distribusi_pending' => $distribusiPending,
            'distribusi_dalam_perjalanan' => $distribusiDalamPerjalanan,
            'distribusi_terkirim' => $distribusiTerkirim,
            'total_porsi' => $totalPorsi,
        ]);
    }

    public function chartData()
    {
        // Data untuk chart status distribusi
        $statusData = Distribusi::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status');

        // Data distribusi per hari (7 hari terakhir) - kompatibilitas SQLite
        $dailyData = Distribusi::selectRaw("strftime('%Y-%m-%d', tanggal_pengiriman) as date, COUNT(*) as count")
            ->where('tanggal_pengiriman', '>=', now()->subDays(7)->format('Y-m-d'))
            ->groupByRaw("strftime('%Y-%m-%d', tanggal_pengiriman)")
            ->orderByRaw("strftime('%Y-%m-%d', tanggal_pengiriman)")
            ->get();

        return response()->json([
            'status_chart' => $statusData,
            'daily_chart' => $dailyData,
        ]);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Distribusi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    /**
     * Get summary metrics for the dashboard cards.
     */
    public function summary()
    {
        return response()->json([
            "total_distribusi" => Distribusi::count(),
            "distribusi_hari_ini" => Distribusi::whereDate(
                "tanggal_pengiriman",
                now()->toDateString(),
            )->count(),
            "distribusi_pending" => Distribusi::where(
                "status",
                "Pending",
            )->count(),
            "total_porsi" => Distribusi::sum("jumlah_porsi"),
            "total_komplain" => Distribusi::whereIn("status", [
                "Komplain",
                "Kendala",
            ])->count(),

            // PBI-24 Advanced Metrics
            "total_sekolah" => Distribusi::distinct("sekolah_tujuan")->count(
                "sekolah_tujuan",
            ),
            "avg_porsi" => round(Distribusi::avg("jumlah_porsi"), 1),
            "success_rate" =>
                Distribusi::count() > 0
                    ? round(
                        (Distribusi::whereIn("status", [
                            "Diterima",
                            "Diterima Sebagian",
                        ])->count() /
                            Distribusi::count()) *
                            100,
                        1,
                    )
                    : 0,
            "total_kendala" => Distribusi::where("status", "Kendala")->count(),
        ]);
    }

    /**
     * Get data for charts.
     */
    public function chartData()
    {
        // 1. Status Chart Data
        $statusChart = Distribusi::select(
            "status",
            DB::raw("count(*) as count"),
        )
            ->groupBy("status")
            ->pluck("count", "status");

        // 2. Daily Trend Data (Last 7 Days)
        $dailyChart = Distribusi::selectRaw(
            "DATE(tanggal_pengiriman) as date, count(*) as count",
        )
            ->groupBy("date")
            ->orderBy("date", "desc")
            ->limit(7)
            ->get()
            ->reverse()
            ->values();

        // 3. Top 5 Schools by Volume
        $topSchools = Distribusi::select(
            "sekolah_tujuan",
            DB::raw("SUM(jumlah_porsi) as total_porsi"),
        )
            ->groupBy("sekolah_tujuan")
            ->orderBy("total_porsi", "desc")
            ->limit(5)
            ->get();

        // 4. Top 5 Schools with Issues (Kendala)
        $topIssues = Distribusi::select(
            "sekolah_tujuan",
            DB::raw("count(*) as total_kendala"),
        )
            ->where("status", "Kendala")
            ->groupBy("sekolah_tujuan")
            ->orderBy("total_kendala", "desc")
            ->limit(5)
            ->get();

        return response()->json([
            "status_chart" => $statusChart,
            "daily_chart" => $dailyChart,
            "top_schools_chart" => $topSchools,
            "top_issues_chart" => $topIssues,
        ]);
    }
}

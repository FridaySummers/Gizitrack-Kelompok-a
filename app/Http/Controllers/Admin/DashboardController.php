<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalDistribusi = \App\Models\Distribusi::count();
        $totalKomplain = \App\Models\Distribusi::whereIn("status", [
            "Komplain",
            "Kendala",
        ])->count();
        $totalSekolah = \App\Models\User::where("role", "sekolah")->count();
        $totalPorsi = \App\Models\Distribusi::sum("jumlah_porsi");

        $successRate =
            $totalDistribusi > 0
                ? round(
                        (\App\Models\Distribusi::whereIn("status", [
                            "Diterima",
                            "Diterima Sebagian",
                        ])->count() /
                            $totalDistribusi) *
                            100,
                        1,
                    ) . "%"
                : "0%";

        $distribusiTerbaru = \App\Models\Distribusi::latest()->take(5)->get();

        $recentUsers = [];
        if (auth()->user()->isSuperAdmin()) {
            $recentUsers = \App\Models\User::where("id", "!=", auth()->id())
                ->latest()
                ->take(5)
                ->get();
        }

        return view(
            "admin.dashboard",
            compact(
                "totalDistribusi",
                "totalKomplain",
                "totalSekolah",
                "totalPorsi",
                "successRate",
                "distribusiTerbaru",
                "recentUsers",
            ),
        );
    }
}

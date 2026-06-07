<?php

namespace App\Http\Controllers\Sekolah;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $sekolahId = auth()->id();

        $pengirimanAktif = \App\Models\Distribusi::where(
            "sekolah_id",
            $sekolahId,
        )
            ->whereIn("status", ["Dikirim", "Di Perjalanan"])
            ->count();

        $totalDiterima = \App\Models\Distribusi::where("sekolah_id", $sekolahId)
            ->where("status", "Diterima")
            ->count();

        $totalKomplain = \App\Models\Distribusi::where("sekolah_id", $sekolahId)
            ->where("status", "Diterima Sebagian")
            ->count();

        $distribusiTerbaru = \App\Models\Distribusi::with(["vendor", "menu"])
            ->where("sekolah_id", $sekolahId)
            ->latest()
            ->take(5)
            ->get();

        return view(
            "sekolah.dashboard",
            compact(
                "pengirimanAktif",
                "totalDiterima",
                "totalKomplain",
                "distribusiTerbaru",
            ),
        );
    }
}

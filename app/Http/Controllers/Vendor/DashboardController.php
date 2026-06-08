<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $vendorId = auth()->id();

        $totalMenu = \App\Models\Menu::where("vendor_id", $vendorId)->count();

        $pengirimanAktif = \App\Models\Distribusi::where("vendor_id", $vendorId)
            ->where("status", "Dikirim")
            ->count();

        $totalDiterima = \App\Models\Distribusi::where("vendor_id", $vendorId)
            ->where("status", "Diterima")
            ->count();

        $totalKomplain = \App\Models\Distribusi::where("vendor_id", $vendorId)
            ->where("status", "Komplain")
            ->count();

        $distribusiTerbaru = \App\Models\Distribusi::with(["menu"])
            ->where("vendor_id", $vendorId)
            ->latest()
            ->take(5)
            ->get();

        return view(
            "vendor.dashboard",
            compact(
                "totalMenu",
                "pengirimanAktif",
                "totalDiterima",
                "totalKomplain",
                "distribusiTerbaru",
            ),
        );
    }
}

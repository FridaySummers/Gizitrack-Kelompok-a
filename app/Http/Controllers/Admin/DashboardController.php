<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalDistribusi = \App\Models\Distribusi::count();
        $totalVendor = \App\Models\User::where("role", "vendor")->count();
        $totalSekolah = \App\Models\User::where("role", "sekolah")->count();

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
                "totalVendor",
                "totalSekolah",
                "distribusiTerbaru",
                "recentUsers",
            ),
        );
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Distribusi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function export(Request $request)
    {
        $startDate = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->format('Y-m-d'));

        $distribusis = Distribusi::where('tanggal_pengiriman', '>=', $startDate)
            ->where('tanggal_pengiriman', '<=', $endDate)
            ->orderBy('tanggal_pengiriman')
            ->get();

        $summary = [
            'total_distribusi' => $distribusis->count(),
            'total_porsi' => $distribusis->sum('jumlah_porsi'),
            'status_summary' => $distribusis->groupBy('status')->map->count(),
            'periode' => $startDate . ' sampai ' . $endDate,
        ];

        $pdf = Pdf::loadView('admin.reports.distribusi', compact('distribusis', 'summary'));

        return $pdf->download('laporan-distribusi-' . $startDate . '-to-' . $endDate . '.pdf');
    }
}
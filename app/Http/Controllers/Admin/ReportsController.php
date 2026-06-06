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
        $query = Distribusi::query();

        if ($request->has('start_date') && $request->has('end_date') && !empty($request->start_date) && !empty($request->end_date)) {
            $startDate = $request->get('start_date');
            $endDate = $request->get('end_date');
            
            $query->whereDate('tanggal_pengiriman', '>=', $startDate)
                  ->whereDate('tanggal_pengiriman', '<=', $endDate);
                  
            $periode = $startDate . ' sampai ' . $endDate;
            $filename = 'laporan-distribusi-' . $startDate . '-to-' . $endDate . '.pdf';
        } else {
            $periode = 'Semua Waktu';
            $filename = 'laporan-distribusi-semua-waktu.pdf';
        }

        $distribusis = $query->orderBy('tanggal_pengiriman')->get();

        $summary = [
            'total_distribusi' => $distribusis->count(),
            'total_porsi' => $distribusis->sum('jumlah_porsi'),
            'status_summary' => $distribusis->groupBy('status')->map->count(),
            'periode' => $periode,
        ];

        $pdf = Pdf::loadView('admin.reports.distribusi', compact('distribusis', 'summary'));

        return $pdf->download($filename);
    }
}
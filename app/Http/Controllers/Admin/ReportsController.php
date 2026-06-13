<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Distribusi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Exports\DistributionsExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportsController extends Controller
{
    public function exportExcel(Request $request)
    {
        $startDate = $request->get("start_date");
        $endDate = $request->get("end_date");

        $query = Distribusi::query();
        if ($startDate && $endDate) {
            $query
                ->whereDate("tanggal_pengiriman", ">=", $startDate)
                ->whereDate("tanggal_pengiriman", "<=", $endDate);
        }

        if ($query->count() === 0) {
            return back()->with(
                "error",
                "Tidak ada data untuk periode tersebut.",
            );
        }

        $filename =
            "Laporan_Distribusi_" .
            ($startDate ?? "all") .
            "_to_" .
            ($endDate ?? "all") .
            ".xlsx";

        // Check if Laravel Excel is available
        if (class_exists(\Maatwebsite\Excel\Facades\Excel::class)) {
            return Excel::download(
                new DistributionsExport($startDate, $endDate),
                $filename,
            );
        }

        // Fallback: Native CSV
        return $this->exportCsvFallback($startDate, $endDate);
    }

    private function exportCsvFallback($startDate, $endDate)
    {
        $filename =
            "Laporan_Distribusi_" .
            ($startDate ?? "all") .
            "_to_" .
            ($endDate ?? "all") .
            ".csv";

        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=\"$filename\"",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0",
        ];

        $callback = function () use ($startDate, $endDate) {
            $file = fopen("php://output", "w");

            // Add UTF-8 BOM for Excel compatibility
            fprintf($file, chr(0xef) . chr(0xbb) . chr(0xbf));

            fputcsv($file, [
                "ID Pesanan",
                "Vendor",
                "Sekolah",
                "Tanggal Pengiriman",
                "Status",
                "Jumlah Porsi",
            ]);

            $query = Distribusi::with(["vendor", "sekolah"]);
            if ($startDate && $endDate) {
                $query
                    ->whereDate("tanggal_pengiriman", ">=", $startDate)
                    ->whereDate("tanggal_pengiriman", "<=", $endDate);
            }

            $query
                ->orderBy("tanggal_pengiriman", "asc")
                ->chunk(100, function ($distribusis) use ($file) {
                    foreach ($distribusis as $distribusi) {
                        fputcsv($file, [
                            "#" . $distribusi->id,
                            $distribusi->vendor->name ??
                            $distribusi->sekolah_tujuan,
                            $distribusi->sekolah->name ??
                            $distribusi->sekolah_tujuan,
                            \Carbon\Carbon::parse(
                                $distribusi->tanggal_pengiriman,
                            )->format("d/m/Y"),
                            $distribusi->status,
                            $distribusi->jumlah_porsi,
                        ]);
                    }
                });

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function export(Request $request)
    {
        $query = Distribusi::query();

        if (
            $request->has("start_date") &&
            $request->has("end_date") &&
            !empty($request->start_date) &&
            !empty($request->end_date)
        ) {
            $startDate = $request->get("start_date");
            $endDate = $request->get("end_date");

            $query
                ->whereDate("tanggal_pengiriman", ">=", $startDate)
                ->whereDate("tanggal_pengiriman", "<=", $endDate);

            $periode = $startDate . " sampai " . $endDate;
            $filename =
                "laporan-distribusi-" . $startDate . "-to-" . $endDate . ".pdf";
        } else {
            $periode = "Semua Waktu";
            $filename = "laporan-distribusi-semua-waktu.pdf";
        }

        $distribusis = $query->orderBy("tanggal_pengiriman")->get();

        $summary = [
            "total_distribusi" => $distribusis->count(),
            "total_porsi" => $distribusis->sum("jumlah_porsi"),
            "status_summary" => $distribusis->groupBy("status")->map->count(),
            "periode" => $periode,
        ];

        $pdf = Pdf::loadView(
            "admin.reports.distribusi",
            compact("distribusis", "summary"),
        );

        return $pdf->download($filename);
    }
}

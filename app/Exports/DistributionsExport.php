<?php

namespace App\Exports;

use App\Models\Distribusi;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\Exportable;

class DistributionsExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function query()
    {
        $query = Distribusi::with(['vendor', 'sekolah']);

        if ($this->startDate && $this->endDate) {
            $query->whereDate('tanggal_pengiriman', '>=', $this->startDate)
                  ->whereDate('tanggal_pengiriman', '<=', $this->endDate);
        }

        return $query->orderBy('tanggal_pengiriman', 'asc');
    }

    public function headings(): array
    {
        return [
            'ID Pesanan',
            'Vendor',
            'Sekolah',
            'Tanggal Pengiriman',
            'Status',
            'Jumlah Porsi',
        ];
    }

    public function map($distribusi): array
    {
        return [
            '#' . $distribusi->id,
            $distribusi->vendor->name ?? $distribusi->sekolah_tujuan, // Fallback if relationship missing
            $distribusi->sekolah->name ?? $distribusi->sekolah_tujuan,
            \Carbon\Carbon::parse($distribusi->tanggal_pengiriman)->format('d/m/Y'),
            $distribusi->status,
            $distribusi->jumlah_porsi,
        ];
    }
}

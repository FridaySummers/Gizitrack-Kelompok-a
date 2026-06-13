<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Distribusi Makanan</title>
    <style>
        @page { margin: 1cm; }
        body { font-family: 'Helvetica', 'Arial', sans-serif; color: #1e293b; line-height: 1.5; font-size: 11px; margin: 0; padding: 0; }
        .container { padding: 20px; }
        .header { text-align: left; border-bottom: 2px solid #10b981; padding-bottom: 20px; margin-bottom: 30px; position: relative; }
        .header h1 { color: #10b981; font-size: 24px; font-weight: 900; margin: 0; text-transform: uppercase; letter-spacing: -1px; }
        .header h2 { font-size: 14px; color: #64748b; margin: 5px 0 0 0; font-weight: normal; }
        .meta { margin-top: 15px; font-size: 10px; color: #94a3b8; font-weight: bold; text-transform: uppercase; }

        .section-title { font-size: 12px; font-weight: 900; color: #1e293b; text-transform: uppercase; margin: 30px 0 15px 0; border-left: 4px solid #10b981; padding-left: 10px; }

        .summary-grid { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .summary-card { background: #f8fafc; border: 1px solid #e2e8f0; padding: 15px; border-radius: 8px; text-align: center; }
        .summary-value { font-size: 20px; font-weight: 900; color: #10b981; display: block; }
        .summary-label { font-size: 9px; font-weight: bold; color: #64748b; text-transform: uppercase; }

        table { width: 100%; border-collapse: collapse; margin-top: 10px; border-radius: 8px; overflow: hidden; }
        th { background-color: #f1f5f9; color: #475569; font-weight: 900; text-transform: uppercase; font-size: 9px; padding: 12px 10px; text-align: left; border-bottom: 1px solid #e2e8f0; }
        td { padding: 10px; border-bottom: 1px solid #f1f5f9; color: #334155; }

        .badge { display: inline-block; padding: 3px 8px; border-radius: 12px; font-size: 8px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.5px; }
        .badge-pending { background-color: #fef3c7; color: #92400e; }
        .badge-di-perjalanan { background-color: #dbeafe; color: #1e40af; }
        .badge-diterima { background-color: #d1fae5; color: #065f46; }
        .badge-komplain { background-color: #fee2e2; color: #991b1b; }
        .badge-kendala { background-color: #fee2e2; color: #991b1b; }

        .footer { position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 8px; color: #94a3b8; padding: 20px 0; border-top: 1px solid #f1f5f9; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>GiziTrack</h1>
            <h2>Laporan Distribusi Logistik Makanan Sehat</h2>
            <div class="meta">Periode Laporan: {{ $summary['periode'] }}</div>
        </div>

        <div class="section-title">Ringkasan Eksekutif</div>
        <table style="width: 100%; border: none;">
            <tr>
                <td style="width: 50%; padding: 0 10px 0 0; border: none;">
                    <div class="summary-card">
                        <span class="summary-value">{{ $summary['total_distribusi'] }}</span>
                        <span class="summary-label">Total Transaksi Distribusi</span>
                    </div>
                </td>
                <td style="width: 50%; padding: 0 0 0 10px; border: none;">
                    <div class="summary-card">
                        <span class="summary-value">{{ number_format($summary['total_porsi']) }}</span>
                        <span class="summary-label">Total Volume Porsi</span>
                    </div>
                </td>
            </tr>
        </table>

        <div class="section-title">Distribusi Berdasarkan Status</div>
        <table style="margin-bottom: 30px;">
            <thead>
                <tr>
                    <th>Status Operasional</th>
                    <th style="text-align: right;">Jumlah Transaksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($summary['status_summary'] as $status => $count)
                <tr>
                    <td style="font-weight: bold;">{{ $status }}</td>
                    <td style="text-align: right; font-weight: 900; color: #10b981;">{{ $count }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="section-title">Audit Trail Detail Logistik</div>
        <table>
            <thead>
                <tr>
                    <th style="width: 40px;">ID</th>
                    <th style="width: 80px;">Tanggal</th>
                    <th>Sekolah Tujuan</th>
                    <th style="width: 60px; text-align: center;">Porsi</th>
                    <th style="width: 80px;">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($distribusis as $distribusi)
                <tr>
                    <td style="color: #94a3b8; font-family: monospace;">#{{ $distribusi->id }}</td>
                    <td style="font-weight: bold;">{{ \Carbon\Carbon::parse($distribusi->tanggal_pengiriman)->format('d/m/Y') }}</td>
                    <td style="font-weight: 900;">{{ $distribusi->sekolah_tujuan }}</td>
                    <td style="text-align: center; font-weight: bold;">{{ $distribusi->jumlah_porsi }}</td>
                    <td>
                        @php
                            $statusSlug = strtolower(str_replace(' ', '-', $distribusi->status));
                        @endphp
                        <span class="badge badge-{{ $statusSlug }}">{{ $distribusi->status }}</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="footer">
            Dokumen ini dihasilkan secara digital oleh Sistem Manajemen GiziTrack pada {{ now()->format('d F Y H:i:s') }}.
            <br>Seluruh data bersifat rahasia dan untuk kepentingan audit internal.
        </div>
    </div>
</body>
</html>

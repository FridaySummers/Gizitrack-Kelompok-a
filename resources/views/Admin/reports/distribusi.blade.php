<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Distribusi Makanan</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .header { text-align: center; margin-bottom: 30px; }
        .summary { margin-bottom: 30px; }
        .summary table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .summary th, .summary td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .summary th { background-color: #f2f2f2; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .status-pending { background-color: #fef3c7; }
        .status-di-perjalanan { background-color: #dbeafe; }
        .status-terkirim { background-color: #d1fae5; }
        .status-diterima { background-color: #d1fae5; }
        .status-diterima-sebagian { background-color: #fef3c7; }
        .status-kendala { background-color: #fee2e2; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Distribusi Makanan</h1>
        <h2>GiziTrack</h2>
        <p>Periode: {{ $summary['periode'] }}</p>
    </div>

    <div class="summary">
        <h3>Ringkasan</h3>
        <table>
            <tr>
                <th>Total Distribusi</th>
                <td>{{ $summary['total_distribusi'] }}</td>
            </tr>
            <tr>
                <th>Total Porsi</th>
                <td>{{ $summary['total_porsi'] }}</td>
            </tr>
        </table>

        <h4>Status Distribusi</h4>
        <table>
            <tr>
                <th>Status</th>
                <th>Jumlah</th>
            </tr>
            @foreach($summary['status_summary'] as $status => $count)
            <tr>
                <td>{{ $status }}</td>
                <td>{{ $count }}</td>
            </tr>
            @endforeach
        </table>
    </div>

    <h3>Detail Distribusi</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tanggal Pengiriman</th>
                <th>Sekolah Tujuan</th>
                <th>Jumlah Porsi</th>
                <th>Status</th>
                <th>Catatan Kendala</th>
            </tr>
        </thead>
        <tbody>
            @foreach($distribusis as $distribusi)
            <tr class="status-{{ strtolower(str_replace(' ', '-', $distribusi->status)) }}">
                <td>{{ $distribusi->id }}</td>
                <td>{{ $distribusi->tanggal_pengiriman }}</td>
                <td>{{ $distribusi->sekolah_tujuan }}</td>
                <td>{{ $distribusi->jumlah_porsi }}</td>
                <td>{{ $distribusi->status }}</td>
                <td>{{ $distribusi->catatan_kendala ?: '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 50px; text-align: center; font-size: 12px; color: #666;">
        <p>Laporan ini dibuat secara otomatis pada {{ now()->format('d/m/Y H:i') }}</p>
    </div>
</body>
</html>
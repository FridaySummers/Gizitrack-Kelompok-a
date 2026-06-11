@extends('layouts.sidebar')

@section('title', 'Dashboard Admin')

@section('content')
<div class="mb-8 p-8 bg-white rounded-2xl border border-gray-100 shadow-sm transition-all duration-300 hover:shadow-md">
    <div class="flex items-center justify-between gap-4 flex-wrap">
        <div>
            <h2 class="text-2xl font-black text-gray-800 tracking-tight">Halo {{ auth()->user()->role->label() ?? 'Admin' }}! 🛡️</h2>
            <p class="text-gray-500 mt-1 font-medium">Pantau seluruh ekosistem distribusi gizi sekolah secara real-time.</p>
        </div>
        <div class="flex items-center gap-2 text-xs font-black uppercase tracking-widest text-emerald-600 bg-emerald-50 px-4 py-2 rounded-full border border-emerald-100/50">
            <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
            Sistem Terpusat Aktif
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 transition-all duration-300 hover:shadow-lg hover:-translate-y-1 group">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center group-hover:bg-blue-100 transition-colors duration-300">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <span class="text-[10px] font-black uppercase tracking-widest text-blue-600 bg-blue-50 px-2.5 py-1 rounded-lg">Logistik</span>
        </div>
        <p class="text-xs text-gray-500 font-black uppercase tracking-widest">Total Distribusi</p>
        <p class="text-4xl font-black text-gray-800 mt-2" id="total-distribusi">{{ $totalDistribusi ?? 0 }}</p>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 transition-all duration-300 hover:shadow-lg hover:-translate-y-1 group">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center group-hover:bg-emerald-100 transition-colors duration-300">
                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-1 4h1m2-8v2m0 2v2m0-2h2m-2 0H9"></path></svg>
            </div>
            <span class="text-[10px] font-black uppercase tracking-widest text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-lg">Partner</span>
        </div>
        <p class="text-xs text-gray-500 font-black uppercase tracking-widest">Total Vendor</p>
        <p class="text-4xl font-black text-gray-800 mt-2">{{ $totalVendor ?? 0 }}</p>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 transition-all duration-300 hover:shadow-lg hover:-translate-y-1 group">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center group-hover:bg-purple-100 transition-colors duration-300">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354v4.512c0 .158-.05.31-.145.428l-3.428 4.285c-.285.356-.428.802-.428 1.27v.513c0 .802-.65 1.454-1.454 1.454H6.5c-.802 0-1.454-.65-1.454-1.454V14.86c0-.468.143-.914.428-1.27l3.428-4.285c.095-.118.145-.27.145-.428V4.354a1.5 1.5 0 011.5-1.5h2.854a1.5 1.5 0 011.5 1.5z"></path></svg>
            </div>
            <span class="text-[10px] font-black uppercase tracking-widest text-purple-600 bg-purple-50 px-2.5 py-1 rounded-lg">Instansi</span>
        </div>
        <p class="text-xs text-gray-500 font-black uppercase tracking-widest">Total Sekolah</p>
        <p class="text-4xl font-black text-gray-800 mt-2" id="total-sekolah">{{ $totalSekolah ?? 0 }}</p>
    </div>
</div>

<!-- Export Report Section -->
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8 mb-8 overflow-hidden relative group">
    <!-- Dekorasi aksen hijau di kiri -->
    <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-emerald-600 group-hover:w-2 transition-all"></div>
    <div class="flex flex-wrap items-center justify-between gap-6 relative z-10">
        <div class="shrink-0">
            <h3 class="text-lg font-black text-gray-800 uppercase tracking-tight">Unduh Laporan Distribusi</h3>
            <p class="text-sm text-gray-500 mt-1 font-medium">Pilih periode tanggal untuk mengunduh laporan dalam format PDF.</p>
        </div>
        <form action="{{ route('admin.reports.export') }}" method="GET" class="flex flex-row flex-wrap items-end gap-4 shrink-0 lg:ml-auto">
            <div class="space-y-2">
                <label for="start_date" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Mulai</label>
                <input type="date" name="start_date" id="start_date" value="{{ now()->startOfMonth()->format('Y-m-d') }}" class="rounded-xl border-gray-200 shadow-sm focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 text-sm h-[48px] px-4 bg-gray-50/50 transition-all outline-none">
            </div>
            <div class="space-y-2">
                <label for="end_date" class="block text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Selesai</label>
                <input type="date" name="end_date" id="end_date" value="{{ now()->format('Y-m-d') }}" class="rounded-xl border-gray-200 shadow-sm focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/20 text-sm h-[48px] px-4 bg-gray-50/50 transition-all outline-none">
            </div>
            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-black py-2 px-6 rounded-xl text-xs uppercase tracking-widest inline-flex items-center justify-center shadow-lg shadow-emerald-200/50 transition-all transform hover:scale-[1.02] active:scale-[0.98] h-[48px]">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                </svg>
                Unduh PDF
            </button>
        </form>
    </div>
</div>

<!-- Chart Section -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8 h-full flex flex-col transition-all duration-300 hover:shadow-lg">
        <h3 class="text-sm font-black uppercase tracking-widest mb-6 text-gray-800 flex items-center shrink-0">
            <span class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center mr-4">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path></svg>
            </span>
            Status Distribusi
        </h3>
        <div class="relative w-full flex-1 min-h-[300px]">
            <canvas id="statusChart"></canvas>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8 h-full flex flex-col transition-all duration-300 hover:shadow-lg">
        <h3 class="text-sm font-black uppercase tracking-widest mb-6 text-gray-800 flex items-center shrink-0">
            <span class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center mr-4">
                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path></svg>
            </span>
            Tren Distribusi (7 Hari Terakhir)
        </h3>
        <div class="relative w-full flex-1 min-h-[300px]">
            <canvas id="dailyChart"></canvas>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8 h-full flex flex-col transition-all duration-300 hover:shadow-lg">
        <h3 class="text-sm font-black uppercase tracking-widest mb-6 text-gray-800 flex items-center shrink-0">
            <span class="w-10 h-10 rounded-xl bg-orange-50 flex items-center justify-center mr-4">
                <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
            </span>
            Top 5 Sekolah (Porsi Terbanyak)
        </h3>
        <div class="relative w-full flex-1 min-h-[300px]">
            <canvas id="topSchoolsChart"></canvas>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8 h-full flex flex-col transition-all duration-300 hover:shadow-lg">
        <h3 class="text-sm font-black uppercase tracking-widest mb-6 text-gray-800 flex items-center shrink-0">
            <span class="w-10 h-10 rounded-xl bg-red-50 flex items-center justify-center mr-4">
                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </span>
            Top 5 Sekolah (Kendala Terbanyak)
        </h3>
        <div class="relative w-full flex-1 min-h-[300px]">
            <canvas id="topIssuesChart"></canvas>
        </div>
    </div>
</div>

<!-- Live Tracking Table -->
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-8 transition-all duration-300 hover:shadow-md">
    <div class="px-8 py-6 border-b border-gray-100 flex items-center justify-between bg-white">
        <div class="flex items-center gap-3">
            <div class="relative flex h-3 w-3">
              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
              <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-600"></span>
            </div>
            <h3 class="font-black text-gray-800 text-lg uppercase tracking-tight">Live Tracking Pengiriman</h3>
        </div>
        <a href="{{ route('admin.distributions.index') }}" class="text-xs font-black uppercase tracking-widest text-emerald-600 hover:text-emerald-700 bg-emerald-50 px-4 py-2 rounded-xl transition-all hover:scale-[1.02] active:scale-[0.98]">Kelola Distribusi →</a>
    </div>
    <div class="relative overflow-x-auto">
        <table id="tracking-table" class="w-full text-sm text-left text-gray-600">
            <thead class="text-[10px] text-gray-400 uppercase bg-gray-50/80 font-black tracking-widest">
                <tr>
                    <th scope="col" class="px-8 py-4">ID</th>
                    <th scope="col" class="px-8 py-4">Sekolah Tujuan</th>
                    <th scope="col" class="px-8 py-4 text-center">Jumlah Porsi</th>
                    <th scope="col" class="px-8 py-4">Tanggal</th>
                    <th scope="col" class="px-8 py-4">Status</th>
                    <th scope="col" class="px-8 py-4">Lat</th>
                    <th scope="col" class="px-8 py-4">Lng</th>
                    <th scope="col" class="px-8 py-4">Aksi</th>
                </tr>
            </thead>
            <tbody id="tracking-body" class="divide-y divide-gray-100">
                <!-- Data loaded via JS -->
                <tr>
                    <td colspan="8" class="px-8 py-16 text-center">
                        <div class="flex flex-col justify-center items-center">
                            <svg class="animate-spin h-10 w-10 text-emerald-600 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span class="text-gray-400 font-black uppercase tracking-widest text-xs">Memuat data live tracking...</span>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        function loadTrackingData() {
            fetch('/admin/api/distribusi')
                .then(response => response.json())
                .then(data => {
                    const tbody = document.getElementById('tracking-body');
                    if (data.length === 0) {
                        tbody.innerHTML = `
                            <tr>
                                <td colspan="8" class="px-8 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center text-gray-400">
                                        <div class="w-20 h-20 bg-gray-50 rounded-2xl flex items-center justify-center mb-4 border border-gray-100">
                                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        </div>
                                        <p class="text-lg font-bold text-gray-500 tracking-tight">Belum ada data distribusi.</p>
                                    </div>
                                </td>
                            </tr>
                        `;
                        return;
                    }

                    tbody.innerHTML = '';
                    data.forEach(distribusi => {
                        const statusColors = {
                            'Pending': 'bg-amber-50 text-amber-700 border-amber-100',
                            'Dikirim': 'bg-blue-50 text-blue-700 border-blue-100',
                            'Di Perjalanan': 'bg-blue-50 text-blue-700 border-blue-100',
                            'Terkirim': 'bg-emerald-50 text-emerald-700 border-emerald-100',
                            'Diterima': 'bg-green-50 text-green-700 border-green-100',
                            'Diterima Sebagian': 'bg-orange-50 text-orange-700 border-orange-100',
                            'Komplain': 'bg-red-50 text-red-700 border-red-100',
                            'Kendala': 'bg-red-50 text-red-700 border-red-100'
                        };
                        const colorClass = statusColors[distribusi.status] || 'bg-gray-50 text-gray-700 border-gray-100';

                        const mapLink = (distribusi.latitude && distribusi.longitude)
                            ? `<a href="https://www.google.com/maps?q=${distribusi.latitude},${distribusi.longitude}" target="_blank" class="text-blue-600 hover:text-blue-800 flex items-center font-bold bg-blue-50 px-3 py-1.5 rounded-xl w-max transition-all hover:scale-[1.05] active:scale-[0.95]">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                Map
                               </a>`
                            : '<span class="text-gray-400 font-bold bg-gray-50 px-3 py-1.5 rounded-lg">-</span>';

                        // Format date
                        let dateObj = new Date(distribusi.tanggal_pengiriman);
                        let dateStr = dateObj.toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' });

                        const row = document.createElement('tr');
                        row.className = 'hover:bg-gray-50/50 transition-colors group';
                        row.innerHTML = `
                            <td class="px-8 py-5 whitespace-nowrap text-sm font-bold text-gray-900 group-hover:text-emerald-600 transition-colors">#${distribusi.id}</td>
                            <td class="px-8 py-5 whitespace-nowrap text-sm text-gray-900 font-black">${distribusi.sekolah_tujuan}</td>
                            <td class="px-8 py-5 whitespace-nowrap text-sm text-gray-700 text-center font-black">${distribusi.jumlah_porsi}</td>
                            <td class="px-8 py-5 whitespace-nowrap text-sm text-gray-600 font-bold">${dateStr}</td>
                            <td class="px-8 py-5 whitespace-nowrap">
                                <span class="px-3.5 py-1.5 inline-flex text-xs font-black rounded-full border ${colorClass}">
                                    <span class="w-1.5 h-1.5 rounded-full mr-2 bg-current opacity-70"></span>
                                    ${distribusi.status}
                                </span>
                            </td>
                            <td class="px-8 py-5 whitespace-nowrap text-sm text-gray-400 font-mono text-xs group-hover:text-gray-600 transition-colors">${distribusi.latitude || '-'}</td>
                            <td class="px-8 py-5 whitespace-nowrap text-sm text-gray-400 font-mono text-xs group-hover:text-gray-600 transition-colors">${distribusi.longitude || '-'}</td>
                            <td class="px-8 py-5 whitespace-nowrap text-sm">${mapLink}</td>
                        `;
                        tbody.appendChild(row);
                    });
                })
                .catch(error => console.error('Error loading tracking data:', error));
        }

        function loadSummaryData() {
            fetch('/admin/api/analytics/summary')
                .then(response => response.json())
                .then(data => {
                    // Update stats directly on the UI
                    if(document.getElementById('total-distribusi')) document.getElementById('total-distribusi').textContent = data.total_distribusi || 0;
                    if(document.getElementById('total-sekolah')) document.getElementById('total-sekolah').textContent = data.total_sekolah || 0;
                    // Note: totalVendor is passed from controller, keeping it as is unless we add it to the API response
                })
                .catch(error => console.error('Error loading summary data:', error));
        }

        let statusChart, dailyChart, topSchoolsChart, topIssuesChart;

        function loadChartData() {
            fetch('/admin/api/analytics/chart')
                .then(response => response.json())
                .then(data => {
                    const statusCtx = document.getElementById('statusChart');
                    if (statusCtx) {
                        if (statusChart) statusChart.destroy();
                        statusChart = new Chart(statusCtx, {
                            type: 'doughnut',
                            data: {
                                labels: Object.keys(data.status_chart || {}),
                                datasets: [{
                                    data: Object.values(data.status_chart || {}),
                                    backgroundColor: ['#EAB308', '#3B82F6', '#22C55E', '#10B981', '#F97316', '#EF4444'],
                                    borderWidth: 0,
                                    hoverOffset: 15
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: { position: 'bottom', labels: { usePointStyle: true, padding: 25, font: { family: "'Figtree', sans-serif", weight: '700', size: 12 } } }
                                },
                                cutout: '75%'
                            }
                        });
                    }

                    const dailyCtx = document.getElementById('dailyChart');
                    if (dailyCtx && data.daily_chart) {
                        if (dailyChart) dailyChart.destroy();
                        dailyChart = new Chart(dailyCtx, {
                            type: 'line',
                            data: {
                                labels: data.daily_chart.map(item => {
                                    let d = new Date(item.date);
                                    return d.toLocaleDateString('id-ID', {day:'numeric', month:'short'});
                                }),
                                datasets: [{
                                    label: 'Pengiriman',
                                    data: data.daily_chart.map(item => item.count),
                                    borderColor: '#6366F1',
                                    backgroundColor: 'rgba(99, 102, 241, 0.05)',
                                    fill: true,
                                    tension: 0.4,
                                    pointBackgroundColor: '#6366F1',
                                    pointBorderColor: '#fff',
                                    pointBorderWidth: 3,
                                    pointRadius: 5,
                                    pointHoverRadius: 8
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                scales: {
                                    y: { beginAtZero: true, ticks: { stepSize: 1, font: { family: "'Figtree', sans-serif", weight: '600' } }, grid: { borderDash: [4, 4], color: '#f1f5f9' } },
                                    x: { grid: { display: false }, ticks: { font: { family: "'Figtree', sans-serif", weight: '600' } } }
                                },
                                plugins: {
                                    legend: { display: false }
                                }
                            }
                        });
                    }

                    const topCtx = document.getElementById('topSchoolsChart');
                    if (topCtx && data.top_schools_chart) {
                        if (topSchoolsChart) topSchoolsChart.destroy();
                        topSchoolsChart = new Chart(topCtx, {
                            type: 'bar',
                            data: {
                                labels: data.top_schools_chart.map(item => item.sekolah_tujuan.length > 15 ? item.sekolah_tujuan.substring(0, 15) + '...' : item.sekolah_tujuan),
                                datasets: [{
                                    label: 'Total Porsi',
                                    data: data.top_schools_chart.map(item => item.total_porsi),
                                    backgroundColor: '#F59E0B',
                                    borderRadius: 8,
                                    barPercentage: 0.5
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                indexAxis: 'y',
                                scales: {
                                    x: { beginAtZero: true, grid: { borderDash: [4, 4], color: '#f1f5f9' }, ticks: { font: { family: "'Figtree', sans-serif", weight: '600' } } },
                                    y: { grid: { display: false }, ticks: { font: { family: "'Figtree', sans-serif", weight: '700' } } }
                                },
                                plugins: {
                                    legend: { display: false }
                                }
                            }
                        });
                    }

                    const issuesCtx = document.getElementById('topIssuesChart');
                    if (issuesCtx && data.top_issues_chart) {
                        if (topIssuesChart) topIssuesChart.destroy();
                        topIssuesChart = new Chart(issuesCtx, {
                            type: 'bar',
                            data: {
                                labels: data.top_issues_chart.map(item => item.sekolah_tujuan.length > 15 ? item.sekolah_tujuan.substring(0, 15) + '...' : item.sekolah_tujuan),
                                datasets: [{
                                    label: 'Total Kendala',
                                    data: data.top_issues_chart.map(item => item.total_kendala),
                                    backgroundColor: '#EF4444',
                                    borderRadius: 8,
                                    barPercentage: 0.5
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                indexAxis: 'y',
                                scales: {
                                    x: { beginAtZero: true, ticks: { stepSize: 1, font: { family: "'Figtree', sans-serif", weight: '600' } }, grid: { borderDash: [4, 4], color: '#f1f5f9' } },
                                    y: { grid: { display: false }, ticks: { font: { family: "'Figtree', sans-serif", weight: '700' } } }
                                },
                                plugins: {
                                    legend: { display: false }
                                }
                            }
                        });
                    }
                })
                .catch(error => console.error('Error loading chart data:', error));
        }

        // Initial Load
        loadTrackingData();
        loadSummaryData();
        loadChartData();

        // Auto Refresh
        setInterval(loadTrackingData, 10000);
        setInterval(loadSummaryData, 30000);
        setInterval(loadChartData, 60000);
    });
</script>
@endpush

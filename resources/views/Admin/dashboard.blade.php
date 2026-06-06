<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard Admin — GiziTrack
            </h2>
            <a href="{{ route('admin.reports.export') }}" style="background-color: #0f172a !important;" class="hover:bg-slate-800 text-white font-bold py-2 px-4 rounded-lg text-sm inline-flex items-center justify-center shadow-lg transition-all transform hover:scale-105 whitespace-nowrap shrink-0 border border-slate-700 h-[42px] box-border">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                </svg>
                Unduh Laporan PDF
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <p class="text-gray-600">Selamat datang, Admin! 👋</p>
                <p class="text-sm text-gray-400 mt-2">
                    Modul: Kelola Akun Vendor & Sekolah akan dikerjakan di sini.
                </p>
            </div>

            <!-- Summary Dashboard (PBI-23 & PBI-24) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <!-- Total Distribusi -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-b-4 border-blue-500">
                    <div class="flex items-center">
                        <div class="p-2 bg-blue-100 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600 uppercase tracking-wider">Total Distribusi</p>
                            <p class="text-2xl font-bold text-gray-900" id="total-distribusi">-</p>
                        </div>
                    </div>
                </div>

                <!-- Total Porsi -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-b-4 border-purple-500">
                    <div class="flex items-center">
                        <div class="p-2 bg-purple-100 rounded-lg">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600 uppercase tracking-wider">Total Porsi</p>
                            <p class="text-2xl font-bold text-gray-900" id="total-porsi">-</p>
                        </div>
                    </div>
                </div>

                <!-- Success Rate -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-b-4 border-green-500">
                    <div class="flex items-center">
                        <div class="p-2 bg-green-100 rounded-lg">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600 uppercase tracking-wider">Tingkat Keberhasilan</p>
                            <p class="text-2xl font-bold text-gray-900" id="success-rate">-</p>
                        </div>
                    </div>
                </div>

                <!-- Total Sekolah -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-b-4 border-indigo-500">
                    <div class="flex items-center">
                        <div class="p-2 bg-indigo-100 rounded-lg">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600 uppercase tracking-wider">Sekolah Terjangkau</p>
                            <p class="text-2xl font-bold text-gray-900" id="total-sekolah">-</p>
                        </div>
                    </div>
                </div>

                <!-- Distribusi Hari Ini -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-b-4 border-emerald-500">
                    <div class="flex items-center">
                        <div class="p-2 bg-emerald-100 rounded-lg">
                            <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 4v10m0 0l-2-2m2 2l2-2"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600 uppercase tracking-wider">Distribusi Hari Ini</p>
                            <p class="text-2xl font-bold text-gray-900" id="distribusi-hari-ini">-</p>
                        </div>
                    </div>
                </div>

                <!-- Average Porsi -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-b-4 border-orange-500">
                    <div class="flex items-center">
                        <div class="p-2 bg-orange-100 rounded-lg">
                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600 uppercase tracking-wider">Rata-rata Porsi</p>
                            <p class="text-2xl font-bold text-gray-900" id="avg-porsi">-</p>
                        </div>
                    </div>
                </div>

                <!-- Pending -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-b-4 border-yellow-500">
                    <div class="flex items-center">
                        <div class="p-2 bg-yellow-100 rounded-lg">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600 uppercase tracking-wider">Antrean Pending</p>
                            <p class="text-2xl font-bold text-gray-900" id="distribusi-pending">-</p>
                        </div>
                    </div>
                </div>

                <!-- Total Kendala -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-b-4 border-red-500">
                    <div class="flex items-center">
                        <div class="p-2 bg-red-100 rounded-lg">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600 uppercase tracking-wider">Laporan Kendala</p>
                            <p class="text-2xl font-bold text-gray-900" id="total-kendala">-</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Export Report Section (PBI-26) -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6 border-l-4 border-green-500">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div class="shrink-0">
                        <h3 class="text-lg font-semibold text-gray-800">Unduh Laporan Distribusi</h3>
                        <p class="text-sm text-gray-500">Pilih periode tanggal untuk mengunduh laporan dalam format PDF.</p>
                    </div>
                    <form action="{{ route('admin.reports.export') }}" method="GET" class="flex flex-row flex-wrap items-end gap-3 shrink-0 ml-auto">
                        <div>
                            <label for="start_date" class="block text-xs font-medium text-gray-700 uppercase mb-1">Mulai</label>
                            <input type="date" name="start_date" id="start_date" value="{{ now()->startOfMonth()->format('Y-m-d') }}" class="rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 text-sm h-[42px] box-border">
                        </div>
                        <div>
                            <label for="end_date" class="block text-xs font-medium text-gray-700 uppercase mb-1">Selesai</label>
                            <input type="date" name="end_date" id="end_date" value="{{ now()->format('Y-m-d') }}" class="rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 text-sm h-[42px] box-border">
                        </div>
                        <button type="submit" style="background-color: #0f172a !important;" class="hover:bg-slate-800 text-white font-bold py-2 px-4 rounded-lg text-sm inline-flex items-center justify-center shadow-lg transition-all transform hover:scale-105 whitespace-nowrap shrink-0 border border-slate-700 h-[42px] box-border">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                            Unduh Laporan Distribusi
                        </button>
                    </form>
                </div>
            </div>

            <!-- Chart Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 h-full flex flex-col">
                    <h3 class="text-lg font-semibold mb-4 text-gray-700 flex items-center shrink-0">
                        <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path></svg>
                        Status Distribusi
                    </h3>
                    <div class="relative w-full flex-1 min-h-[300px]">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 h-full flex flex-col">
                    <h3 class="text-lg font-semibold mb-4 text-gray-700 flex items-center shrink-0">
                        <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path></svg>
                        Tren Distribusi (7 Hari Terakhir)
                    </h3>
                    <div class="relative w-full flex-1 min-h-[300px]">
                        <canvas id="dailyChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 h-full flex flex-col">
                    <h3 class="text-lg font-semibold mb-4 text-gray-700 flex items-center shrink-0">
                        <svg class="w-5 h-5 mr-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        Top 5 Sekolah (Porsi Terbanyak)
                    </h3>
                    <div class="relative w-full flex-1 min-h-[300px]">
                        <canvas id="topSchoolsChart"></canvas>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 h-full flex flex-col">
                    <h3 class="text-lg font-semibold mb-4 text-gray-700 flex items-center shrink-0">
                        <svg class="w-5 h-5 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        Top 5 Sekolah (Kendala Terbanyak)
                    </h3>
                    <div class="relative w-full flex-1 min-h-[300px]">
                        <canvas id="topIssuesChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Live Tracking Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex flex-row items-center justify-between mb-4 gap-4 w-full">
                    <h3 class="text-lg font-semibold text-gray-700 shrink-0">Live Tracking Pengiriman</h3>
                    <a href="{{ route('admin.reports.export') }}" style="background-color: #0f172a !important;" class="hover:bg-slate-800 text-white font-bold py-2 px-4 rounded-lg text-sm inline-flex items-center justify-center shadow-lg transition-all transform hover:scale-105 whitespace-nowrap shrink-0 border border-slate-700 h-[42px] box-border ml-auto">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        Unduh Semua Data (.PDF)
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table id="tracking-table" class="min-w-full bg-white">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sekolah Tujuan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Porsi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Pengiriman</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lat</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lng</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tracking-body" class="bg-white divide-y divide-gray-200">
                            <!-- Data will be loaded here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        function loadTrackingData() {
            fetch('/admin/api/distribusi')
                .then(response => response.json())
                .then(data => {
                    const tbody = document.getElementById('tracking-body');
                    tbody.innerHTML = '';
                    data.forEach(distribusi => {
                        const statusColors = {
                            'Pending': 'bg-yellow-100 text-yellow-800',
                            'Di Perjalanan': 'bg-blue-100 text-blue-800',
                            'Terkirim': 'bg-green-100 text-green-800',
                            'Diterima': 'bg-emerald-100 text-emerald-800',
                            'Diterima Sebagian': 'bg-orange-100 text-orange-800',
                            'Kendala': 'bg-red-100 text-red-800'
                        };
                        const colorClass = statusColors[distribusi.status] || 'bg-gray-100 text-gray-800';
                        
                        const mapLink = (distribusi.latitude && distribusi.longitude) 
                            ? `<a href="https://www.google.com/maps?q=${distribusi.latitude},${distribusi.longitude}" target="_blank" class="text-blue-500 hover:underline flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                Map
                               </a>`
                            : '<span class="text-gray-400">-</span>';

                        const row = document.createElement('tr');
                        row.className = 'hover:bg-gray-50 transition-colors';
                        row.innerHTML = `
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${distribusi.id}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 font-semibold">${distribusi.sekolah_tujuan}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${distribusi.jumlah_porsi}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${distribusi.tanggal_pengiriman}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full ${colorClass}">
                                    ${distribusi.status}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-mono text-xs">${distribusi.latitude || '-'}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-mono text-xs">${distribusi.longitude || '-'}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${mapLink}</td>
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
                    document.getElementById('total-distribusi').textContent = data.total_distribusi || 0;
                    document.getElementById('distribusi-hari-ini').textContent = data.distribusi_hari_ini || 0;
                    document.getElementById('distribusi-pending').textContent = data.distribusi_pending || 0;
                    document.getElementById('total-porsi').textContent = data.total_porsi || 0;
                    document.getElementById('success-rate').textContent = (data.success_rate || 0) + '%';
                    document.getElementById('total-sekolah').textContent = data.total_sekolah || 0;
                    document.getElementById('avg-porsi').textContent = data.avg_porsi || 0;
                    document.getElementById('total-kendala').textContent = data.total_kendala || 0;
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
                                    backgroundColor: ['#EAB308', '#3B82F6', '#22C55E', '#10B981', '#F97316', '#EF4444']
                                }]
                            },
                            options: { responsive: true, maintainAspectRatio: false }
                        });
                    }

                    const dailyCtx = document.getElementById('dailyChart');
                    if (dailyCtx && data.daily_chart) {
                        if (dailyChart) dailyChart.destroy();
                        dailyChart = new Chart(dailyCtx, {
                            type: 'line',
                            data: {
                                labels: data.daily_chart.map(item => item.date),
                                datasets: [{
                                    label: 'Pengiriman',
                                    data: data.daily_chart.map(item => item.count),
                                    borderColor: '#6366F1',
                                    backgroundColor: 'rgba(99, 102, 241, 0.1)',
                                    fill: true,
                                    tension: 0.4
                                }]
                            },
                            options: { responsive: true, maintainAspectRatio: false, scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } } }
                        });
                    }

                    const topCtx = document.getElementById('topSchoolsChart');
                    if (topCtx && data.top_schools_chart) {
                        if (topSchoolsChart) topSchoolsChart.destroy();
                        topSchoolsChart = new Chart(topCtx, {
                            type: 'bar',
                            data: {
                                labels: data.top_schools_chart.map(item => item.sekolah_tujuan),
                                datasets: [{
                                    label: 'Total Porsi',
                                    data: data.top_schools_chart.map(item => item.total_porsi),
                                    backgroundColor: '#F59E0B',
                                    borderRadius: 8
                                }]
                            },
                            options: { responsive: true, maintainAspectRatio: false, indexAxis: 'y', scales: { x: { beginAtZero: true } } }
                        });
                    }

                    const issuesCtx = document.getElementById('topIssuesChart');
                    if (issuesCtx && data.top_issues_chart) {
                        if (topIssuesChart) topIssuesChart.destroy();
                        topIssuesChart = new Chart(issuesCtx, {
                            type: 'bar',
                            data: {
                                labels: data.top_issues_chart.map(item => item.sekolah_tujuan),
                                datasets: [{
                                    label: 'Total Kendala',
                                    data: data.top_issues_chart.map(item => item.total_kendala),
                                    backgroundColor: '#EF4444',
                                    borderRadius: 8
                                }]
                            },
                            options: { responsive: true, maintainAspectRatio: false, indexAxis: 'y', scales: { x: { beginAtZero: true, ticks: { stepSize: 1 } } } }
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
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</x-app-layout>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Admin — GiziTrack
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <p class="text-gray-600">Selamat datang, Admin! 👋</p>
                <p class="text-sm text-gray-400 mt-2">
                    Modul: Kelola Akun Vendor & Sekolah akan dikerjakan di sini.
                </p>
            </div>

            <!-- Summary Dashboard (PBI-23) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="p-2 bg-blue-500 rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Distribusi</p>
                            <p class="text-2xl font-semibold text-gray-900" id="total-distribusi">-</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="p-2 bg-green-500 rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 4v10m0 0l-2-2m2 2l2-2"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Distribusi Hari Ini</p>
                            <p class="text-2xl font-semibold text-gray-900" id="distribusi-hari-ini">-</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="p-2 bg-yellow-500 rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Pending</p>
                            <p class="text-2xl font-semibold text-gray-900" id="distribusi-pending">-</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="p-2 bg-purple-500 rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Porsi</p>
                            <p class="text-2xl font-semibold text-gray-900" id="total-porsi">-</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chart Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">Status Distribusi</h3>
                    <canvas id="statusChart" width="400" height="200"></canvas>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">Distribusi 7 Hari Terakhir</h3>
                    <canvas id="dailyChart" width="400" height="200"></canvas>
                </div>
            </div>

            <!-- Export Report Button (PBI-26) -->
            <div class="mb-6">
                <a href="{{ route('admin.reports.export') }}" class="bg-green-500 text-white px-6 py-3 rounded-lg hover:bg-green-600 inline-flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Export Laporan Distribusi
                </a>
            </div>

            <!-- Live Tracking Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Live Tracking Pengiriman</h3>
                <div class="overflow-x-auto">
                    <table id="tracking-table" class="min-w-full bg-white">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sekolah Tujuan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Porsi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Pengiriman</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Latitude</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Longitude</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Updated</th>
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
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${distribusi.id}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${distribusi.sekolah_tujuan}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${distribusi.jumlah_porsi}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${distribusi.tanggal_pengiriman}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${distribusi.status}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${distribusi.latitude || 'N/A'}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${distribusi.longitude || 'N/A'}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${distribusi.last_updated || 'N/A'}</td>
                        `;
                        tbody.appendChild(row);
                    });
                })
                .catch(error => console.error('Error loading tracking data:', error));
        }

        // Load data on page load
        loadTrackingData();
        loadSummaryData();
        loadChartData();

        // Refresh data every 10 seconds
        setInterval(loadTrackingData, 10000);
        setInterval(loadSummaryData, 30000); // Refresh summary every 30 seconds
        setInterval(loadChartData, 60000); // Refresh charts every 60 seconds

        function loadSummaryData() {
            fetch('/admin/api/analytics/summary')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    document.getElementById('total-distribusi').textContent = data.total_distribusi || 0;
                    document.getElementById('distribusi-hari-ini').textContent = data.distribusi_hari_ini || 0;
                    document.getElementById('distribusi-pending').textContent = data.distribusi_pending || 0;
                    document.getElementById('total-porsi').textContent = data.total_porsi || 0;
                })
                .catch(error => {
                    console.error('Error loading summary data:', error);
                    // Set default values
                    document.getElementById('total-distribusi').textContent = '0';
                    document.getElementById('distribusi-hari-ini').textContent = '0';
                    document.getElementById('distribusi-pending').textContent = '0';
                    document.getElementById('total-porsi').textContent = '0';
                });
        }

        function loadChartData() {
            fetch('/admin/api/analytics/chart')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    // Status Chart
                    const statusCtx = document.getElementById('statusChart');
                    if (statusCtx) {
                        new Chart(statusCtx, {
                            type: 'pie',
                            data: {
                                labels: Object.keys(data.status_chart || {}),
                                datasets: [{
                                    data: Object.values(data.status_chart || {}),
                                    backgroundColor: [
                                        '#FF6384',
                                        '#36A2EB',
                                        '#FFCE56',
                                        '#4BC0C0',
                                        '#9966FF',
                                        '#FF9F40'
                                    ]
                                }]
                            },
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: {
                                        position: 'bottom',
                                    }
                                }
                            }
                        });
                    }

                    // Daily Chart
                    const dailyCtx = document.getElementById('dailyChart');
                    if (dailyCtx && data.daily_chart) {
                        new Chart(dailyCtx, {
                            type: 'line',
                            data: {
                                labels: data.daily_chart.map(item => item.date),
                                datasets: [{
                                    label: 'Distribusi',
                                    data: data.daily_chart.map(item => item.count),
                                    borderColor: '#36A2EB',
                                    backgroundColor: 'rgba(54, 162, 235, 0.1)',
                                    tension: 0.1
                                }]
                            },
                            options: {
                                responsive: true,
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    }
                })
                .catch(error => {
                    console.error('Error loading chart data:', error);
                    // Hide charts or show error message
                    const statusChart = document.getElementById('statusChart');
                    const dailyChart = document.getElementById('dailyChart');
                    if (statusChart) statusChart.style.display = 'none';
                    if (dailyChart) dailyChart.style.display = 'none';
                });
        }
    </script>

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</x-app-layout>
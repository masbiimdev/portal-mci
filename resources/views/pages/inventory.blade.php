@extends('layouts.home')

@section('title', 'MCI | Portal Inventory')

@section('content')

    <div class="max-w-6xl mx-auto py-10 px-4">
        <!-- Header -->
        <div class="text-center mb-10">
            <h1 class="text-3xl font-bold text-blue-700 tracking-tight mb-2">📦 Portal Inventory</h1>
            {{-- <p class="text-gray-500 text-sm">Lihat data stok barang gudang secara real-time tanpa login</p> --}}
        </div>
        <!-- Summary Cards -->
        <div id="summarySection" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <div class="summary-card bg-white border border-blue-100 rounded-xl shadow-sm p-5 text-center animate-pulse">
                <p class="text-sm text-gray-500 mb-1">Total Barang</p>
                <h3 id="totalBarang" class="text-2xl font-bold text-blue-700">...</h3>
            </div>
            <div class="summary-card bg-white border border-blue-100 rounded-xl shadow-sm p-5 text-center animate-pulse">
                <p class="text-sm text-gray-500 mb-1">Total Masuk Bulan Ini</p>
                <h3 id="totalMasuk" class="text-2xl font-bold text-green-600">...</h3>
            </div>
            <div class="summary-card bg-white border border-blue-100 rounded-xl shadow-sm p-5 text-center animate-pulse">
                <p class="text-sm text-gray-500 mb-1">Total Keluar Bulan Ini</p>
                <h3 id="totalKeluar" class="text-2xl font-bold text-red-500">...</h3>
            </div>
            {{-- <div class="summary-card bg-white border border-blue-100 rounded-xl shadow-sm p-5 text-center animate-pulse">
                <p class="text-sm text-gray-500 mb-1">Stok Di Bawah Minimum</p>
                <h3 id="belowMinimum" class="text-2xl font-bold text-yellow-500">...</h3>
            </div> --}}
        </div>
        <!-- Chart Section -->
        <div class="bg-white border border-blue-100 shadow-sm rounded-xl p-6 mb-8" style="height:500px;">
            <h2 class="text-lg font-semibold text-blue-700 mb-4">📈 Grafik Barang Masuk & Keluar</h2>
            <canvas id="inventoryChart"></canvas>
        </div>
        <!-- Filter -->
        <div class="bg-white border border-blue-100 shadow-sm rounded-xl p-6 mb-8">
            <h2 class="text-lg font-semibold text-blue-700 mb-4">Filter Data</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="bulan" class="block text-sm font-semibold text-gray-600 mb-1">Bulan</label>
                    <select id="bulan"
                        class="w-full border rounded-lg px-3 py-2 text-gray-700 focus:ring-2 focus:ring-blue-400">
                        <option value="">Semua</option>
                        @foreach ([1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'] as $key => $nama)
                            <option value="{{ $key }}">{{ $nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="tahun" class="block text-sm font-semibold text-gray-600 mb-1">Tahun</label>
                    <select id="tahun"
                        class="w-full border rounded-lg px-3 py-2 text-gray-700 focus:ring-2 focus:ring-blue-400">
                        <option value="">Semua</option>
                        @for ($t = date('Y'); $t >= date('Y') - 5; $t--)
                            <option value="{{ $t }}">{{ $t }}</option>
                        @endfor
                    </select>
                </div>
                <div class="flex items-end">
                    <button id="btnFilter"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-lg transition transform hover:scale-105">
                        🔎 Tampilkan
                    </button>
                </div>
            </div>
        </div>
        <!-- Table -->
        <div class="bg-white border border-blue-100 shadow-sm rounded-xl p-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4 gap-3">
                <h2 class="text-lg font-semibold text-blue-700">📋 Data Inventory</h2>
                <div class="flex items-center gap-2 w-full md:w-1/3">
                    <input id="searchInput" type="text" placeholder="🔍 Cari data..."
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-400 focus:outline-none" />
                    <button id="btnSearch"
                        class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition">
                        Cari
                    </button>
                </div>
            </div>

            <!-- Loading Spinner -->
            <div id="loadingTable" class="hidden text-center py-10 text-gray-400 animate-pulse">
                <div class="flex justify-center mb-3">
                    <div class="w-6 h-6 border-4 border-blue-400 border-t-transparent rounded-full animate-spin"></div>
                </div>
                Memuat data...
            </div>

            <div class="overflow-x-auto rounded-lg border border-gray-200">
                <table id="inventoryTable" class="min-w-full text-sm text-gray-700 border-collapse">
                    <thead class="bg-blue-600 text-white text-xs uppercase tracking-wide sticky top-0 z-10">
                        <tr>
                            <th class="px-4 py-3 text-left">No</th>
                            <th class="px-4 py-3 text-left">Heat/Lot No</th>
                            <th class="px-4 py-3 text-left">No Drawing</th>
                            <th class="px-4 py-3 text-left">Tipe Valve</th>
                            <th class="px-4 py-3 text-left">Spare Part</th>
                            <th class="px-4 py-3 text-left">Dimensi</th>
                            <th class="px-4 py-3 text-left">Posisi Barang</th>
                            <th class="px-4 py-3 text-center">Qty Masuk</th>
                            <th class="px-4 py-3 text-center">Qty Keluar</th>
                            <th class="px-4 py-3 text-center">Posisi Stok</th>
                            {{-- <th class="px-4 py-3 text-center">Stok Minimum</th> --}}
                            {{-- <th class="px-4 py-3 text-center">Status</th> --}}
                        </tr>
                    </thead>
                    <tbody id="inventoryBody" class="divide-y divide-gray-100 bg-white"></tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- jQuery & Chart.js -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        let chartInstance;

        $(function() {
            // Set default bulan & tahun
            const now = new Date();
            $('#bulan').val(now.getMonth() + 1);
            $('#tahun').val(now.getFullYear());

            loadSummary();
            loadTable();
            loadChart();

            $('#btnFilter').on('click', function() {
                loadTable();
                loadChart();
            });

            $('#btnSearch').on('click', loadTable);
            $('#searchInput').on('keypress', e => {
                if (e.which === 13) loadTable();
            });
        });

        // Summary
        function loadSummary() {
            $.get("{{ route('inventory.summary') }}", function(data) {
                $('#summarySection .summary-card').removeClass('animate-pulse');
                $('#totalBarang').text(data.total_barang ?? '-');
                $('#totalMasuk').text(data.total_masuk ?? '-');
                $('#totalKeluar').text(data.total_keluar ?? '-');
                $('#belowMinimum').text(data.below_minimum ?? '-');
            });
        }

        // Table
        function loadTable() {
            const bulan = $('#bulan').val();
            const tahun = $('#tahun').val();
            const search = $('#searchInput').val();

            $('#loadingTable').removeClass('hidden');
            $('#inventoryBody').html('');

            $.get("{{ route('inventory.data') }}", {
                bulan,
                tahun,
                search
            }, function(data) {
                $('#loadingTable').addClass('hidden');
                let html = '';

                if (data.length > 0) {
                    data.forEach((item, index) => {
                        let badge = '';
                        if (item.status === 'OK') badge =
                            `<span class='px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold'>OK</span>`;
                        else if (item.status === 'Warning') badge =
                            `<span class='px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-semibold'>Warning</span>`;
                        else badge =
                            `<span class='px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-semibold'>Below</span>`;

                        let valveNames = '-';
                        if (Array.isArray(item.material.valve_name)) valveNames = item.material.valve_name
                            .join(', ');
                        else if (item.material.valve_name) valveNames = item.material.valve_name;

                        html += `
                <tr class="hover:bg-blue-50 transition">
                    <td class="px-4 py-2 border">${index + 1}</td>
                    <td class="px-4 py-2 border">${item.material.heat_lot_no}</td>
                    <td class="px-4 py-2 border">${item.material.no_drawing}</td>
                    <td class="px-4 py-2 border">${valveNames}</td>
                    <td class="px-4 py-2 border">${item.material.spare_part_name}</td>
                    <td class="px-4 py-2 border">${item.material.dimensi}</td>
                    <td class="px-4 py-2 border">${item.material.rack_name ?? '-'}</td>
                    <td class="px-4 py-2 border text-green-600 font-semibold text-center">${item.qty_in}</td>
                    <td class="px-4 py-2 border text-red-500 font-semibold text-center">${item.qty_out}</td>
                    <td class="px-4 py-2 border font-bold text-center">${item.stock_akhir}</td>
                </tr>`;
                    });
                } else {
                    html =
                        `<tr><td colspan="12" class="py-6 text-gray-400 text-center">Tidak ada data untuk periode ini.</td></tr>`;
                }

                $('#inventoryBody').html(html).hide().fadeIn(300);
            });
        }

        // Chart
        function loadChart() {
            const bulan = $('#bulan').val();
            const tahun = $('#tahun').val();

            $.get("{{ route('inventory.chart') }}", {
                bulan,
                tahun
            }, function(data) {
                const labels = data.labels;
                const masuk = data.masuk;
                const keluar = data.keluar;

                const ctx = document.getElementById('inventoryChart').getContext('2d');
                if (chartInstance) chartInstance.destroy();

                chartInstance = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                                label: 'Barang Masuk',
                                data: masuk,
                                backgroundColor: 'rgba(34,197,94,0.6)',
                                borderColor: 'rgba(22,163,74,1)',
                                borderWidth: 1,
                                borderRadius: 6,
                                order: 2 // biar bar di bawah garis
                            },
                            {
                                label: 'Barang Keluar',
                                data: keluar,
                                backgroundColor: 'rgba(239,68,68,0.6)',
                                borderColor: 'rgba(220,38,38,1)',
                                borderWidth: 1,
                                borderRadius: 6,
                                order: 2
                            },
                            // Garis Tren Barang Masuk
                            {
                                type: 'line',
                                label: 'Tren Masuk',
                                data: masuk,
                                borderColor: '#16a34a',
                                backgroundColor: 'transparent',
                                borderWidth: 2,
                                tension: 0.3,
                                pointBackgroundColor: '#16a34a',
                                pointRadius: 3,
                                fill: false,
                                order: 1
                            },
                            // Garis Tren Barang Keluar
                            {
                                type: 'line',
                                label: 'Tren Keluar',
                                data: keluar,
                                borderColor: '#dc2626',
                                backgroundColor: 'transparent',
                                borderWidth: 2,
                                tension: 0.3,
                                pointBackgroundColor: '#dc2626',
                                pointRadius: 3,
                                fill: false,
                                order: 1
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: {
                            mode: 'index',
                            intersect: false
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Jumlah Barang'
                                },
                                ticks: {
                                    stepSize: 5
                                },
                                grid: {
                                    color: 'rgba(0,0,0,0.05)'
                                }
                            },
                            x: {
                                grid: {
                                    color: 'rgba(0,0,0,0.05)'
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            title: {
                                display: true,
                                text: '📊 Tren Barang Masuk & Keluar per Hari',
                                font: {
                                    size: 16
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const label = context.dataset.label || '';
                                        return `${label}: ${context.parsed.y} unit`;
                                    }
                                }
                            }
                        },
                        animation: {
                            duration: 900,
                            easing: 'easeOutQuart'
                        }
                    }
                });
            });
        }
    </script>

@endsection

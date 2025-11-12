@extends('layouts.home')

@section('title', 'MCI | Portal Inventory')

@section('content')

    <div class="max-w-7xl mx-auto py-10 px-4">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl sm:text-4xl font-extrabold text-blue-700 tracking-tight mb-2">📦 Portal Inventory</h1>
            <p class="text-gray-500 text-sm sm:text-base">Lihat data stok barang gudang secara real-time tanpa perlu login —
                filter, cari, dan ekspor data dengan mudah.</p>
        </div>

        <!-- Controls: Summary + Actions -->
        <div class="flex flex-col lg:flex-row lg:items-start gap-6 mb-6">
            <!-- Summary Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 flex-1">
                <div id="cardTotalBarang"
                    class="summary-card bg-white border border-blue-100 rounded-xl shadow p-5 text-center">
                    <div class="flex items-center justify-center mb-2">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 7h18M7 7v10a1 1 0 001 1h8a1 1 0 001-1V7M7 7V5a2 2 0 012-2h6a2 2 0 012 2v2"></path>
                        </svg>
                    </div>
                    <p class="text-sm text-gray-500 mb-1">Total Barang</p>
                    <h3 id="totalBarang" class="text-2xl font-bold text-blue-700">—</h3>
                </div>

                <div id="cardMasuk" class="summary-card bg-white border border-blue-100 rounded-xl shadow p-5 text-center">
                    <div class="flex items-center justify-center mb-2">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12h3l3 9 4-18 3 9h4"></path>
                        </svg>
                    </div>
                    <p class="text-sm text-gray-500 mb-1">Masuk Bulan Ini</p>
                    <h3 id="totalMasuk" class="text-2xl font-bold text-green-600">—</h3>
                </div>

                <div id="cardKeluar" class="summary-card bg-white border border-blue-100 rounded-xl shadow p-5 text-center">
                    <div class="flex items-center justify-center mb-2">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 12H3m12 8l-4-8 4-8"></path>
                        </svg>
                    </div>
                    <p class="text-sm text-gray-500 mb-1">Keluar Bulan Ini</p>
                    <h3 id="totalKeluar" class="text-2xl font-bold text-red-500">—</h3>
                </div>

                <div id="cardLow" class="summary-card bg-white border border-blue-100 rounded-xl shadow p-5 text-center">
                    <div class="flex items-center justify-center mb-2">
                        <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01M21 12A9 9 0 1112 3a9 9 0 019 9z"></path>
                        </svg>
                    </div>
                    <p class="text-sm text-gray-500 mb-1">Stok Di Bawah Minimum</p>
                    <h3 id="belowMinimum" class="text-2xl font-bold text-yellow-500">—</h3>
                </div>
            </div>

            <!-- Actions -->
            <div class="w-full lg:w-72 flex items-center gap-3">
                <button id="btnRefresh" title="Muat ulang data"
                    class="w-1/2 bg-white border border-gray-200 hover:shadow px-4 py-2 rounded-lg text-sm text-gray-700 flex items-center justify-center gap-2">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v6h6M20 20v-6h-6">
                        </path>
                    </svg>
                    Refresh
                </button>

                <button id="btnExport" title="Ekspor CSV"
                    class="w-1/2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-semibold flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14m7-7H5"></path>
                    </svg>
                    Ekspor CSV
                </button>
            </div>
        </div>

        <!-- Chart -->
        <div class="bg-white border border-blue-100 shadow rounded-xl p-6 mb-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-blue-700">📈 Grafik Barang Masuk & Keluar</h2>
                <div class="text-sm text-gray-500">Periode: <span id="chartPeriod" class="font-medium">—</span></div>
            </div>
            <div class="h-72 sm:h-96">
                <canvas id="inventoryChart" role="img" aria-label="Grafik barang masuk dan keluar"></canvas>
            </div>
        </div>

        <!-- Filter -->
        <div class="bg-white border border-blue-100 shadow rounded-xl p-6 mb-6">
            <h2 class="text-lg font-semibold text-blue-700 mb-4">Filter Data</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                <div>
                    <label for="bulan" class="block text-sm font-semibold text-gray-600 mb-1">Bulan</label>
                    <select id="bulan" aria-label="Pilih bulan"
                        class="w-full border rounded-lg px-3 py-2 text-gray-700 focus:ring-2 focus:ring-blue-400">
                        <option value="">Semua</option>
                        @foreach ([1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'] as $key => $nama)
                            <option value="{{ $key }}">{{ $nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="tahun" class="block text-sm font-semibold text-gray-600 mb-1">Tahun</label>
                    <select id="tahun" aria-label="Pilih tahun"
                        class="w-full border rounded-lg px-3 py-2 text-gray-700 focus:ring-2 focus:ring-blue-400">
                        <option value="">Semua</option>
                        @for ($t = date('Y'); $t >= date('Y') - 5; $t--)
                            <option value="{{ $t }}">{{ $t }}</option>
                        @endfor
                    </select>
                </div>

                <div>
                    <label for="rak" class="block text-sm font-semibold text-gray-600 mb-1">Rak / Posisi</label>
                    <input id="rak" type="text" placeholder="Semua / Nama rak..."
                        class="w-full border rounded-lg px-3 py-2 text-gray-700 focus:ring-2 focus:ring-blue-400" />
                </div>

                <div class="flex gap-2">
                    <button id="btnFilter"
                        class="w-1/2 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-lg">
                        🔎 Tampilkan
                    </button>
                    <button id="btnClear"
                        class="w-1/2 bg-white border border-gray-200 hover:shadow text-gray-700 py-2.5 rounded-lg">
                        Reset
                    </button>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="bg-white border border-blue-100 shadow rounded-xl p-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4 gap-3">
                <h2 class="text-lg font-semibold text-blue-700">📋 Data Inventory</h2>
                <div class="flex items-center gap-2 w-full md:w-1/2">
                    <input id="searchInput" type="text" placeholder="🔍 Cari Heat/Lot, No Drawing, Spare Part..."
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-400 focus:outline-none"
                        aria-label="Cari data inventaris" />
                    <button id="btnSearch"
                        class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded-lg">
                        Cari
                    </button>
                </div>
            </div>

            <!-- Loading Spinner -->
            <div id="loadingTable" class="hidden text-center py-8 text-gray-400">
                <div class="flex justify-center mb-3">
                    <div class="w-8 h-8 border-4 border-blue-400 border-t-transparent rounded-full animate-spin"></div>
                </div>
                Memuat data...
            </div>

            <div class="overflow-x-auto rounded-lg border border-gray-200">
                <table id="inventoryTable" class="min-w-full text-sm text-gray-700 border-collapse">
                    <thead
                        class="bg-gradient-to-r from-blue-600 to-blue-500 text-white text-xs uppercase tracking-wide sticky top-0 z-10">
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
                        </tr>
                    </thead>
                    <tbody id="inventoryBody" class="divide-y divide-gray-100 bg-white min-h-[120px]">
                        {{-- Rows injected by JS --}}
                    </tbody>
                </table>
            </div>

            <div id="tableFooter" class="mt-4 flex items-center justify-between text-sm text-gray-600 hidden">
                <div id="tableCount">Menampilkan <span id="visibleCount">0</span> baris</div>
                <div>
                    <button id="btnPrev"
                        class="px-3 py-1 rounded border border-gray-200 mr-2 bg-white text-gray-700 hidden">Sebelumnya</button>
                    <button id="btnNext"
                        class="px-3 py-1 rounded border border-gray-200 bg-white text-gray-700 hidden">Berikutnya</button>
                </div>
            </div>
        </div>

    </div>

    <!-- jQuery & Chart.js (kept intentionally to be consistent with existing code) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        let chartInstance;
        let lastFetchedTableData = []; // for export
        let debounceTimer;

        $(function() {
            // Default bulan & tahun to current
            const now = new Date();
            $('#bulan').val(now.getMonth() + 1);
            $('#tahun').val(now.getFullYear());

            // Initial load
            loadSummary();
            loadTable();
            loadChart();

            // Event bindings
            $('#btnFilter').on('click', function() {
                loadTable();
                loadChart();
            });

            $('#btnClear').on('click', function() {
                $('#bulan').val('');
                $('#tahun').val('');
                $('#rak').val('');
                $('#searchInput').val('');
                loadTable();
                loadChart();
            });

            $('#btnRefresh').on('click', function() {
                loadSummary();
                loadTable();
                loadChart();
            });

            $('#btnExport').on('click', exportCsv);

            $('#btnSearch').on('click', function() {
                loadTable();
            });

            $('#searchInput').on('input', function() {
                // debounce: wait 500ms after user stops typing
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => loadTable(), 500);
            });

            $('#searchInput').on('keypress', function(e) {
                if (e.which === 13) {
                    clearTimeout(debounceTimer);
                    loadTable();
                }
            });
        });

        // Format numbers with thousands separator
        function formatNumber(n) {
            if (n === null || n === undefined || isNaN(Number(n))) return '-';
            return Number(n).toLocaleString();
        }

        // Simple toast for errors / info
        function toast(message, type = 'info') {
            const colors = {
                info: 'bg-blue-600',
                error: 'bg-red-600',
                success: 'bg-green-600'
            };
            const bg = colors[type] || colors.info;
            const $t = $('<div>')
                .attr('role', 'status')
                .addClass(`${bg} text-white px-4 py-2 rounded shadow fixed right-6 bottom-6 z-50`)
                .text(message)
                .hide();
            $('body').append($t);
            $t.fadeIn(200).delay(2200).fadeOut(400, function() {
                $(this).remove();
            });
        }

        // Summary
        function loadSummary() {
            // show skeleton states
            $('#cardTotalBarang, #cardMasuk, #cardKeluar, #cardLow').addClass('opacity-60');
            $.get("{{ route('inventory.summary') }}")
                .done(function(data) {
                    $('#cardTotalBarang, #cardMasuk, #cardKeluar, #cardLow').removeClass('opacity-60');
                    $('#totalBarang').text(formatNumber(data.total_barang ?? '-'));
                    $('#totalMasuk').text(formatNumber(data.total_masuk ?? '-'));
                    $('#totalKeluar').text(formatNumber(data.total_keluar ?? '-'));
                    $('#belowMinimum').text(formatNumber(data.below_minimum ?? '-'));
                })
                .fail(function() {
                    $('#cardTotalBarang, #cardMasuk, #cardKeluar, #cardLow').removeClass('opacity-60');
                    toast('Gagal memuat ringkasan inventory.', 'error');
                });
        }

        // Table
        function loadTable() {
            const bulan = $('#bulan').val();
            const tahun = $('#tahun').val();
            const search = $('#searchInput').val();
            const rak = $('#rak').val();

            $('#loadingTable').removeClass('hidden');
            $('#inventoryBody').empty();
            $('#tableFooter').addClass('hidden');

            $.get("{{ route('inventory.data') }}", {
                    bulan,
                    tahun,
                    search,
                    rak
                })
                .done(function(data) {
                    $('#loadingTable').addClass('hidden');
                    lastFetchedTableData = data || [];
                    renderTableRows(lastFetchedTableData);
                })
                .fail(function() {
                    $('#loadingTable').addClass('hidden');
                    toast('Gagal memuat data tabel. Coba lagi.', 'error');
                    $('#inventoryBody').html(
                        `<tr><td colspan="10" class="py-6 text-red-500 text-center">Terjadi kesalahan saat mengambil data.</td></tr>`
                        );
                });
        }

        function renderTableRows(data) {
            let html = '';
            if (Array.isArray(data) && data.length > 0) {
                data.forEach((item, index) => {
                    const idx = index + 1;
                    const valveNames = Array.isArray(item.material?.valve_name) ?
                        item.material.valve_name.join(', ') :
                        (item.material?.valve_name ?? '-');

                    // status color (if present in item)
                    let statusClass = 'bg-gray-100 text-gray-700';
                    if (item.status === 'OK') statusClass = 'bg-green-100 text-green-700';
                    else if (item.status === 'Warning') statusClass = 'bg-yellow-100 text-yellow-700';
                    else if (item.status === 'Below') statusClass = 'bg-red-100 text-red-700';

                    html += `
                        <tr class="hover:bg-blue-50 transition">
                            <td class="px-4 py-3 border align-top">${idx}</td>
                            <td class="px-4 py-3 border align-top">${escapeHtml(item.material?.heat_lot_no ?? '-')}</td>
                            <td class="px-4 py-3 border align-top">${escapeHtml(item.material?.no_drawing ?? '-')}</td>
                            <td class="px-4 py-3 border align-top">${escapeHtml(valveNames)}</td>
                            <td class="px-4 py-3 border align-top">${escapeHtml(item.material?.spare_part_name ?? '-')}</td>
                            <td class="px-4 py-3 border align-top">${escapeHtml(item.material?.dimensi ?? '-')}</td>
                            <td class="px-4 py-3 border align-top">${escapeHtml(item.material?.rack_name ?? '-')}</td>
                            <td class="px-4 py-3 border text-green-600 font-semibold text-center align-top">${formatNumber(item.qty_in)}</td>
                            <td class="px-4 py-3 border text-red-500 font-semibold text-center align-top">${formatNumber(item.qty_out)}</td>
                            <td class="px-4 py-3 border font-bold text-center align-top">${formatNumber(item.stock_akhir)}</td>
                        </tr>`;
                });
                $('#inventoryBody').html(html);
                $('#visibleCount').text(data.length);
                $('#tableFooter').removeClass('hidden');
            } else {
                $('#inventoryBody').html(
                    `<tr><td colspan="10" class="py-8 text-gray-400 text-center">Tidak ada data untuk periode ini.</td></tr>`
                    );
                $('#visibleCount').text(0);
                $('#tableFooter').removeClass('hidden');
            }
        }

        // Chart
        function loadChart() {
            const bulan = $('#bulan').val();
            const tahun = $('#tahun').val();

            $.get("{{ route('inventory.chart') }}", {
                    bulan,
                    tahun
                })
                .done(function(data) {
                    const labels = data.labels || [];
                    const masuk = data.masuk || [];
                    const keluar = data.keluar || [];

                    // Update chart period label
                    const b = bulan ? bulan : 'Semua Bulan';
                    const t = tahun ? tahun : 'Semua Tahun';
                    $('#chartPeriod').text(`${b} / ${t}`);

                    const ctx = document.getElementById('inventoryChart').getContext('2d');
                    if (chartInstance) chartInstance.destroy();

                    chartInstance = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [{
                                    label: 'Barang Masuk',
                                    data: masuk,
                                    backgroundColor: 'rgba(34,197,94,0.85)',
                                    borderColor: 'rgba(16,185,129,1)',
                                    borderWidth: 1,
                                    borderRadius: 6,
                                    order: 2
                                },
                                {
                                    label: 'Barang Keluar',
                                    data: keluar,
                                    backgroundColor: 'rgba(239,68,68,0.85)',
                                    borderColor: 'rgba(220,38,38,1)',
                                    borderWidth: 1,
                                    borderRadius: 6,
                                    order: 2
                                },
                                {
                                    type: 'line',
                                    label: 'Tren Masuk',
                                    data: masuk,
                                    borderColor: '#16a34a',
                                    backgroundColor: 'transparent',
                                    borderWidth: 2,
                                    tension: 0.25,
                                    pointBackgroundColor: '#16a34a',
                                    pointRadius: 3,
                                    fill: false,
                                    order: 1
                                },
                                {
                                    type: 'line',
                                    label: 'Tren Keluar',
                                    data: keluar,
                                    borderColor: '#dc2626',
                                    backgroundColor: 'transparent',
                                    borderWidth: 2,
                                    tension: 0.25,
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
                                        callback: function(value) {
                                            return Number(value).toLocaleString();
                                        }
                                    },
                                    grid: {
                                        color: 'rgba(0,0,0,0.05)'
                                    }
                                },
                                x: {
                                    grid: {
                                        color: 'rgba(0,0,0,0.03)'
                                    }
                                }
                            },
                            plugins: {
                                legend: {
                                    position: 'top'
                                },
                                title: {
                                    display: true,
                                    text: '📊 Tren Barang Masuk & Keluar per Hari',
                                    font: {
                                        size: 15
                                    }
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            const label = context.dataset.label || '';
                                            const val = context.parsed.y ?? context.parsed;
                                            return `${label}: ${Number(val).toLocaleString()} unit`;
                                        }
                                    }
                                }
                            },
                            animation: {
                                duration: 700,
                                easing: 'easeOutQuart'
                            }
                        }
                    });
                })
                .fail(function() {
                    toast('Gagal memuat data chart.', 'error');
                });
        }

        // Export current table to CSV
        function exportCsv() {
            if (!Array.isArray(lastFetchedTableData) || lastFetchedTableData.length === 0) {
                toast('Tidak ada data untuk diekspor.', 'info');
                return;
            }

            const rows = [];
            const header = ['No', 'Heat/Lot No', 'No Drawing', 'Tipe Valve', 'Spare Part', 'Dimensi', 'Posisi Barang',
                'Qty Masuk', 'Qty Keluar', 'Stock Akhir'
            ];
            rows.push(header.join(','));

            lastFetchedTableData.forEach((item, idx) => {
                const valveNames = Array.isArray(item.material?.valve_name) ? item.material.valve_name.join('; ') :
                    (item.material?.valve_name ?? '-');
                const row = [
                    idx + 1,
                    sanitizeCsv(item.material?.heat_lot_no),
                    sanitizeCsv(item.material?.no_drawing),
                    sanitizeCsv(valveNames),
                    sanitizeCsv(item.material?.spare_part_name),
                    sanitizeCsv(item.material?.dimensi),
                    sanitizeCsv(item.material?.rack_name),
                    item.qty_in ?? 0,
                    item.qty_out ?? 0,
                    item.stock_akhir ?? 0
                ];
                rows.push(row.join(','));
            });

            const csvContent = rows.join('\n');
            const blob = new Blob([csvContent], {
                type: 'text/csv;charset=utf-8;'
            });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `inventory_export_${new Date().toISOString().slice(0,10)}.csv`;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);

            toast('Ekspor CSV berhasil. Periksa unduhan Anda.', 'success');
        }

        // Utilities
        function sanitizeCsv(value) {
            if (value === null || value === undefined) return '';
            const v = String(value).replace(/"/g, '""');
            // wrap if contains comma/semicolon/newline/quote
            if (/[\n,",;]/.test(v)) return `"${v}"`;
            return v;
        }

        function escapeHtml(text) {
            if (text === null || text === undefined) return '';
            return String(text)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }
    </script>

@endsection

@extends('layouts.home')

@section('title', 'MCI | Portal Inventory')

@push('css')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }

        /* Modern Card Style */
        .card-soft {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card-soft:hover {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
        }

        /* Gradient Stats */
        .stat-card-sky {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            border: 1px solid #bae6fd;
        }

        .stat-card-emerald {
            background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
            border: 1px solid #a7f3d0;
        }

        .stat-card-rose {
            background: linear-gradient(135deg, #fff1f2 0%, #ffe4e6 100%);
            border: 1px solid #fecdd3;
        }

        .stat-card-amber {
            background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
            border: 1px solid #fde68a;
        }

        /* Custom Scrollbar */
        .overflow-x-auto::-webkit-scrollbar {
            height: 8px;
        }

        .overflow-x-auto::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        .overflow-x-auto::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        /* Badge Styles */
        .badge-low {
            background-color: #fff7ed;
            color: #c2410c;
            border: 1px solid #fdba74;
            padding: 2px 8px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .chip {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            font-size: 0.875rem;
            color: #475569;
        }

        .low-stock-row {
            background-color: #fffaf0 !important;
        }

        /* Animation for loading */
        .skeleton {
            background: linear-gradient(90deg, #f1f5f9 25%, #e2e8f0 50%, #f1f5f9 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
        }

        @keyframes loading {
            to {
                background-position: -200% 0;
            }
        }

        /* Search Bar Focus */
        .search-focus:focus-within {
            ring: 2px;
            ring-color: #0ea5e9;
            border-color: #0ea5e9;
        }
    </style>
@endpush

@section('content')
    <div class="max-w-7xl mx-auto py-10 px-4">

        <header class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <nav class="flex mb-2 text-xs font-semibold text-gray-400 uppercase tracking-widest">
                    <span>Inventory</span>
                    <span class="mx-2">/</span>
                    <span class="text-sky-600">Dashboard</span>
                </nav>
                <h1 class="text-3xl font-black text-slate-800 tracking-tight">Portal Inventory <span
                        class="text-sky-500">MCI</span></h1>
                <p class="text-slate-500 mt-1">Sistem monitoring aset dan stok pergudangan real-time.</p>
            </div>

            <div class="flex items-center gap-3">
                <button id="btnExport"
                    class="inline-flex items-center bg-white border border-slate-200 px-5 py-2.5 rounded-xl shadow-sm text-sm font-bold text-slate-700 hover:bg-slate-50 transition-all">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Ekspor CSV
                </button>
                <button id="btnHelp"
                    class="bg-slate-900 text-white px-5 py-2.5 rounded-xl shadow-lg shadow-slate-200 text-sm font-bold hover:bg-slate-800 transition-all">
                    Bantuan
                </button>
            </div>
        </header>

        <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
            <div class="p-6 card-soft stat-card-sky">
                <div class="text-sky-600 mb-2">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <div class="text-sm font-medium text-sky-800/70">Total Barang</div>
                <div class="text-3xl font-extrabold text-sky-900" id="totalBarang">—</div>
            </div>

            <div class="p-6 card-soft stat-card-emerald">
                <div class="text-emerald-600 mb-2">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M9 11l3 3L22 4m-2 6v10a2 2 0 01-2 2H4a2 2 0 01-2-2V6a2 2 0 012-2h11" />
                    </svg>
                </div>
                <div class="text-sm font-medium text-emerald-800/70">Masuk (Bulan Ini)</div>
                <div class="text-3xl font-extrabold text-emerald-900" id="totalMasuk">—</div>
            </div>

            <div class="p-6 card-soft stat-card-rose">
                <div class="text-rose-600 mb-2">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="text-sm font-medium text-rose-800/70">Keluar (Bulan Ini)</div>
                <div class="text-3xl font-extrabold text-rose-900" id="totalKeluar">—</div>
            </div>

            <div class="p-6 card-soft stat-card-amber">
                <div class="text-amber-600 mb-2">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div class="text-sm font-medium text-amber-800/70">Stok Kritis</div>
                <div class="text-3xl font-extrabold text-amber-900" id="belowMinimum">—</div>
            </div>
        </section>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8 mb-8">
            <div class="lg:col-span-3 card-soft p-6">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                    <div>
                        <h2 class="text-lg font-bold text-slate-800">Visualisasi Pergerakan Stok</h2>
                        <p class="text-sm text-slate-500">Perbandingan harian barang masuk vs keluar</p>
                    </div>
                    <select id="presetRange"
                        class="bg-slate-50 border-slate-200 text-slate-600 rounded-xl text-sm font-semibold focus:ring-sky-500 focus:border-sky-500 p-2.5">
                        <option value="30">30 Hari Terakhir</option>
                        <option value="14">2 Minggu Terakhir</option>
                        <option value="7">7 Hari Terakhir</option>
                    </select>
                </div>
                <div class="h-72">
                    <canvas id="inventoryChart"></canvas>
                </div>
            </div>

            <aside class="flex flex-col gap-6">
                <div class="card-soft p-6 bg-slate-50/50">
                    <h3 class="text-sm font-bold text-slate-800 mb-4 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        Filter Data
                    </h3>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1.5 uppercase">Bulan</label>
                            <select id="bulan"
                                class="w-full bg-white border-slate-200 rounded-xl text-sm p-2.5 focus:ring-sky-500">
                                <option value="">Semua Bulan</option>
                                @foreach ([1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'] as $key => $nama)
                                    <option value="{{ $key }}">{{ $nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1.5 uppercase">Tahun</label>
                            <select id="tahun"
                                class="w-full bg-white border-slate-200 rounded-xl text-sm p-2.5 focus:ring-sky-500">
                                <option value="">Semua Tahun</option>
                                @for ($t = date('Y'); $t >= date('Y') - 5; $t--)
                                    <option value="{{ $t }}">{{ $t }}</option>
                                @endfor
                            </select>
                        </div>

                        <div class="pt-2 flex flex-col gap-2">
                            <button id="btnFilter"
                                class="w-full bg-sky-600 text-white py-2.5 rounded-xl font-bold text-sm shadow-md shadow-sky-100 hover:bg-sky-700 transition-all">Terapkan</button>
                            <button id="btnClear"
                                class="w-full bg-white border border-slate-200 text-slate-600 py-2.5 rounded-xl font-bold text-sm hover:bg-slate-50 transition-all">Reset</button>
                        </div>
                    </div>
                </div>

                <div class="p-4 bg-sky-50 rounded-2xl border border-sky-100">
                    <p class="text-xs text-sky-700 leading-relaxed">
                        <strong>Tips:</strong> Pencarian mendukung pencarian Heat No, No Drawing, dan Nama Spare Part secara
                        bersamaan.
                    </p>
                </div>
            </aside>
        </div>

        <section class="card-soft overflow-hidden shadow-xl shadow-slate-200/50">
            <div class="p-6 border-b border-slate-100 bg-white">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <h2 class="text-xl font-bold text-slate-800">Detail Inventaris</h2>

                    <div class="relative w-full md:w-96 group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 h-4 text-slate-400 group-focus-within:text-sky-500 transition-colors"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input id="searchInput" type="text" placeholder="Cari Heat, Drawing, atau Valve..."
                            class="block w-full pl-10 pr-10 py-2.5 border border-slate-200 rounded-xl text-sm bg-slate-50 focus:bg-white focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition-all">
                        <button id="btnClearSearch"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 hidden">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div id="inventoryCards" class="grid grid-cols-1 gap-4 p-4 sm:hidden bg-slate-50"></div>

            <div class="overflow-x-auto hidden sm:block">
                <table id="inventoryTable" class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/80 text-slate-500 text-xs font-bold uppercase tracking-wider">
                            <th class="px-6 py-4 border-b border-slate-100">No</th>
                            <th class="px-6 py-4 border-b border-slate-100">Material Info</th>
                            <th class="px-6 py-4 border-b border-slate-100">Tipe Valve / Part</th>
                            <th class="px-6 py-4 border-b border-slate-100">Posisi</th>
                            <th class="px-6 py-4 border-b border-slate-100 text-center">Mutasi</th>
                            <th class="px-6 py-4 border-b border-slate-100 text-right">Stok Akhir</th>
                        </tr>
                    </thead>
                    <tbody id="inventoryBody" class="divide-y divide-slate-100 bg-white">
                    </tbody>
                </table>
            </div>

            <div id="tableFooter"
                class="p-6 bg-slate-50 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4 hidden">
                <div class="text-sm text-slate-500 font-medium">
                    Menampilkan <span id="showingRange" class="text-slate-800 font-bold">—</span> dari <span
                        id="totalCount" class="text-slate-800 font-bold">—</span> data
                </div>

                <div class="flex items-center gap-4">
                    <div class="flex items-center bg-white border border-slate-200 rounded-lg p-1 shadow-sm">
                        <button id="btnPrev"
                            class="p-2 hover:bg-slate-50 rounded-md disabled:opacity-30 disabled:cursor-not-allowed transition-colors text-sky-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>
                        <span class="px-4 text-xs font-bold text-slate-600 uppercase tracking-widest">Hal <span
                                id="currentPage">1</span> / <span id="totalPages">1</span></span>
                        <button id="btnNext"
                            class="p-2 hover:bg-slate-50 rounded-md disabled:opacity-30 disabled:cursor-not-allowed transition-colors text-sky-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>

                    <select id="pageSize"
                        class="bg-white border-slate-200 text-slate-600 rounded-lg text-xs font-bold p-2 focus:ring-sky-500">
                        <option value="10">10 / Hal</option>
                        <option value="25" selected>25 / Hal</option>
                        <option value="50">50 / Hal</option>
                    </select>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        let chartInstance;
        let lastFetchedTableData = [];
        let currentPage = 1;
        let pageSize = 25;
        let debounceTimer;

        // helper to safely get valve names
        function getValveNames(item) {
            // try multiple shapes: item.material.valve_name (array or string) or item.material.valves (array of objects)
            const m = item && item.material ? item.material : null;
            if (!m) return '-';
            if (Array.isArray(m.valve_name)) return m.valve_name.join(', ');
            if (typeof m.valve_name === 'string' && m.valve_name.trim() !== '') return m.valve_name;
            if (Array.isArray(m.valves)) {
                return m.valves.map(v => v.valve_name || v.name || '').filter(Boolean).join(', ') || '-';
            }
            return '-';
        }

        $(function() {
            // sensible defaults
            const now = new Date();
            $('#bulan').val(now.getMonth() + 1);
            $('#tahun').val(now.getFullYear());

            // initial fetch
            loadSummary();
            loadTable();
            loadChart();

            // events
            $('#btnFilter').on('click', () => {
                currentPage = 1;
                loadTable();
                loadChart();
            });
            $('#btnClear').on('click', () => {
                $('#bulan').val('');
                $('#tahun').val('');
                $('#searchInput').val('');
                $('#btnClearSearch').addClass('hidden');
                currentPage = 1;
                loadTable();
                loadChart();
            });

            $('#presetRange').on('change', function() {
                loadChart();
            });

            $('#btnExport').on('click', exportCsv);
            $('#btnSearch').on('click', () => {
                currentPage = 1;
                loadTable();
            });

            $('#searchInput').on('input', function() {
                clearTimeout(debounceTimer);
                if ($(this).val()) $('#btnClearSearch').removeClass('hidden');
                else $('#btnClearSearch').addClass('hidden');
                debounceTimer = setTimeout(() => {
                    currentPage = 1;
                    loadTable();
                }, 400);
            });
            $('#searchInput').on('keypress', function(e) {
                if (e.which === 13) {
                    clearTimeout(debounceTimer);
                    currentPage = 1;
                    loadTable();
                }
            });
            $('#btnClearSearch').on('click', function() {
                $('#searchInput').val('');
                $(this).addClass('hidden');
                currentPage = 1;
                loadTable();
            });

            $('#btnPrev').on('click', () => {
                if (currentPage > 1) {
                    currentPage--;
                    renderTableRows(lastFetchedTableData);
                }
            });
            $('#btnNext').on('click', () => {
                const totalPages = Math.max(1, Math.ceil((lastFetchedTableData?.length || 0) / pageSize));
                if (currentPage < totalPages) {
                    currentPage++;
                    renderTableRows(lastFetchedTableData);
                }
            });
            $('#pageSize').on('change', function() {
                pageSize = Number($(this).val()) || 25;
                currentPage = 1;
                renderTableRows(lastFetchedTableData);
            });

            // quick help
            $('#btnHelp').on('click', () => {
                alert(
                    "Cara cepat:\n• Gunakan kotak pencarian untuk menemukan Heat/Lot, No Drawing, nama spare part, atau tipe valve.\n• Pilih rentang atau bulan/tahun untuk mempersempit hasil.\n• Klik 'Ekspor CSV' untuk mengunduh hasil yang ditampilkan."
                    );
            });
        });

        function loadSummary() {
            $('#totalBarang, #totalMasuk, #totalKeluar, #belowMinimum, #totalBarangSmall, #belowMinimumSmall').text('—')
                .addClass('opacity-60');
            $.get("{{ route('inventory.summary') }}")
                .done(function(data) {
                    $('#totalBarang').removeClass('opacity-60');
                    $('#totalBarangSmall').removeClass('opacity-60');
                    animateCount('#totalBarang', data.total_barang ?? 0);
                    animateCount('#totalMasuk', data.total_masuk ?? 0);
                    animateCount('#totalKeluar', data.total_keluar ?? 0);
                    animateCount('#belowMinimum', data.below_minimum ?? 0);
                    $('#totalBarangSmall').text((data.total_barang || 0).toLocaleString());
                    $('#belowMinimumSmall').text((data.below_minimum || 0).toLocaleString());
                })
                .fail(function() {
                    toast('Gagal memuat ringkasan inventory.', 'error');
                });
        }

        function loadTable() {
            const bulan = $('#bulan').val();
            const tahun = $('#tahun').val();
            const search = $('#searchInput').val();

            // adjust colspan to 9 (No + Heat + Drawing + Valve + Spare + Posisi + Masuk + Keluar + Stok)
            $('#inventoryBody').html(
                `<tr><td colspan="10" class="py-8 text-center"><div class="skeleton h-6 w-72 mx-auto mb-3"></div><div class="skeleton h-6 w-40 mx-auto"></div></td></tr>`
            );
            $('#inventoryCards').html(
                `<div class="py-8 text-center"><div class="skeleton h-24 w-11/12 mx-auto mb-3"></div><div class="skeleton h-24 w-11/12 mx-auto"></div></div>`
            );
            $('#tableFooter').addClass('hidden');

            $.get("{{ route('inventory.data') }}", {
                    bulan,
                    tahun,
                    search
                })
                .done(function(data) {
                    lastFetchedTableData = Array.isArray(data) ? data : [];
                    currentPage = 1;
                    renderTableRows(lastFetchedTableData);
                })
                .fail(function() {
                    $('#inventoryBody').html(
                        `<tr><td colspan="10" class="py-8 text-center text-rose-500">Gagal memuat data.</td></tr>`);
                    $('#inventoryCards').html(`<div class="py-8 text-center text-rose-500">Gagal memuat data.</div>`);
                    toast('Gagal memuat data tabel. Coba lagi.', 'error');
                });
        }

        function renderTableRows(data) {
            const total = Array.isArray(data) ? data.length : 0;
            $('#totalCount').text(total);

            if (total === 0) {
                $('#inventoryBody').html(
                    `<tr><td colspan="10" class="py-8 text-gray-400 text-center">Tidak ada data untuk periode ini.</td></tr>`
                );
                $('#inventoryCards').html(
                    `<div class="py-8 text-center text-gray-400">Tidak ada data untuk periode ini.</div>`);
                $('#showingRange').text(0);
                $('#currentPage').text(1);
                $('#totalPages').text(1);
                $('#tableFooter').removeClass('hidden');
                $('#btnPrev, #btnNext').prop('disabled', true);
                return;
            }

            const totalPages = Math.max(1, Math.ceil(total / pageSize));
            if (currentPage > totalPages) currentPage = totalPages;
            const startIdx = (currentPage - 1) * pageSize;
            const pageItems = data.slice(startIdx, startIdx + pageSize);

            const isMobile = window.innerWidth < 640;
            if (isMobile) {
                let cardsHtml = '';
                pageItems.forEach((item, idx) => {
                    const i = startIdx + idx + 1;
                    const heatLot = escapeHtml(item.material?.heat_lot_no ?? '-');
                    const noDrawing = escapeHtml(item.material?.no_drawing ?? '-');
                    const sparePart = escapeHtml(item.material?.spare_part_name ?? '-');
                    const valveNames = escapeHtml(getValveNames(item));
                    const rack = escapeHtml(item.material?.rack_name ?? '-');
                    const stockAwal = formatNumber(item.material?.stock_awal ?? 0);
                    const qtyIn = formatNumber(item.qty_in ?? 0);
                    const qtyOut = formatNumber(item.qty_out ?? 0);
                    const stock = Number(item.stock_akhir ?? 0);
                    const lowClass = (item.material?.min_stock && stock <= item.material.min_stock) ? 'low-stock' :
                        '';

                    cardsHtml += `
                    <article class="p-4 border border-gray-100 rounded-xl shadow-sm bg-white ${lowClass}" tabindex="0">
                        <div class="flex justify-between items-start gap-3">
                            <div class="flex-1 min-w-0">
                                <div class="text-xs text-gray-400 mb-1">#${i} — <span class="font-medium">${heatLot}</span></div>
                                <div class="text-sm text-gray-600 mb-1 truncate">${noDrawing}</div>
                                <div class="text-xs text-gray-500">Valve: <span class="text-gray-700">${valveNames}</span></div>
                                <div class="text-xs text-gray-500">Spare: <span class="text-gray-700">${sparePart}</span></div>
                                <div class="text-xs card-meta mt-2">Posisi: <span class="count-pill">${rack}</span></div>
                            </div>
                            <div class="text-right">
                                <div class="text-xs text-gray-400">Stok Akhir</div>
                                <div class="text-lg font-semibold text-gray-800">${formatNumber(stock)}</div>
                                <div class="mt-2 text-xs text-emerald-700">+${qtyIn} in</div>
                                <div class="text-xs text-rose-700">-${qtyOut} out</div>
                                <div class="text-xs text-gray-400 mt-1">Awal: ${stockAwal}</div>
                            </div>
                        </div>
                    </article>
                `;
                });
                $('#inventoryCards').html(cardsHtml);
                $('#inventoryTable').closest('.overflow-x-auto').addClass('hidden');
            } else {
                let rowsHtml = '';
                pageItems.forEach((item, idx) => {
                    const i = startIdx + idx + 1;
                    const heatLot = escapeHtml(item.material?.heat_lot_no ?? '-');
                    const noDrawing = escapeHtml(item.material?.no_drawing ?? '-');
                    const valveNames = escapeHtml(getValveNames(item));
                    const sparePart = escapeHtml(item.material?.spare_part_name ?? '-');
                    const dimensiPart = escapeHtml(item.material?.dimensi ?? '-');
                    const rack = escapeHtml(item.material?.rack_name ?? '-');
                    const stockAwal = formatNumber(item.material?.stock_awal ?? 0);
                    const qtyIn = formatNumber(item.qty_in ?? 0);
                    const qtyOut = formatNumber(item.qty_out ?? 0);
                    const stock = Number(item.stock_akhir ?? 0);
                    const lowClass = (item.material?.min_stock && stock <= item.material.min_stock) ? 'low-stock' :
                        '';

                    rowsHtml += `
                   <tr class="hover:bg-sky-50/30 transition-colors group ${lowClass ? 'low-stock-row' : ''}">
                <td class="px-6 py-4 text-sm text-slate-400 font-medium">${i}</td>
                <td class="px-6 py-4">
                    <div class="text-sm font-bold text-slate-800">${heatLot}</div>
                    <div class="text-xs text-slate-500 font-medium uppercase tracking-tight">${noDrawing}</div>
                </td>
                <td class="px-6 py-4">
                    <div class="text-sm text-slate-700 font-semibold truncate max-w-[200px]" title="${valveNames}">${valveNames}</div>
                    <div class="text-xs text-slate-500">${sparePart}</div>
                </td>
                <td class="px-6 py-4">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-bold bg-slate-100 text-slate-600 group-hover:bg-sky-100 group-hover:text-sky-700 transition-colors">
                        ${rack}
                    </span>
                </td>
                <td class="px-6 py-4 text-center">
                    <div class="flex items-center justify-center gap-3">
                        <span class="text-xs font-bold text-emerald-600" title="Masuk">+${qtyIn}</span>
                        <span class="text-xs font-bold text-rose-500" title="Keluar">-${qtyOut}</span>
                    </div>
                </td>
                <td class="px-6 py-4 text-right">
                    <div class="text-base font-black ${lowClass ? 'text-amber-600' : 'text-slate-800'}">${formatNumber(stock)}</div>
                    ${lowClass ? '<span class="badge-low">Stok Rendah</span>' : ''}
                </td>
            </tr>
                `;
                });
                $('#inventoryBody').html(rowsHtml);
                $('#inventoryTable').closest('.overflow-x-auto').removeClass('hidden');
                $('#inventoryCards').html('');
            }

            const showingFrom = startIdx + 1;
            const showingTo = Math.min(startIdx + pageItems.length, total);
            $('#showingRange').text(`${showingFrom}–${showingTo}`);
            $('#currentPage').text(currentPage);
            $('#totalPages').text(totalPages);
            $('#totalCount').text(total);

            $('#tableFooter').removeClass('hidden');
            $('#btnPrev').prop('disabled', currentPage <= 1);
            $('#btnNext').prop('disabled', currentPage >= totalPages);

            // re-run accessibility: allow keyboard "Enter" on rows to open detail link if present
            $('#inventoryBody tr').attr('tabindex', 0).off('keypress').on('keypress', function(e) {
                if (e.which === 13) {
                    const link = $(this).find('a').first();
                    if (link && link.attr('href') && link.attr('href') !== '#') window.location = link.attr('href');
                }
            });
        }

        function loadChart() {
            const preset = $('#presetRange').val();
            const bulan = $('#bulan').val();
            const tahun = $('#tahun').val();

            $.get("{{ route('inventory.chart') }}", {
                    days: preset,
                    bulan,
                    tahun
                })
                .done(function(data) {
                    const labels = data.labels || [];
                    const masuk = data.masuk || [];
                    const keluar = data.keluar || [];

                    const ctx = document.getElementById('inventoryChart').getContext('2d');
                    if (chartInstance) chartInstance.destroy();

                    chartInstance = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels,
                            datasets: [{
                                    label: 'Masuk',
                                    data: masuk,
                                    backgroundColor: 'rgba(34,197,94,0.9)',
                                    borderRadius: 6
                                },
                                {
                                    label: 'Keluar',
                                    data: keluar,
                                    backgroundColor: 'rgba(239,68,68,0.9)',
                                    borderRadius: 6
                                },
                                {
                                    type: 'line',
                                    label: 'Tren Masuk',
                                    data: masuk,
                                    borderColor: '#16a34a',
                                    backgroundColor: 'transparent',
                                    tension: 0.25,
                                    pointRadius: 2
                                },
                                {
                                    type: 'line',
                                    label: 'Tren Keluar',
                                    data: keluar,
                                    borderColor: '#dc2626',
                                    backgroundColor: 'transparent',
                                    tension: 0.25,
                                    pointRadius: 2
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
                                    ticks: {
                                        callback: v => Number(v).toLocaleString()
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
                                tooltip: {
                                    callbacks: {
                                        label: ctx =>
                                            `${ctx.dataset.label}: ${Number(ctx.parsed.y ?? ctx.parsed).toLocaleString()} unit`
                                    }
                                }
                            },
                            animation: {
                                duration: 600,
                                easing: 'easeOutQuart'
                            }
                        }
                    });
                })
                .fail(function() {
                    toast('Gagal memuat data chart.', 'error');
                });
        }

        function exportCsv() {
            if (!Array.isArray(lastFetchedTableData) || lastFetchedTableData.length === 0) {
                toast('Tidak ada data untuk diekspor.');
                return;
            }
            const rows = [];
            const header = ['No', 'Heat/Lot No', 'No Drawing', 'Tipe Valve', 'Spare Part', 'Posisi', 'Qty Masuk',
                'Qty Keluar', 'Stok Akhir'
            ];
            rows.push(header.join(','));
            lastFetchedTableData.forEach((item, idx) => {
                const valve = sanitizeCsv(getValveNames(item));
                const row = [
                    idx + 1,
                    sanitizeCsv(item.material?.heat_lot_no),
                    sanitizeCsv(item.material?.no_drawing),
                    valve,
                    sanitizeCsv(item.material?.spare_part_name),
                    sanitizeCsv(item.material?.rack_name),
                    item.stock_awal ?? 0,
                    item.qty_in ?? 0,
                    item.qty_out ?? 0,
                    item.stock_akhir ?? 0
                ];
                rows.push(row.join(','));
            });
            const csvContent = '\uFEFF' + rows.join('\n');
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
            toast('Ekspor CSV berhasil.', 'success');
        }

        // UTILITIES
        function animateCount(elSelector, toValue) {
            const el = document.querySelector(elSelector);
            if (!el) return;
            const start = Number(el.textContent.replace(/[^0-9]/g, '')) || 0;
            const end = Number(toValue) || 0;
            const duration = 500;
            const stepTime = 20;
            const steps = Math.ceil(duration / stepTime);
            let currentStep = 0;
            const increment = (end - start) / steps;
            const timer = setInterval(() => {
                currentStep++;
                const val = Math.round(start + increment * currentStep);
                el.textContent = (end >= 1000) ? val.toLocaleString() : val;
                if (currentStep >= steps) {
                    clearInterval(timer);
                    el.textContent = end.toLocaleString();
                }
            }, stepTime);
        }

        function formatNumber(n) {
            if (n === null || n === undefined || isNaN(Number(n))) return '-';
            return Number(n).toLocaleString();
        }

        function toast(message, type = 'info') {
            const colors = {
                info: 'bg-sky-600',
                error: 'bg-rose-600',
                success: 'bg-emerald-600'
            };
            const bg = colors[type] || colors.info;
            const $t = $('<div>').addClass(`${bg} text-white px-4 py-2 rounded shadow fixed right-6 bottom-6 z-50`).text(
                message).hide();
            $('body').append($t);
            $t.fadeIn(200).delay(2200).fadeOut(400, function() {
                $(this).remove();
            });
        }

        function sanitizeCsv(v) {
            if (v === null || v === undefined) return '';
            const s = String(v).replace(/"/g, '""');
            return /[\n,",;]/.test(s) ? `"${s}"` : s;
        }

        function escapeHtml(text) {
            if (text === null || text === undefined) return '';
            return String(text).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }
    </script>
@endpush

@extends('layouts.home')

@section('title', 'MCI | Portal Inventory')

@push('css')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f7fe;
            /* Warna latar sedikit lebih terang/cool */
            color: #334155;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Modern Card Style - Refined */
        .card-soft {
            background: #ffffff;
            border: 1px solid rgba(226, 232, 240, 0.6);
            border-radius: 20px;
            /* Sudut lebih membulat */
            box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.03);
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        .card-soft:hover {
            box-shadow: 0 15px 30px -5px rgba(0, 0, 0, 0.06), 0 10px 15px -6px rgba(0, 0, 0, 0.03);
            transform: translateY(-3px);
            border-color: rgba(226, 232, 240, 0.9);
        }

        /* Enhanced Gradient Stats with Glow */
        .stat-card {
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            opacity: 0.1;
            z-index: -1;
            border-radius: 19px;
            transition: opacity 0.3s ease;
        }

        .stat-card:hover::before {
            opacity: 0.2;
        }

        .stat-card-sky {
            border-bottom: 3px solid #38bdf8;
        }

        .stat-card-sky::before {
            background: linear-gradient(135deg, #38bdf8 0%, #0ea5e9 100%);
        }

        .stat-icon-sky {
            background-color: #e0f2fe;
            color: #0284c7;
        }

        .stat-card-emerald {
            border-bottom: 3px solid #34d399;
        }

        .stat-card-emerald::before {
            background: linear-gradient(135deg, #34d399 0%, #10b981 100%);
        }

        .stat-icon-emerald {
            background-color: #d1fae5;
            color: #059669;
        }

        .stat-card-rose {
            border-bottom: 3px solid #fb7185;
        }

        .stat-card-rose::before {
            background: linear-gradient(135deg, #fb7185 0%, #f43f5e 100%);
        }

        .stat-icon-rose {
            background-color: #ffe4e6;
            color: #e11d48;
        }

        .stat-card-amber {
            border-bottom: 3px solid #fbbf24;
        }

        .stat-card-amber::before {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
        }

        .stat-icon-amber {
            background-color: #fef3c7;
            color: #d97706;
        }


        /* Table Enhancements */
        .table-responsive-wrapper {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            border-radius: 0 0 20px 20px;
        }

        .table-responsive-wrapper::-webkit-scrollbar {
            height: 6px;
            width: 6px;
        }

        .table-responsive-wrapper::-webkit-scrollbar-track {
            background: transparent;
        }

        .table-responsive-wrapper::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .table-responsive-wrapper::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        #inventoryTable th {
            letter-spacing: 0.05em;
            color: #64748b;
            font-weight: 700;
            background-color: #f8fafc;
            border-bottom: 2px solid #e2e8f0;
        }

        #inventoryTable td {
            border-bottom: 1px dashed #f1f5f9;
            vertical-align: middle;
        }

        #inventoryBody tr:last-child td {
            border-bottom: none;
        }

        /* Badge & Chip Styles */
        .badge-low {
            display: inline-flex;
            align-items: center;
            background-color: #fef2f2;
            color: #e11d48;
            border: 1px solid #fecdd3;
            padding: 3px 8px;
            border-radius: 999px;
            /* Pill shape */
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.02em;
        }

        .badge-low::before {
            content: '';
            display: inline-block;
            width: 4px;
            height: 4px;
            background-color: #e11d48;
            border-radius: 50%;
            margin-right: 4px;
            animation: pulse-dot 2s infinite;
        }

        @keyframes pulse-dot {
            0% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.5);
                opacity: 0.5;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .low-stock-row td {
            background-color: #fffaf0 !important;
        }

        /* Custom Inputs */
        .input-glow:focus {
            box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.15);
            border-color: #38bdf8;
            outline: none;
        }

        /* Skeleton Loading */
        .skeleton {
            background: linear-gradient(90deg, #f1f5f9 25%, #e2e8f0 50%, #f1f5f9 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
            border-radius: 6px;
        }

        @keyframes loading {
            to {
                background-position: -200% 0;
            }
        }
    </style>
@endpush

@section('content')
    <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">

        <header class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-5">
            <div>
                <nav class="flex items-center mb-3 text-xs font-bold text-slate-400 uppercase tracking-widest">
                    <span class="hover:text-slate-600 cursor-pointer transition-colors">Inventory</span>
                    <span class="mx-2 text-slate-300">/</span>
                    <span class="text-sky-500">Dashboard</span>
                </nav>
                <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-800 tracking-tight leading-tight">
                    Portal Inventory <span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-sky-400 to-blue-600">MCI</span>
                </h1>
                <p class="text-sm sm:text-base text-slate-500 mt-2 font-medium">Monitoring pergerakan aset dan ketersediaan
                    stok secara real-time.</p>
            </div>

            <div class="flex items-center gap-3 w-full md:w-auto">
                <button id="btnExport"
                    class="flex-1 md:flex-none inline-flex justify-center items-center bg-white border border-slate-200 px-6 py-2.5 rounded-xl shadow-sm text-sm font-bold text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-all focus:ring-2 focus:ring-sky-100 group">
                    <svg class="w-4 h-4 mr-2 text-sky-500 group-hover:-translate-y-0.5 transition-transform" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Ekspor Laporan
                </button>
                <button id="btnHelp"
                    class="bg-slate-800 text-white p-2.5 px-4 rounded-xl shadow-lg shadow-slate-200/50 text-sm font-bold hover:bg-slate-900 transition-all focus:ring-2 focus:ring-slate-300 flex items-center justify-center group"
                    title="Pusat Bantuan">
                    <svg class="w-5 h-5 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </button>
            </div>
        </header>

        <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 sm:gap-6 mb-10">
            <div class="p-6 card-soft stat-card stat-card-sky flex flex-col justify-between">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <div class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Total Material</div>
                        <div class="text-3xl font-black text-slate-800" id="totalBarang">—</div>
                    </div>
                    <div class="p-3 rounded-full stat-icon-sky">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                </div>
                <div class="text-xs font-medium text-slate-400">Total item terdaftar di sistem</div>
            </div>

            <div class="p-6 card-soft stat-card stat-card-emerald flex flex-col justify-between">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <div class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Total Masuk</div>
                        <div class="text-3xl font-black text-slate-800" id="totalMasuk">—</div>
                    </div>
                    <div class="p-3 rounded-full stat-icon-emerald">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12" />
                        </svg>
                    </div>
                </div>
                <div class="text-xs font-medium text-emerald-600 bg-emerald-50 inline-block px-2 py-0.5 rounded w-max">Bulan
                    Ini</div>
            </div>

            <div class="p-6 card-soft stat-card stat-card-rose flex flex-col justify-between">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <div class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Total Keluar</div>
                        <div class="text-3xl font-black text-slate-800" id="totalKeluar">—</div>
                    </div>
                    <div class="p-3 rounded-full stat-icon-rose">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4" />
                        </svg>
                    </div>
                </div>
                <div class="text-xs font-medium text-rose-600 bg-rose-50 inline-block px-2 py-0.5 rounded w-max">Bulan Ini
                </div>
            </div>

            <div class="p-6 card-soft stat-card stat-card-amber flex flex-col justify-between">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <div class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Stok Menipis</div>
                        <div class="text-3xl font-black text-slate-800" id="belowMinimum">—</div>
                    </div>
                    <div class="p-3 rounded-full stat-icon-amber">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                </div>
                <div class="text-xs font-medium text-amber-600 bg-amber-50 inline-block px-2 py-0.5 rounded w-max">Butuh
                    Perhatian</div>
            </div>
        </section>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 sm:gap-8 mb-10">
            <div class="lg:col-span-3 card-soft p-6 flex flex-col">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                    <div>
                        <h2 class="text-xl font-bold text-slate-800">Visualisasi Mutasi</h2>
                        <p class="text-sm text-slate-500 mt-1">Grafik perbandingan pergerakan barang masuk dan keluar.</p>
                    </div>
                    <select id="presetRange"
                        class="bg-slate-50 border border-slate-200 text-slate-700 rounded-xl text-sm font-semibold input-glow p-2.5 w-full sm:w-auto cursor-pointer">
                        <option value="7">7 Hari Terakhir</option>
                        <option value="14">14 Hari Terakhir</option>
                        <option value="30" selected>30 Hari Terakhir</option>
                    </select>
                </div>
                <div class="h-[280px] sm:h-80 w-full mt-auto">
                    <canvas id="inventoryChart"></canvas>
                </div>
            </div>

            <aside class="flex flex-col">
                <div class="card-soft p-6 bg-slate-50/30 h-full">
                    <h3 class="text-base font-bold text-slate-800 mb-5 flex items-center">
                        <span class="p-1.5 bg-sky-100 text-sky-600 rounded-lg mr-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                            </svg>
                        </span>
                        Filter Parameter
                    </h3>

                    <div class="space-y-5">
                        <div>
                            <label class="block text-xs font-bold text-slate-600 mb-2">Pilih Bulan</label>
                            <select id="bulan"
                                class="w-full bg-white border border-slate-200 rounded-xl text-sm font-medium p-3 input-glow cursor-pointer">
                                <option value="">Semua Bulan</option>
                                @foreach ([1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'] as $key => $nama)
                                    <option value="{{ $key }}">{{ $nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-600 mb-2">Pilih Tahun</label>
                            <select id="tahun"
                                class="w-full bg-white border border-slate-200 rounded-xl text-sm font-medium p-3 input-glow cursor-pointer">
                                <option value="">Semua Tahun</option>
                                @for ($t = date('Y'); $t >= date('Y') - 5; $t--)
                                    <option value="{{ $t }}">{{ $t }}</option>
                                @endfor
                            </select>
                        </div>

                        <div class="pt-4 flex flex-col gap-3">
                            <button id="btnFilter"
                                class="w-full bg-sky-600 text-white py-3 rounded-xl font-bold text-sm shadow-md shadow-sky-200 hover:bg-sky-700 transition-all focus:ring-2 focus:ring-sky-500 focus:ring-offset-2">
                                Terapkan Filter
                            </button>
                            <button id="btnClear"
                                class="w-full bg-white border border-slate-200 text-slate-600 py-2.5 rounded-xl font-bold text-sm hover:bg-slate-50 transition-all focus:ring-2 focus:ring-slate-200">
                                Reset Ulang
                            </button>
                        </div>
                    </div>
                </div>
            </aside>
        </div>

        <section class="card-soft overflow-hidden">
            <div class="p-5 sm:p-6 border-b border-slate-100 bg-white">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-5">
                    <div>
                        <h2 class="text-xl font-bold text-slate-800">Detail Data Stok</h2>
                        <p class="text-xs text-slate-500 mt-1 font-medium">Informasi rincian posisi dan kuantitas material.
                        </p>
                    </div>

                    <div class="relative w-full md:w-96 group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-slate-400 group-focus-within:text-sky-500 transition-colors"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input id="searchInput" type="text" placeholder="Cari Heat No, Drawing, Valve, Spare Part..."
                            class="block w-full pl-11 pr-10 py-3 border border-slate-200 rounded-xl text-sm font-medium bg-slate-50 focus:bg-white input-glow transition-all">
                        <button id="btnClearSearch"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-rose-500 hidden transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div id="inventoryCards" class="grid grid-cols-1 gap-4 p-4 lg:hidden bg-slate-50/50"></div>

            <div class="table-responsive-wrapper hidden lg:block bg-white">
                <table id="inventoryTable" class="w-full text-left border-collapse whitespace-nowrap">
                    <thead>
                        <tr>
                            <th class="px-6 py-4 w-16 text-center rounded-tl-xl">No</th>
                            <th class="px-6 py-4">Informasi Material</th>
                            <th class="px-6 py-4">Tipe Valve & Spare Part</th>
                            <th class="px-6 py-4">Lokasi (Rak)</th>
                            <th class="px-6 py-4 text-center">Stok Awal</th>
                            <th class="px-6 py-4 text-center">Mutasi (In/Out)</th>
                            <th class="px-6 py-4 text-right pr-8 rounded-tr-xl">Stok Akhir</th>
                        </tr>
                    </thead>
                    <tbody id="inventoryBody" class="divide-y divide-slate-100">
                    </tbody>
                </table>
            </div>

            <div id="tableFooter"
                class="p-5 border-t border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row items-center justify-between gap-4 rounded-b-20 hidden">
                <div class="text-sm text-slate-500 font-medium">
                    Menampilkan <span id="showingRange" class="text-slate-800 font-bold px-1">—</span> dari <span
                        id="totalCount" class="text-slate-800 font-bold px-1">—</span> entri
                </div>

                <div class="flex items-center gap-4 w-full sm:w-auto justify-between sm:justify-end">
                    <div class="flex items-center bg-white border border-slate-200 rounded-xl p-1 shadow-sm">
                        <button id="btnPrev"
                            class="p-2 hover:bg-slate-100 rounded-lg disabled:opacity-30 disabled:hover:bg-transparent transition-all text-slate-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>
                        <span class="px-4 text-xs font-bold text-slate-500">Hal <span id="currentPage"
                                class="text-sky-600 font-black text-sm mx-1">1</span> / <span
                                id="totalPages">1</span></span>
                        <button id="btnNext"
                            class="p-2 hover:bg-slate-100 rounded-lg disabled:opacity-30 disabled:hover:bg-transparent transition-all text-slate-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>

                    <select id="pageSize"
                        class="bg-white border border-slate-200 text-slate-700 rounded-xl text-sm font-bold p-2.5 input-glow cursor-pointer shadow-sm">
                        <option value="10">10 Baris</option>
                        <option value="25" selected>25 Baris</option>
                        <option value="50">50 Baris</option>
                        <option value="100">100 Baris</option>
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

        function getValveNames(item) {
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
            const now = new Date();
            $('#bulan').val(now.getMonth() + 1);
            $('#tahun').val(now.getFullYear());

            loadSummary();
            loadTable();
            loadChart();

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

            $('#searchInput').on('input', function() {
                clearTimeout(debounceTimer);
                if ($(this).val()) $('#btnClearSearch').removeClass('hidden');
                else $('#btnClearSearch').addClass('hidden');
                debounceTimer = setTimeout(() => {
                    currentPage = 1;
                    loadTable();
                }, 500);
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

            $('#btnHelp').on('click', () => {
                alert(
                    "Pusat Bantuan Cepat:\n\n🔍 Pencarian: Ketik Heat/Lot No, Drawing, Tipe Valve, atau Spare Part.\n📅 Filter: Pilih Bulan & Tahun untuk merekap data historis.\n📈 Chart: Ubah rentang hari untuk melihat tren stok.\n📥 Ekspor CSV: Unduh data tabel saat ini ke format Excel.");
            });
        });

        function loadSummary() {
            $('#totalBarang, #totalMasuk, #totalKeluar, #belowMinimum').text('—').addClass(
                'opacity-40 blur-[2px] transition-all');
            $.get("{{ route('inventory.summary') }}")
                .done(function(data) {
                    $('.opacity-40').removeClass('opacity-40 blur-[2px]');
                    animateCount('#totalBarang', data.total_barang ?? 0);
                    animateCount('#totalMasuk', data.total_masuk ?? 0);
                    animateCount('#totalKeluar', data.total_keluar ?? 0);
                    animateCount('#belowMinimum', data.below_minimum ?? 0);
                })
                .fail(function() {
                    $('.opacity-40').removeClass('opacity-40 blur-[2px]');
                    toast('Gagal memuat ringkasan dashboard.', 'error');
                });
        }

        function loadTable() {
            const bulan = $('#bulan').val();
            const tahun = $('#tahun').val();
            const search = $('#searchInput').val();

            $('#inventoryBody').html(
                `<tr><td colspan="7" class="py-16 text-center"><div class="skeleton h-5 w-64 mx-auto mb-4"></div><div class="skeleton h-4 w-40 mx-auto"></div></td></tr>`
            );
            $('#inventoryCards').html(
                `<div class="py-8"><div class="skeleton h-40 w-full rounded-2xl mb-5"></div><div class="skeleton h-40 w-full rounded-2xl"></div></div>`
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
                        `<tr><td colspan="7" class="py-12 text-center font-bold text-rose-500 bg-rose-50/30">Koneksi server terputus. Gagal memuat data.</td></tr>`
                        );
                    $('#inventoryCards').html(
                        `<div class="py-8 text-center font-bold text-rose-500 bg-rose-50 rounded-xl border border-rose-100">Gagal memuat data.</div>`
                        );
                    toast('Gagal memuat data tabel. Coba muat ulang halaman.', 'error');
                });
        }

        function renderTableRows(data) {
            const total = Array.isArray(data) ? data.length : 0;
            $('#totalCount').text(total);

            if (total === 0) {
                $('#inventoryBody').html(
                    `<tr><td colspan="7" class="py-16 text-slate-400 font-medium text-center bg-slate-50/50">Data tidak ditemukan untuk kriteria pencarian ini.</td></tr>`
                    );
                $('#inventoryCards').html(
                    `<div class="py-12 text-center text-slate-400 bg-slate-50 border border-slate-100 rounded-2xl">Data tidak ditemukan.</div>`
                    );
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

            const isMobile = window.innerWidth < 1024;

            if (isMobile) {
                let cardsHtml = '';
                pageItems.forEach((item, idx) => {
                    const i = startIdx + idx + 1;
                    const heatLot = escapeHtml(item.material?.heat_lot_no ?? '-');
                    const noDrawing = escapeHtml(item.material?.no_drawing ?? '-');
                    const sparePart = escapeHtml(item.material?.spare_part_name ?? '-');
                    const valveNames = escapeHtml(getValveNames(item));
                    const rack = escapeHtml(item.material?.rack_name ?? '-');

                    const stockAwal = Number(item.material?.stock_awal ?? 0);
                    const qtyIn = Number(item.qty_in ?? 0);
                    const qtyOut = Number(item.qty_out ?? 0);
                    const stock = Number(item.stock_akhir ?? 0);
                    const isLow = (item.material?.min_stock && stock <= item.material.min_stock);
                    const borderClass = isLow ? 'border-amber-300 bg-amber-50/40' : 'border-slate-200 bg-white';

                    cardsHtml += `
                    <article class="p-5 border ${borderClass} rounded-2xl shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <span class="text-xs font-bold text-slate-400 bg-slate-100 px-2 py-0.5 rounded-md mr-1.5">#${i}</span>
                                <span class="font-black text-slate-800 text-base tracking-tight">${heatLot}</span>
                            </div>
                            <span class="text-[10px] font-bold bg-slate-100 border border-slate-200 text-slate-600 px-2.5 py-1 rounded-lg flex items-center">
                                <svg class="w-3 h-3 mr-1 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" /></svg>
                                ${rack}
                            </span>
                        </div>
                        
                        <div class="mb-5 bg-slate-50/80 p-3 rounded-xl border border-slate-100">
                            <div class="text-xs text-slate-400 font-bold uppercase tracking-wider mb-1">${noDrawing}</div>
                            <div class="text-sm font-bold text-slate-700 truncate mb-1">${valveNames}</div>
                            <div class="text-xs text-slate-500 font-medium flex items-center">
                                <span class="w-1.5 h-1.5 rounded-full bg-slate-300 mr-1.5"></span> ${sparePart}
                            </div>
                        </div>

                        <div class="grid grid-cols-4 gap-2">
                            <div class="text-center bg-slate-50 rounded-lg p-2 border border-slate-100">
                                <div class="text-[9px] font-bold text-slate-400 uppercase mb-0.5">Awal</div>
                                <div class="text-sm font-bold text-slate-600">${formatNumber(stockAwal)}</div>
                            </div>
                            <div class="text-center bg-emerald-50/50 rounded-lg p-2 border border-emerald-100">
                                <div class="text-[9px] font-bold text-emerald-600/70 uppercase mb-0.5">In</div>
                                <div class="text-sm font-bold text-emerald-600">+${formatNumber(qtyIn)}</div>
                            </div>
                            <div class="text-center bg-rose-50/50 rounded-lg p-2 border border-rose-100">
                                <div class="text-[9px] font-bold text-rose-600/70 uppercase mb-0.5">Out</div>
                                <div class="text-sm font-bold text-rose-600">-${formatNumber(qtyOut)}</div>
                            </div>
                            <div class="text-center ${isLow ? 'bg-amber-100 border border-amber-200' : 'bg-sky-50 border border-sky-100'} rounded-lg p-2 shadow-sm">
                                <div class="text-[9px] font-bold ${isLow ? 'text-amber-700' : 'text-sky-700'} uppercase mb-0.5">Akhir</div>
                                <div class="text-base font-black ${isLow ? 'text-amber-700' : 'text-sky-700'}">${formatNumber(stock)}</div>
                            </div>
                        </div>
                    </article>
                    `;
                });
                $('#inventoryCards').html(cardsHtml);
                $('#inventoryTable').closest('.table-responsive-wrapper').addClass('hidden');
                $('#inventoryCards').removeClass('hidden');

            } else {
                let rowsHtml = '';
                pageItems.forEach((item, idx) => {
                    const i = startIdx + idx + 1;
                    const heatLot = escapeHtml(item.material?.heat_lot_no ?? '-');
                    const noDrawing = escapeHtml(item.material?.no_drawing ?? '-');
                    const valveNames = escapeHtml(getValveNames(item));
                    const sparePart = escapeHtml(item.material?.spare_part_name ?? '-');
                    const rack = escapeHtml(item.material?.rack_name ?? '-');

                    const stockAwal = Number(item.material?.stock_awal ?? 0);
                    const qtyIn = Number(item.qty_in ?? 0);
                    const qtyOut = Number(item.qty_out ?? 0);
                    const stock = Number(item.stock_akhir ?? 0);
                    const isLow = (item.material?.min_stock && stock <= item.material.min_stock);

                    rowsHtml += `
                    <tr class="hover:bg-slate-50/80 transition-colors group ${isLow ? 'low-stock-row' : ''}">
                        <td class="px-6 py-5 text-sm text-slate-400 font-bold text-center group-hover:text-slate-600 transition-colors">${i}</td>
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-400 group-hover:bg-sky-50 group-hover:text-sky-500 group-hover:border-sky-100 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                                </div>
                                <div>
                                    <div class="text-sm font-black text-slate-800 tracking-tight">${heatLot}</div>
                                    <div class="text-xs text-slate-500 font-bold uppercase tracking-wider mt-0.5">${noDrawing}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <div class="text-sm text-slate-800 font-bold truncate max-w-[250px]" title="${valveNames}">${valveNames}</div>
                            <div class="text-xs text-slate-500 font-medium mt-1 flex items-center">
                                <span class="w-1.5 h-1.5 rounded-full bg-slate-300 mr-1.5"></span> ${sparePart}
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-bold bg-slate-100 border border-slate-200 text-slate-600 shadow-sm">
                                <svg class="w-3.5 h-3.5 mr-1.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" /></svg>
                                ${rack}
                            </span>
                        </td>
                        <td class="px-6 py-5 text-center">
                            <span class="text-sm font-bold text-slate-600">${formatNumber(stockAwal)}</span>
                        </td>
                        <td class="px-6 py-5 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <span class="inline-flex items-center text-xs font-bold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-md border border-emerald-100 shadow-sm" title="Total Masuk">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" /></svg>
                                    ${formatNumber(qtyIn)}
                                </span>
                                <span class="inline-flex items-center text-xs font-bold text-rose-600 bg-rose-50 px-2.5 py-1 rounded-md border border-rose-100 shadow-sm" title="Total Keluar">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" /></svg>
                                    ${formatNumber(qtyOut)}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-5 text-right pr-8 relative">
                            <div class="text-lg font-black tracking-tight ${isLow ? 'text-amber-600' : 'text-slate-800'}">${formatNumber(stock)}</div>
                            ${isLow ? '<div class="badge-low absolute right-8 -bottom-1 shadow-sm">Kritis</div>' : ''}
                        </td>
                    </tr>
                    `;
                });
                $('#inventoryBody').html(rowsHtml);
                $('#inventoryTable').closest('.table-responsive-wrapper').removeClass('hidden');
                $('#inventoryCards').addClass('hidden');
            }

            const showingFrom = startIdx + 1;
            const showingTo = Math.min(startIdx + pageItems.length, total);
            $('#showingRange').text(`${showingFrom}–${showingTo}`);
            $('#currentPage').text(currentPage);
            $('#totalPages').text(totalPages);

            $('#tableFooter').removeClass('hidden');
            $('#btnPrev').prop('disabled', currentPage <= 1);
            $('#btnNext').prop('disabled', currentPage >= totalPages);
        }

        let resizeTimer;
        $(window).on('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(() => {
                if (lastFetchedTableData.length > 0) {
                    renderTableRows(lastFetchedTableData);
                }
            }, 250);
        });

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
                                    backgroundColor: 'rgba(16, 185, 129, 0.85)', // Emerald-500
                                    borderRadius: 6,
                                    barPercentage: 0.6,
                                    categoryPercentage: 0.8,
                                    hoverBackgroundColor: '#059669'
                                },
                                {
                                    label: 'Keluar',
                                    data: keluar,
                                    backgroundColor: 'rgba(244, 63, 94, 0.85)', // Rose-500
                                    borderRadius: 6,
                                    barPercentage: 0.6,
                                    categoryPercentage: 0.8,
                                    hoverBackgroundColor: '#e11d48'
                                },
                                {
                                    type: 'line',
                                    label: 'Tren Stok Masuk',
                                    data: masuk,
                                    borderColor: '#059669', // Emerald-600
                                    borderWidth: 2,
                                    backgroundColor: 'transparent',
                                    tension: 0.4, // Lebih melengkung halus
                                    pointRadius: 0,
                                    pointHoverRadius: 5,
                                    pointHoverBackgroundColor: '#ffffff',
                                    pointHoverBorderWidth: 2
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
                            plugins: {
                                legend: {
                                    position: 'top',
                                    labels: {
                                        usePointStyle: true,
                                        boxWidth: 8,
                                        padding: 20,
                                        font: {
                                            family: "'Inter', sans-serif",
                                            weight: '600',
                                            size: 12
                                        },
                                        color: '#64748b'
                                    }
                                },
                                tooltip: {
                                    backgroundColor: 'rgba(15, 23, 42, 0.95)',
                                    titleFont: {
                                        family: "'Inter', sans-serif",
                                        size: 13,
                                        weight: '700'
                                    },
                                    bodyFont: {
                                        family: "'Inter', sans-serif",
                                        size: 13,
                                        weight: '500'
                                    },
                                    padding: 16,
                                    cornerRadius: 12,
                                    boxPadding: 6,
                                    usePointStyle: true,
                                    callbacks: {
                                        label: ctx =>
                                            ` ${ctx.dataset.label}: ${Number(ctx.parsed.y ?? ctx.parsed).toLocaleString()} Pcs`
                                    }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        font: {
                                            family: "'Inter', sans-serif",
                                            size: 11
                                        },
                                        color: '#94a3b8',
                                        padding: 10
                                    },
                                    grid: {
                                        color: 'rgba(226, 232, 240, 0.5)',
                                        drawBorder: false
                                    }
                                },
                                x: {
                                    ticks: {
                                        font: {
                                            family: "'Inter', sans-serif",
                                            size: 11
                                        },
                                        color: '#94a3b8',
                                        maxTicksLimit: 12
                                    },
                                    grid: {
                                        display: false,
                                        drawBorder: false
                                    }
                                }
                            }
                        }
                    });
                });
        }

        function exportCsv() {
            if (!Array.isArray(lastFetchedTableData) || lastFetchedTableData.length === 0) {
                toast('Tidak ada data untuk diekspor.', 'error');
                return;
            }
            const header = ['No', 'Heat/Lot No', 'No Drawing', 'Tipe Valve', 'Spare Part', 'Posisi', 'Stok Awal',
                'Qty Masuk', 'Qty Keluar', 'Stok Akhir'
            ];
            const rows = [header.join(',')];

            lastFetchedTableData.forEach((item, idx) => {
                const row = [
                    idx + 1,
                    sanitizeCsv(item.material?.heat_lot_no),
                    sanitizeCsv(item.material?.no_drawing),
                    sanitizeCsv(getValveNames(item)),
                    sanitizeCsv(item.material?.spare_part_name),
                    sanitizeCsv(item.material?.rack_name),
                    item.material?.stock_awal ?? 0,
                    item.qty_in ?? 0,
                    item.qty_out ?? 0,
                    item.stock_akhir ?? 0
                ];
                rows.push(row.join(','));
            });
            const blob = new Blob(['\uFEFF' + rows.join('\n')], {
                type: 'text/csv;charset=utf-8;'
            });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `Report_Inventory_MCI_${new Date().toISOString().slice(0,10)}.csv`;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            toast('Laporan CSV berhasil diunduh.', 'success');
        }

        function animateCount(elSelector, toValue) {
            const el = document.querySelector(elSelector);
            if (!el) return;
            const start = Number(el.textContent.replace(/[^0-9]/g, '')) || 0;
            const end = Number(toValue) || 0;
            if (start === end) {
                el.textContent = end.toLocaleString();
                return;
            }

            const duration = 1000;
            const stepTime = 20;
            const steps = Math.ceil(duration / stepTime);
            let currentStep = 0;

            // Ease out function for smoother counter
            const timer = setInterval(() => {
                currentStep++;
                const progress = currentStep / steps;
                const easeOutProgress = 1 - Math.pow(1 - progress, 3);
                const val = Math.round(start + (end - start) * easeOutProgress);

                el.textContent = val.toLocaleString();
                if (currentStep >= steps) {
                    clearInterval(timer);
                    el.textContent = end.toLocaleString();
                }
            }, stepTime);
        }

        function formatNumber(n) {
            return (n === null || isNaN(Number(n))) ? '0' : Number(n).toLocaleString('id-ID');
        }

        function toast(message, type = 'info') {
            const bg = type === 'error' ? 'bg-rose-600' : (type === 'success' ? 'bg-emerald-600' : 'bg-slate-800');
            const $t = $('<div>').addClass(
                `${bg} text-white px-5 py-3.5 rounded-xl shadow-xl fixed right-6 bottom-6 z-50 font-bold text-sm tracking-wide flex items-center transform transition-all`
                ).html(message).hide();
            $('body').append($t);
            $t.fadeIn(200).delay(3500).fadeOut(400, function() {
                $(this).remove();
            });
        }

        function sanitizeCsv(v) {
            if (!v) return '';
            const s = String(v).replace(/"/g, '""');
            return /[\n,",;]/.test(s) ? `"${s}"` : s;
        }

        function escapeHtml(text) {
            if (!text) return '';
            return String(text).replace(/[&<>"']/g, m => ({
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            })[m]);
        }
    </script>
@endpush

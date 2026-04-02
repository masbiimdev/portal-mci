@extends('layouts.home')

@section('title', 'MCI | Portal Inventory')

@push('css')
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700;800&display=swap"
        rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --bento-radius: 28px;
            --bento-gap: 20px;
            --surface-bg: #f0f4f8;
            --card-bg: #ffffff;
            --primary: #0ea5e9;
            --transition-bento: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--surface-bg);
            /* Pola titik-titik (dot pattern) untuk kesan modern & rapi */
            background-image: radial-gradient(#cbd5e1 1px, transparent 0);
            background-size: 32px 32px;
            color: #334155;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* ============== BENTO CARD STYLE ============== */
        .bento-card {
            background: var(--card-bg);
            border-radius: var(--bento-radius);
            border: 1px solid rgba(255, 255, 255, 0.8);
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.05), inset 0 1px 0 rgba(255, 255, 255, 0.8);
            transition: var(--transition-bento);
            position: relative;
            overflow: hidden;
        }

        .bento-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.08), inset 0 1px 0 rgba(255, 255, 255, 1);
        }

        /* ============== BENTO STATS (TOP CARDS) ============== */
        .bento-stat {
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 160px;
        }

        .stat-icon-wrap {
            width: 52px;
            height: 52px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 16px -4px rgba(0, 0, 0, 0.1);
        }

        .stat-sky {
            background: #e0f2fe;
            color: #0284c7;
            box-shadow: 0 8px 16px -4px rgba(2, 132, 199, 0.25);
        }

        .stat-emerald {
            background: #d1fae5;
            color: #059669;
            box-shadow: 0 8px 16px -4px rgba(5, 150, 105, 0.25);
        }

        .stat-rose {
            background: #ffe4e6;
            color: #e11d48;
            box-shadow: 0 8px 16px -4px rgba(225, 29, 72, 0.25);
        }

        .stat-amber {
            background: #fef3c7;
            color: #d97706;
            box-shadow: 0 8px 16px -4px rgba(217, 119, 6, 0.25);
        }

        /* Kaca pembesar efek pada stat */
        .bento-stat::after {
            content: '';
            position: absolute;
            right: -30px;
            bottom: -30px;
            width: 120px;
            height: 120px;
            border-radius: 50%;
            opacity: 0.05;
            transition: var(--transition-bento);
        }

        .bento-stat:hover::after {
            transform: scale(1.2);
        }

        .bento-stat.bg-sky::after {
            background: #0284c7;
        }

        .bento-stat.bg-emerald::after {
            background: #059669;
        }

        .bento-stat.bg-rose::after {
            background: #e11d48;
        }

        .bento-stat.bg-amber::after {
            background: #d97706;
        }

        /* ============== TABLE ENHANCEMENTS ============== */
        .table-responsive-wrapper {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .table-responsive-wrapper::-webkit-scrollbar {
            height: 8px;
            width: 8px;
        }

        .table-responsive-wrapper::-webkit-scrollbar-track {
            background: transparent;
        }

        .table-responsive-wrapper::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
            border: 2px solid white;
        }

        .table-responsive-wrapper::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        #inventoryTable {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        #inventoryTable th {
            letter-spacing: 0.05em;
            color: #64748b;
            font-weight: 700;
            background-color: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
            padding: 1rem 1.5rem;
            text-transform: uppercase;
            font-size: 0.75rem;
        }

        #inventoryTable td {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }

        #inventoryBody tr:last-child td {
            border-bottom: none;
        }

        #inventoryBody tr {
            transition: background-color 0.2s;
        }

        #inventoryBody tr:hover {
            background-color: #f8fafc;
        }

        .badge-low {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background-color: #fef2f2;
            color: #e11d48;
            border: 1px solid #fecdd3;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 0.65rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .badge-low::before {
            content: '';
            display: block;
            width: 6px;
            height: 6px;
            background-color: #e11d48;
            border-radius: 50%;
            animation: pulse-dot 2s infinite;
        }

        @keyframes pulse-dot {
            0% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(225, 29, 72, 0.4);
            }

            70% {
                transform: scale(1);
                box-shadow: 0 0 0 6px rgba(225, 29, 72, 0);
            }

            100% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(225, 29, 72, 0);
            }
        }

        .low-stock-row td {
            background-color: #fffcf5 !important;
        }

        .low-stock-row:hover td {
            background-color: #fff7ed !important;
        }

        /* ============== INPUTS & BUTTONS ============== */
        .input-bento {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            transition: var(--transition-bento);
        }

        .input-bento:focus {
            background: #ffffff;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px #e0f2fe;
            outline: none;
        }

        .btn-bento {
            transition: var(--transition-bento);
        }

        .btn-bento:hover {
            transform: translateY(-2px);
        }

        .btn-bento:active {
            transform: translateY(0);
        }

        /* ============== SKELETON ============== */
        .skeleton {
            background: linear-gradient(90deg, #f1f5f9 25%, #e2e8f0 50%, #f1f5f9 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
            border-radius: 12px;
        }

        @keyframes loading {
            to {
                background-position: -200% 0;
            }
        }

        .font-mono {
            font-family: 'JetBrains Mono', monospace;
        }
    </style>
@endpush

@section('content')
    <div class="max-w-[1400px] mx-auto py-10 px-4 sm:px-6 lg:px-8">

        <header class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-5">
            <div>
                <nav class="flex items-center mb-3 text-xs font-bold text-slate-400 uppercase tracking-widest">
                    <span class="hover:text-slate-600 cursor-pointer transition-colors">Inventory</span>
                    <span class="mx-2 text-slate-300">/</span>
                    <span class="text-sky-500">Dashboard</span>
                </nav>
                <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-800 tracking-tight leading-tight">
                    Portal Inventory <span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-sky-500 to-blue-600">MCI</span>
                </h1>
                <p class="text-slate-500 mt-2 font-medium">Monitoring pergerakan aset dan ketersediaan stok secara
                    real-time.</p>
            </div>

            <div class="flex items-center gap-3 w-full md:w-auto">
                <button id="btnExport"
                    class="btn-bento flex-1 md:flex-none inline-flex justify-center items-center bg-white border border-slate-200 px-6 py-3 rounded-2xl shadow-sm text-sm font-bold text-slate-700 hover:bg-slate-50">
                    <svg class="w-4 h-4 mr-2 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Ekspor Laporan
                </button>
                <button id="btnHelp"
                    class="btn-bento bg-slate-800 text-white p-3 px-4 rounded-2xl shadow-lg shadow-slate-200/50 text-sm font-bold hover:bg-slate-900 flex items-center justify-center"
                    title="Pusat Bantuan">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </button>
            </div>
        </header>

        <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 sm:gap-6 mb-6">
            <div class="bento-card bento-stat bg-sky">
                <div class="flex justify-between items-start mb-4 relative z-10">
                    <div>
                        <div class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Total Material</div>
                        <div class="text-3xl font-black text-slate-800 font-mono tracking-tight" id="totalBarang">—</div>
                    </div>
                    <div class="stat-icon-wrap stat-sky">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                </div>
                <div class="text-xs font-semibold text-slate-500 relative z-10">Total item terdaftar di sistem</div>
            </div>

            <div class="bento-card bento-stat bg-emerald">
                <div class="flex justify-between items-start mb-4 relative z-10">
                    <div>
                        <div class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Total Masuk</div>
                        <div class="text-3xl font-black text-slate-800 font-mono tracking-tight" id="totalMasuk">—</div>
                    </div>
                    <div class="stat-icon-wrap stat-emerald">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12" />
                        </svg>
                    </div>
                </div>
                <div
                    class="text-[11px] font-bold text-emerald-700 bg-emerald-100/80 inline-block px-2.5 py-1 rounded-lg w-max relative z-10">
                    Bulan Ini</div>
            </div>

            <div class="bento-card bento-stat bg-rose">
                <div class="flex justify-between items-start mb-4 relative z-10">
                    <div>
                        <div class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Total Keluar</div>
                        <div class="text-3xl font-black text-slate-800 font-mono tracking-tight" id="totalKeluar">—</div>
                    </div>
                    <div class="stat-icon-wrap stat-rose">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4" />
                        </svg>
                    </div>
                </div>
                <div
                    class="text-[11px] font-bold text-rose-700 bg-rose-100/80 inline-block px-2.5 py-1 rounded-lg w-max relative z-10">
                    Bulan Ini</div>
            </div>

            <div class="bento-card bento-stat bg-amber border-b-4 border-amber-400">
                <div class="flex justify-between items-start mb-4 relative z-10">
                    <div>
                        <div class="text-xs font-bold text-amber-500/80 uppercase tracking-widest mb-1">Stok Menipis</div>
                        <div class="text-3xl font-black text-slate-800 font-mono tracking-tight" id="belowMinimum">—</div>
                    </div>
                    <div class="stat-icon-wrap stat-amber">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                </div>
                <div
                    class="text-[11px] font-bold text-amber-700 bg-amber-100/80 inline-block px-2.5 py-1 rounded-lg w-max relative z-10">
                    Butuh Perhatian Segera</div>
            </div>
        </section>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-5 sm:gap-6 mb-6">
            <div class="lg:col-span-3 bento-card p-6 sm:p-8 flex flex-col">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
                    <div>
                        <h2 class="text-xl font-extrabold text-slate-800">Visualisasi Mutasi</h2>
                        <p class="text-sm text-slate-500 mt-1 font-medium">Grafik perbandingan pergerakan barang masuk dan
                            keluar.</p>
                    </div>
                    <select id="presetRange"
                        class="input-bento text-slate-700 rounded-xl text-sm font-bold p-2.5 w-full sm:w-auto cursor-pointer">
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
                <div class="bento-card p-6 sm:p-8 bg-slate-50/50 h-full">
                    <h3 class="text-base font-extrabold text-slate-800 mb-6 flex items-center">
                        <span class="p-2 bg-sky-100 text-sky-600 rounded-xl mr-3 shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                            </svg>
                        </span>
                        Filter Parameter
                    </h3>

                    <div class="space-y-5">
                        <div>
                            <label
                                class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Bulan</label>
                            <select id="bulan"
                                class="w-full input-bento rounded-xl text-sm font-semibold p-3.5 cursor-pointer">
                                <option value="">Semua Bulan</option>
                                @foreach ([1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'] as $key => $nama)
                                    <option value="{{ $key }}">{{ $nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label
                                class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Tahun</label>
                            <select id="tahun"
                                class="w-full input-bento rounded-xl text-sm font-semibold p-3.5 cursor-pointer">
                                <option value="">Semua Tahun</option>
                                @for ($t = date('Y'); $t >= date('Y') - 5; $t--)
                                    <option value="{{ $t }}">{{ $t }}</option>
                                @endfor
                            </select>
                        </div>

                        <div class="pt-4 flex flex-col gap-3">
                            <button id="btnFilter"
                                class="btn-bento w-full bg-slate-800 text-white py-3.5 rounded-xl font-bold text-sm shadow-lg shadow-slate-200/50 hover:bg-slate-900">
                                Terapkan Filter
                            </button>
                            <button id="btnClear"
                                class="btn-bento w-full bg-white border border-slate-200 text-slate-600 py-3 rounded-xl font-bold text-sm hover:bg-slate-50">
                                Reset Ulang
                            </button>
                        </div>
                    </div>
                </div>
            </aside>
        </div>

        <section class="bento-card flex flex-col p-0">
            <div class="p-6 sm:p-8 border-b border-slate-100 bg-white">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-5">
                    <div>
                        <h2 class="text-xl font-extrabold text-slate-800">Detail Data Stok</h2>
                        <p class="text-sm text-slate-500 mt-1 font-medium">Informasi rincian posisi dan kuantitas material.
                        </p>
                    </div>

                    <div class="relative w-full md:w-96 group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400 group-focus-within:text-sky-500 transition-colors"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input id="searchInput" type="text" placeholder="Cari Heat No, Drawing, Valve, Part..."
                            class="block w-full pl-12 pr-10 py-3.5 input-bento rounded-2xl text-sm font-medium transition-all">
                        <button id="btnClearSearch"
                            class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-rose-500 hidden transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div id="inventoryCards" class="grid grid-cols-1 gap-4 p-6 lg:hidden bg-slate-50/30"></div>

            <div class="table-responsive-wrapper hidden lg:block bg-white flex-1">
                <table id="inventoryTable">
                    <thead>
                        <tr>
                            <th class="w-16 text-center">No</th>
                            <th>Informasi Material</th>
                            <th>Tipe Valve & Spare Part</th>
                            <th>Lokasi (Rak)</th>
                            <th class="text-center">Stok Awal</th>
                            <th class="text-center">Mutasi (In/Out)</th>
                            <th class="text-right">Stok Akhir</th>
                        </tr>
                    </thead>
                    <tbody id="inventoryBody">
                    </tbody>
                </table>
            </div>

            <div id="tableFooter"
                class="p-6 border-t border-slate-100 bg-white flex flex-col sm:flex-row items-center justify-between gap-4 hidden">
                <div class="text-sm text-slate-500 font-medium">
                    Menampilkan <span id="showingRange" class="text-slate-800 font-extrabold px-1">—</span> dari <span
                        id="totalCount" class="text-slate-800 font-extrabold px-1">—</span> entri
                </div>

                <div class="flex items-center gap-4 w-full sm:w-auto justify-between sm:justify-end">
                    <div class="flex items-center bg-slate-50 border border-slate-200 rounded-xl p-1 shadow-sm">
                        <button id="btnPrev"
                            class="p-2 hover:bg-white hover:shadow-sm rounded-lg disabled:opacity-30 disabled:hover:bg-transparent disabled:hover:shadow-none transition-all text-slate-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>
                        <span class="px-4 text-xs font-bold text-slate-500">Hal <span id="currentPage"
                                class="text-sky-600 font-black text-sm mx-1">1</span> / <span
                                id="totalPages">1</span></span>
                        <button id="btnNext"
                            class="p-2 hover:bg-white hover:shadow-sm rounded-lg disabled:opacity-30 disabled:hover:bg-transparent disabled:hover:shadow-none transition-all text-slate-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>

                    <select id="pageSize"
                        class="input-bento rounded-xl text-sm font-extrabold p-2.5 cursor-pointer shadow-sm">
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
                `<tr><td colspan="7" class="py-16 text-center"><div class="skeleton h-6 w-64 mx-auto mb-4"></div><div class="skeleton h-4 w-40 mx-auto"></div></td></tr>`
                );
            $('#inventoryCards').html(
                `<div class="py-6"><div class="skeleton h-48 w-full rounded-[24px] mb-5"></div><div class="skeleton h-48 w-full rounded-[24px]"></div></div>`
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
                        `<div class="py-8 text-center font-bold text-rose-500 bg-rose-50 rounded-[24px] border border-rose-100">Gagal memuat data.</div>`
                        );
                    toast('Gagal memuat data tabel. Coba muat ulang halaman.', 'error');
                });
        }

        function renderTableRows(data) {
            const total = Array.isArray(data) ? data.length : 0;
            $('#totalCount').text(total);

            if (total === 0) {
                $('#inventoryBody').html(
                    `<tr><td colspan="7" class="py-20 text-slate-400 font-medium text-center bg-slate-50/30">Data tidak ditemukan untuk kriteria pencarian ini.</td></tr>`
                    );
                $('#inventoryCards').html(
                    `<div class="py-16 text-center text-slate-400 bg-slate-50 border border-slate-100 rounded-[24px]">Data tidak ditemukan.</div>`
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
                    const borderClass = isLow ? 'border-amber-300 bg-amber-50/30' : 'border-slate-200 bg-white';

                    cardsHtml += `
                    <article class="p-6 border ${borderClass} rounded-[24px] shadow-sm hover:shadow-md transition-shadow mb-4">
                        <div class="flex justify-between items-start mb-5">
                            <div>
                                <span class="text-[10px] font-bold text-slate-400 bg-slate-100 px-2 py-1 rounded-lg mr-2">#${i}</span>
                                <span class="font-extrabold text-slate-800 text-lg tracking-tight">${heatLot}</span>
                            </div>
                            <span class="text-[10px] font-extrabold bg-slate-100 border border-slate-200 text-slate-600 px-3 py-1.5 rounded-xl flex items-center">
                                <svg class="w-3.5 h-3.5 mr-1 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" /></svg>
                                ${rack}
                            </span>
                        </div>
                        
                        <div class="mb-6 bg-slate-50 p-4 rounded-2xl border border-slate-100">
                            <div class="text-[11px] text-slate-400 font-bold uppercase tracking-widest mb-1.5">${noDrawing}</div>
                            <div class="text-sm font-bold text-slate-700 truncate mb-1.5">${valveNames}</div>
                            <div class="text-xs text-slate-500 font-medium flex items-center">
                                <span class="w-2 h-2 rounded-full bg-slate-300 mr-2"></span> ${sparePart}
                            </div>
                        </div>

                        <div class="grid grid-cols-4 gap-3">
                            <div class="text-center bg-slate-50 rounded-xl p-3 border border-slate-100">
                                <div class="text-[10px] font-extrabold text-slate-400 uppercase mb-1">Awal</div>
                                <div class="text-sm font-black font-mono text-slate-600">${formatNumber(stockAwal)}</div>
                            </div>
                            <div class="text-center bg-emerald-50/50 rounded-xl p-3 border border-emerald-100">
                                <div class="text-[10px] font-extrabold text-emerald-600/70 uppercase mb-1">In</div>
                                <div class="text-sm font-black font-mono text-emerald-600">+${formatNumber(qtyIn)}</div>
                            </div>
                            <div class="text-center bg-rose-50/50 rounded-xl p-3 border border-rose-100">
                                <div class="text-[10px] font-extrabold text-rose-600/70 uppercase mb-1">Out</div>
                                <div class="text-sm font-black font-mono text-rose-600">-${formatNumber(qtyOut)}</div>
                            </div>
                            <div class="text-center ${isLow ? 'bg-amber-100 border border-amber-200' : 'bg-sky-50 border border-sky-100'} rounded-xl p-3 shadow-sm flex flex-col justify-center">
                                <div class="text-[10px] font-extrabold ${isLow ? 'text-amber-700' : 'text-sky-700'} uppercase mb-1">Akhir</div>
                                <div class="text-base font-black font-mono ${isLow ? 'text-amber-700' : 'text-sky-700'}">${formatNumber(stock)}</div>
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
                    <tr class="hover:bg-slate-50/80 group ${isLow ? 'low-stock-row' : ''}">
                        <td class="text-sm text-slate-400 font-bold text-center">${i}</td>
                        <td>
                            <div class="flex items-center gap-4">
                                <div class="w-11 h-11 rounded-xl bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-400 group-hover:bg-sky-50 group-hover:text-sky-500 group-hover:border-sky-100 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                                </div>
                                <div>
                                    <div class="text-[15px] font-extrabold text-slate-800 tracking-tight">${heatLot}</div>
                                    <div class="text-[11px] text-slate-500 font-bold uppercase tracking-widest mt-1">${noDrawing}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="text-sm text-slate-800 font-bold truncate max-w-[250px]" title="${valveNames}">${valveNames}</div>
                            <div class="text-xs text-slate-500 font-medium mt-1.5 flex items-center">
                                <span class="w-2 h-2 rounded-full bg-slate-300 mr-2"></span> ${sparePart}
                            </div>
                        </td>
                        <td>
                            <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-[11px] font-extrabold bg-slate-100 border border-slate-200 text-slate-600 shadow-sm uppercase tracking-wide">
                                <svg class="w-3.5 h-3.5 mr-1.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" /></svg>
                                ${rack}
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="text-sm font-black font-mono text-slate-600">${formatNumber(stockAwal)}</span>
                        </td>
                        <td class="text-center">
                            <div class="flex items-center justify-center gap-2">
                                <span class="inline-flex items-center text-[11px] font-black font-mono text-emerald-600 bg-emerald-50 px-2.5 py-1.5 rounded-lg border border-emerald-100 shadow-sm" title="Total Masuk">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 14l-7 7m0 0l-7-7m7 7V3" /></svg>
                                    ${formatNumber(qtyIn)}
                                </span>
                                <span class="inline-flex items-center text-[11px] font-black font-mono text-rose-600 bg-rose-50 px-2.5 py-1.5 rounded-lg border border-rose-100 shadow-sm" title="Total Keluar">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 10l7-7m0 0l7 7m-7-7v18" /></svg>
                                    ${formatNumber(qtyOut)}
                                </span>
                            </div>
                        </td>
                        <td class="text-right relative">
                            <div class="text-xl font-mono font-black tracking-tight ${isLow ? 'text-amber-600' : 'text-slate-800'}">${formatNumber(stock)}</div>
                            ${isLow ? '<div class="badge-low absolute right-4 -bottom-1 shadow-sm">Kritis</div>' : ''}
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
                                    backgroundColor: 'rgba(16, 185, 129, 0.9)',
                                    borderRadius: 6,
                                    barPercentage: 0.5,
                                    categoryPercentage: 0.8,
                                    hoverBackgroundColor: '#059669'
                                },
                                {
                                    label: 'Keluar',
                                    data: keluar,
                                    backgroundColor: 'rgba(244, 63, 94, 0.9)',
                                    borderRadius: 6,
                                    barPercentage: 0.5,
                                    categoryPercentage: 0.8,
                                    hoverBackgroundColor: '#e11d48'
                                },
                                {
                                    type: 'line',
                                    label: 'Tren Masuk',
                                    data: masuk,
                                    borderColor: '#0284c7',
                                    borderWidth: 2.5,
                                    backgroundColor: 'transparent',
                                    tension: 0.4,
                                    pointRadius: 0,
                                    pointHoverRadius: 6,
                                    pointHoverBackgroundColor: '#ffffff',
                                    pointHoverBorderWidth: 2.5
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
                                            family: "'Plus Jakarta Sans', sans-serif",
                                            weight: '700',
                                            size: 12
                                        },
                                        color: '#64748b'
                                    }
                                },
                                tooltip: {
                                    backgroundColor: 'rgba(15, 23, 42, 0.95)',
                                    titleFont: {
                                        family: "'Plus Jakarta Sans', sans-serif",
                                        size: 13,
                                        weight: '800'
                                    },
                                    bodyFont: {
                                        family: "'JetBrains Mono', monospace",
                                        size: 13,
                                        weight: '600'
                                    },
                                    padding: 16,
                                    cornerRadius: 16,
                                    boxPadding: 8,
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
                                            family: "'JetBrains Mono', monospace",
                                            size: 11,
                                            weight: '600'
                                        },
                                        color: '#94a3b8',
                                        padding: 12
                                    },
                                    grid: {
                                        color: 'rgba(226, 232, 240, 0.6)',
                                        drawBorder: false,
                                        borderDash: [5, 5]
                                    }
                                },
                                x: {
                                    ticks: {
                                        font: {
                                            family: "'Plus Jakarta Sans', sans-serif",
                                            size: 11,
                                            weight: '700'
                                        },
                                        color: '#64748b',
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
                `${bg} text-white px-6 py-4 rounded-2xl shadow-xl fixed right-6 bottom-6 z-50 font-bold text-sm tracking-wide flex items-center transform transition-all`
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

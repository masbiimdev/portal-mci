@extends('layouts.home')

@section('title', 'MCI | Portal NCR Log')

@push('css')
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --primary: #0ea5e9;
            --primary-light: #e0f2fe;
            --secondary: #6366f1;
            --surface: rgba(255, 255, 255, 0.85);
            --surface-solid: #ffffff;
            --bg-color: #f8fafc;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --border-color: rgba(226, 232, 240, 0.8);
            --shadow-soft: 0 4px 20px -2px rgba(15, 23, 42, 0.05);
            --shadow-float: 0 10px 30px -5px rgba(15, 23, 42, 0.08);
            --radius-xl: 24px;
            --radius-lg: 16px;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-main);
            -webkit-font-smoothing: antialiased;
        }

        /* --- BACKGROUND DENGAN GLOW EFFECTS --- */
        .dashboard-bg {
            position: relative;
            min-height: 100vh;
            overflow: hidden;
            z-index: 1;
        }

        .dashboard-bg::before {
            content: '';
            position: absolute;
            top: -10%;
            left: -10%;
            width: 50vw;
            height: 50vh;
            background: radial-gradient(circle, rgba(14, 165, 233, 0.15) 0%, transparent 60%);
            z-index: -1;
            pointer-events: none;
        }

        .dashboard-bg::after {
            content: '';
            position: absolute;
            bottom: -10%;
            right: -5%;
            width: 60vw;
            height: 60vh;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.1) 0%, transparent 60%);
            z-index: -1;
            pointer-events: none;
        }

        /* --- GLASSMORPHISM CARDS --- */
        .glass-card {
            background: var(--surface);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: var(--shadow-soft);
            border-radius: var(--radius-xl);
        }

        .summary-card {
            padding: 1.75rem;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
            position: relative;
            overflow: hidden;
        }

        .summary-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-float);
            background: var(--surface-solid);
        }

        .summary-icon-wrapper {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.25rem;
        }

        .card-total .summary-icon-wrapper {
            background: #e0f2fe;
            color: #0284c7;
        }

        /* DIBALIK: Open = Hijau, Closed = Merah */
        .card-open .summary-icon-wrapper {
            background: #d1fae5;
            color: #059669;
        }

        .card-monitoring .summary-icon-wrapper {
            background: #fef3c7;
            color: #d97706;
        }

        .card-closed .summary-icon-wrapper {
            background: #fee2e2;
            color: #e11d48;
        }

        .summary-title {
            font-size: 0.8rem;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .summary-value {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--text-main);
            line-height: 1;
            margin-top: 0.5rem;
            letter-spacing: -0.03em;
        }

        /* --- SEGMENTED TABS --- */
        .segmented-control {
            display: inline-flex;
            background: rgba(226, 232, 240, 0.6);
            padding: 0.35rem;
            border-radius: 99px;
            gap: 0.25rem;
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            margin-bottom: 1.5rem;
            max-width: 100%;
            overflow-x: auto;
        }

        .segment-btn {
            padding: 0.6rem 1.5rem;
            border-radius: 99px;
            font-size: 0.85rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            white-space: nowrap;
            border: none;
            display: flex;
            align-items: center;
            gap: 8px;
            background: transparent;
            color: #64748b;
        }

        .segment-btn:hover {
            color: var(--text-main);
        }

        .segment-btn.active {
            background: #ffffff;
            color: var(--text-main);
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.08);
        }

        .segment-badge {
            padding: 0.15rem 0.6rem;
            border-radius: 99px;
            font-size: 0.7rem;
            font-weight: 800;
            background: #e2e8f0;
            color: inherit;
            transition: 0.3s;
        }

        .segment-btn.active .segment-badge {
            background: var(--bg-color);
            color: var(--primary-dark);
        }

        /* DIBALIK: Open = Hijau, Closed = Merah */
        .segment-open.active .segment-badge {
            background: #d1fae5;
            color: #059669;
        }

        .segment-mon.active .segment-badge {
            background: #fef3c7;
            color: #d97706;
        }

        .segment-closed.active .segment-badge {
            background: #fee2e2;
            color: #e11d48;
        }

        /* --- MODERN CONTROLS --- */
        .controls-bar {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }

        .input-glass {
            border: 1px solid var(--border-color);
            border-radius: 14px;
            padding: 0.7rem 1.25rem;
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--text-main);
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(8px);
            transition: all 0.2s ease;
            outline: none;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.02);
        }

        .input-glass:focus {
            background: #ffffff;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.15);
        }

        .btn-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 14px;
            color: var(--text-muted);
            cursor: pointer;
            transition: all 0.2s;
            height: 46px;
            width: 46px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.02);
        }

        .btn-icon:hover {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(14, 165, 233, 0.2);
        }

        /* --- FLOATING TABLE --- */
        .table-wrapper {
            overflow-x: auto;
            padding: 0.5rem;
            margin: -0.5rem;
        }

        table.floating-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 10px;
            min-width: 1000px;
        }

        table.floating-table th {
            color: #94a3b8;
            font-weight: 800;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 0 1.5rem 0.5rem;
            text-align: left;
            border: none;
        }

        table.floating-table tbody tr {
            background-color: var(--surface-solid);
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.03);
            border-radius: var(--radius-lg);
        }

        table.floating-table tbody tr:hover {
            transform: translateY(-4px) scale(1.002);
            box-shadow: 0 12px 24px -6px rgba(15, 23, 42, 0.1);
            z-index: 10;
            position: relative;
        }

        table.floating-table td {
            padding: 1.25rem 1.5rem;
            font-size: 0.875rem;
            color: var(--text-main);
            vertical-align: middle;
            border: none;
        }

        table.floating-table td:first-child {
            border-radius: var(--radius-lg) 0 0 var(--radius-lg);
        }

        table.floating-table td:last-child {
            border-radius: 0 var(--radius-lg) var(--radius-lg) 0;
        }

        /* --- GLOWING BADGES --- */
        .badge-glow {
            padding: 0.45rem 0.85rem;
            border-radius: 10px;
            font-size: 0.75rem;
            font-weight: 800;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            letter-spacing: 0.03em;
        }

        .badge-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            box-shadow: 0 0 0 3px currentColor;
            opacity: 0.8;
        }

        /* DIBALIK: Open = Hijau, Closed = Merah */
        .badge-open {
            background: #ecfdf5;
            color: #059669;
        }

        .badge-open .badge-dot {
            animation: pulse 1.5s infinite;
        }

        .badge-monitoring {
            background: #fffbeb;
            color: #d97706;
        }

        .badge-monitoring .badge-dot {
            animation: pulse 2s infinite;
        }

        .badge-closed {
            background: #fef2f2;
            color: #e11d48;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(currentColor, 0.4);
            }

            70% {
                box-shadow: 0 0 0 6px rgba(currentColor, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(currentColor, 0);
            }
        }

        /* --- ACTION BUTTON --- */
        .btn-view {
            background: #f8fafc;
            color: #475569;
            border: 1px solid #e2e8f0;
            padding: 0.5rem 1.25rem;
            border-radius: 10px;
            font-size: 0.8rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-view:hover {
            background: var(--text-main);
            color: white;
            border-color: var(--text-main);
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.2);
            transform: translateY(-2px);
        }

        /* --- PAGINATION --- */
        .pagination {
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }

        .page-btn {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            border: 1px solid var(--border-color);
            background: white;
            color: var(--text-muted);
            font-weight: 700;
            cursor: pointer;
            transition: 0.2s;
        }

        .page-btn:hover:not(:disabled) {
            border-color: var(--primary);
            color: var(--primary);
        }

        .page-btn.active {
            background: var(--text-main);
            color: white;
            border-color: var(--text-main);
            box-shadow: 0 4px 10px rgba(15, 23, 42, 0.2);
        }

        .page-btn:disabled {
            opacity: 0.4;
            cursor: not-allowed;
            background: var(--bg-color);
        }

        /* --- MODAL BEAUTIFICATION --- */
        .modal-backdrop {
            background: rgba(15, 23, 42, 0.4);
            backdrop-filter: blur(8px);
        }

        .modal-card {
            max-height: 90vh;
            overflow-y: auto;
            border-radius: 28px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.3);
            animation: modalPop 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            background: var(--surface-solid);
            border: 1px solid rgba(255, 255, 255, 0.8);
        }

        @keyframes modalPop {
            from {
                opacity: 0;
                transform: scale(0.95) translateY(30px);
            }

            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        .detail-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        @media(min-width: 640px) {
            .detail-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .detail-item {
            background: rgba(248, 250, 252, 0.6);
            padding: 1.5rem;
            border-radius: 20px;
            border: 1px solid rgba(226, 232, 240, 0.8);
            box-shadow: inset 0 2px 4px rgba(255, 255, 255, 0.5);
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .detail-label {
            font-size: 0.75rem;
            color: var(--text-muted);
            text-transform: uppercase;
            font-weight: 800;
            letter-spacing: 0.05em;
            margin-bottom: 0.75rem;
        }

        .detail-value {
            font-size: 1rem;
            font-weight: 700;
            color: var(--text-main);
            line-height: 1.5;
        }
    </style>
@endpush

@section('content')

    {{-- ==== PERHITUNGAN DATA DARI DATABASE ==== --}}
    @php
        // $ncrs akan otomatis dipassing dari NcrController@index atau dashboard
        $ncrs = $ncrs ?? collect([]); // Menghindari error jika tidak ada data sama sekali

        $totalNcr = $ncrs->count();
        $statusOpen = $ncrs->where('status', 'Open')->count();
        $statusMonitoring = $ncrs->where('status', 'Monitoring')->count();
        $statusClosed = $ncrs->where('status', 'Closed')->count();
        $criticalOpen = $ncrs->where('severity', 'Critical')->where('status', 'Open')->count();

        // Data untuk Pie Chart
        $pieData = [
            'open' => $statusOpen,
            'monitoring' => $statusMonitoring,
            'closed' => $statusClosed,
        ];

        // Hitung Data untuk Line Chart (Trend Bulanan Tahun Ini)
        $barLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $barValues = array_fill(0, 12, 0); // Inisialisasi 12 bulan dengan nilai 0

        foreach ($ncrs as $ncr) {
            $date = \Carbon\Carbon::parse($ncr->issue_date);
            if ($date->year == date('Y')) {
                $monthIndex = $date->month - 1; // Array mulai dari 0
                $barValues[$monthIndex]++;
            }
        }
    @endphp

    <div class="dashboard-bg py-8 pb-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- HEADER SECTION --}}
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
                <div>
                    <h1
                        class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight mb-2 flex items-center gap-3">
                        <span
                            class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-sky-500 to-indigo-500 text-white flex items-center justify-center shadow-lg shadow-sky-500/30">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </span>
                        Portal NCR Log
                    </h1>
                    <p class="text-slate-500 font-medium ml-1">Manajemen Laporan Ketidaksesuaian (Non-Conformance Report)
                    </p>
                </div>
            </div>

            {{-- SUMMARY CARDS --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                <div class="glass-card summary-card card-total">
                    <div class="summary-icon-wrapper"><svg class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                        </svg></div>
                    <div class="summary-title">Total Laporan</div>
                    <div class="summary-value">{{ number_format($totalNcr) }}</div>
                </div>
                <div class="glass-card summary-card card-open">
                    <div class="summary-icon-wrapper"><svg class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg></div>
                    <div class="summary-title">Status Open</div>
                    <div class="summary-value text-emerald-600">{{ number_format($statusOpen) }}</div>
                </div>
                <div class="glass-card summary-card card-monitoring">
                    <div class="summary-icon-wrapper"><svg class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg></div>
                    <div class="summary-title">Monitoring</div>
                    <div class="summary-value text-amber-600">{{ number_format($statusMonitoring) }}</div>
                </div>
                <div class="glass-card summary-card card-closed">
                    <div class="summary-icon-wrapper"><svg class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg></div>
                    <div class="summary-title">Diselesaikan</div>
                    <div class="summary-value text-rose-600">{{ number_format($statusClosed) }}</div>
                </div>
            </div>

            {{-- CHARTS SECTION --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-10">
                <div class="glass-card p-6 flex flex-col">
                    <h2
                        class="text-xs font-extrabold text-slate-500 uppercase tracking-widest mb-4 flex items-center gap-2">
                        <svg class="w-4 h-4 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                        </svg>
                        Distribusi Status
                    </h2>
                    <div class="flex-grow relative min-h-[220px] flex items-center justify-center">
                        <canvas id="statusPie"></canvas>
                    </div>
                </div>

                <div class="glass-card lg:col-span-2 p-6 flex flex-col">
                    <h2
                        class="text-xs font-extrabold text-slate-500 uppercase tracking-widest mb-4 flex items-center gap-2">
                        <svg class="w-4 h-4 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                        </svg>
                        Tren Penerbitan NCR
                    </h2>
                    <div class="flex-grow relative min-h-[220px]">
                        <canvas id="trendLine"></canvas>
                    </div>
                </div>
            </div>

            {{-- CONTROLS & TABS --}}
            <div class="glass-card p-4 mb-8">
                <div class="flex flex-col lg:flex-row justify-between items-center gap-4">

                    <div class="segmented-control" id="quickStatusTabs">
                        <button class="segment-btn active" data-status="">Semua <span
                                class="segment-badge">{{ $totalNcr }}</span></button>
                        <button class="segment-btn segment-open" data-status="open">Open <span
                                class="segment-badge">{{ $statusOpen }}</span></button>
                        <button class="segment-btn segment-mon" data-status="monitoring">Monitor <span
                                class="segment-badge">{{ $statusMonitoring }}</span></button>
                        <button class="segment-btn segment-closed" data-status="closed">Closed <span
                                class="segment-badge">{{ $statusClosed }}</span></button>
                    </div>

                    <div class="controls-bar m-0">
                        <div class="relative w-full sm:w-64">
                            <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <input id="searchInput" type="search" placeholder="Cari No. NCR, Scope..."
                                class="input-glass pl-11" />
                        </div>
                        <div class="flex gap-3">
                            <select id="yearFilter" class="input-glass cursor-pointer w-28 text-center appearance-none">
                                <option value="">Tahun</option>
                                <option value="2024">2024</option>
                                <option value="2025">2025</option>
                                <option value="2026">2026</option>
                            </select>
                            <select id="monthFilter" class="input-glass cursor-pointer w-32 text-center appearance-none">
                                <option value="">Bulan</option>
                                <option value="01">Jan</option>
                                <option value="02">Feb</option>
                                <option value="03">Mar</option>
                            </select>
                            <button id="refreshBtn" class="btn-icon" title="Refresh"><svg class="w-5 h-5"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg></button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TABLE SECTION --}}
            <div class="table-wrapper">
                <table id="dataTable" class="floating-table">
                    <thead>
                        <tr>
                            <th width="18%">No. NCR</th>
                            <th width="12%">Issue Date</th>
                            <th width="32%">Deskripsi Temuan</th>
                            <th width="15%">Scope</th>
                            <th width="13%">Status</th>
                            <th width="10%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        @php
                            $sortedNcrs = collect($ncrs ?? [])
                                ->map(function ($ncr) {
                                    $statusRaw = $ncr->status ?? '-';
                                    $sortOrder =
                                        strcasecmp($statusRaw, 'Open') === 0
                                            ? 1
                                            : (strcasecmp($statusRaw, 'Monitoring') === 0
                                                ? 2
                                                : 3);
                                    return ['data' => $ncr, 'status' => $statusRaw, 'sort_order' => $sortOrder];
                                })
                                ->sortBy('sort_order')
                                ->values();
                        @endphp

                        @forelse($sortedNcrs as $index => $item)
                            @php
                                $ncr = $item['data'];
                                $status = $item['status'];
                                $tglTerbit = \Carbon\Carbon::parse($ncr->issue_date)->format('d M Y');
                                $jsonData = json_encode([
                                    'id' => $ncr->id,
                                    'no_ncr' => $ncr->no_ncr,
                                    'issue_date' => $tglTerbit,
                                    'issue_year' => \Carbon\Carbon::parse($ncr->issue_date)->format('Y'),
                                    'issue_month' => \Carbon\Carbon::parse($ncr->issue_date)->format('m'),
                                    'issue' => $ncr->issue,
                                    'audit_scope' => $ncr->audit_scope,
                                    'status' => $status,
                                ]);

                                // DIBALIK: Open = Hijau, Closed = Merah
                                $statusClass =
                                    strcasecmp($status, 'Closed') === 0
                                        ? 'badge-closed'
                                        : (strcasecmp($status, 'Monitoring') === 0
                                            ? 'badge-monitoring'
                                            : 'badge-open');
                            @endphp

                            <tr data-item="{{ $jsonData }}">
                                <td>
                                    <div class="font-extrabold text-slate-800 text-base">{{ e($ncr->no_ncr) }}</div>
                                </td>
                                <td>
                                    <div class="font-mono text-xs font-bold text-slate-500 tracking-wider">
                                        {{ $tglTerbit }}</div>
                                </td>
                                <td>
                                    <div class="text-sm font-bold text-slate-700 line-clamp-2"
                                        title="{{ e($ncr->issue) }}">{{ e($ncr->issue) }}</div>
                                </td>
                                <td>
                                    <div class="text-xs font-extrabold text-slate-500 uppercase flex items-center gap-2">
                                        <div
                                            class="w-7 h-7 rounded-full bg-slate-100 flex items-center justify-center text-slate-500">
                                            @if (strcasecmp($ncr->audit_scope, 'Internal') === 0)
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                </svg>
                                            @elseif(strcasecmp($ncr->audit_scope, 'External') === 0)
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                                </svg>
                                            @else
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                                </svg>
                                            @endif
                                        </div>
                                        {{ e($ncr->audit_scope) }}
                                    </div>
                                </td>
                                <td>
                                    <span class="badge-glow {{ $statusClass }}"><span class="badge-dot"></span>
                                        {{ ucfirst($status) }}</span>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn-view">Detail &rarr;</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-16 text-center">
                                    <h3 class="text-lg font-bold text-slate-800">Data Kosong</h3>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-between mt-6 px-2">
                <div class="text-sm font-bold text-slate-500" id="paginationInfo">Memuat...</div>
                <div class="pagination" id="paginationControls"></div>
            </div>

        </div>
    </div>

    {{-- MODAL DETAIL --}}
    <div id="detailModal" class="fixed inset-0 hidden items-center justify-center z-[100]" role="dialog"
        aria-modal="true">
        <div class="absolute inset-0 modal-backdrop" id="modalBackdrop"></div>
        <div class="relative modal-card w-full max-w-2xl m-4 z-10 flex flex-col">
            <div
                class="px-8 py-6 border-b border-slate-100 flex justify-between items-center bg-white/60 backdrop-blur-xl sticky top-0 z-20">
                <div class="flex items-center gap-4">
                    <div
                        class="w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-500 to-sky-500 text-white flex items-center justify-center shadow-lg shadow-indigo-500/30">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div>
                        <h3 id="modalTitle" class="text-2xl font-extrabold text-slate-800 tracking-tight">Detail NCR</h3>
                        <p class="text-xs font-bold text-slate-400 mt-0.5 uppercase tracking-widest">Informasi Log Book</p>
                    </div>
                </div>
                <button id="modalClose"
                    class="p-2 bg-slate-100 hover:bg-rose-100 rounded-full transition-colors text-slate-400 hover:text-rose-500">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="p-8">
                <div id="modalBody" class="detail-grid"></div>
            </div>

            <div class="px-8 py-5 bg-slate-50/80 border-t border-slate-100 flex justify-end rounded-b-[28px]">
                <button id="modalClose2"
                    class="px-6 py-2.5 bg-slate-800 hover:bg-slate-700 text-white font-bold rounded-xl transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5">Tutup
                    Detail</button>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        window._pieData = @json($pieData ?? ['closed' => 0, 'monitoring' => 0, 'open' => 0]);
        window.__BAR_LABELS__ = @json($barLabels ?? []);
        window.__BAR_VALUES__ = @json($barValues ?? []);

        document.addEventListener('DOMContentLoaded', function() {

            // ================= 1. CHARTS LOGIC =================
            const initCharts = () => {
                Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";
                Chart.defaults.color = '#94a3b8';

                // Status Pie Chart
                const pieCtx = document.getElementById('statusPie');
                if (pieCtx) {
                    new Chart(pieCtx, {
                        type: 'doughnut',
                        data: {
                            labels: ['Closed', 'Monitoring', 'Open'],
                            datasets: [{
                                data: [window._pieData.closed, window._pieData.monitoring,
                                    window._pieData.open
                                ],
                                // DIBALIK: Merah, Kuning, Hijau
                                backgroundColor: ['#e11d48', '#f59e0b', '#10b981'],
                                borderWidth: 0,
                                hoverOffset: 8
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            cutout: '75%',
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                    labels: {
                                        usePointStyle: true,
                                        boxWidth: 10,
                                        padding: 20,
                                        font: {
                                            weight: '700'
                                        }
                                    }
                                }
                            }
                        }
                    });
                }

                // Trend Line Chart
                const lineCtx = document.getElementById('trendLine');
                if (lineCtx) {
                    const ctx = lineCtx.getContext('2d');
                    const gradient = ctx.createLinearGradient(0, 0, 0, 300);
                    gradient.addColorStop(0, 'rgba(14, 165, 233, 0.3)');
                    gradient.addColorStop(1, 'rgba(14, 165, 233, 0.0)');

                    new Chart(lineCtx, {
                        type: 'line',
                        data: {
                            labels: window.__BAR_LABELS__,
                            datasets: [{
                                label: 'Jumlah NCR',
                                data: window.__BAR_VALUES__,
                                borderColor: '#0ea5e9',
                                backgroundColor: gradient,
                                borderWidth: 3,
                                pointBackgroundColor: '#ffffff',
                                pointBorderColor: '#0ea5e9',
                                pointBorderWidth: 2,
                                pointRadius: 5,
                                pointHoverRadius: 7,
                                fill: true,
                                tension: 0.4
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    grid: {
                                        borderDash: [5, 5],
                                        color: '#f1f5f9'
                                    },
                                    ticks: {
                                        stepSize: 1,
                                        font: {
                                            weight: '600'
                                        }
                                    }
                                },
                                x: {
                                    grid: {
                                        display: false
                                    },
                                    ticks: {
                                        font: {
                                            weight: '600'
                                        }
                                    }
                                }
                            },
                            interaction: {
                                intersect: false,
                                mode: 'index'
                            }
                        }
                    });
                }
            };

            initCharts();

            // ================= 2. TABLE & FILTER LOGIC =================
            const tbody = document.getElementById('tableBody');
            const rows = Array.from(tbody.querySelectorAll('tr[data-item]'));

            let filteredRows = [...rows];
            let currentPage = 1;
            let perPage = 10;
            let currentStatusFilter = "";

            const applyFilters = () => {
                const search = document.getElementById('searchInput').value.toLowerCase();
                const month = document.getElementById('monthFilter').value;
                const year = document.getElementById('yearFilter').value;

                filteredRows = rows.filter(row => {
                    const data = JSON.parse(row.dataset.item);
                    const text = `${data.no_ncr} ${data.audit_scope} ${data.issue}`.toLowerCase();
                    const statusCell = data.status.toLowerCase();

                    const matchSearch = search === '' || text.includes(search);
                    const matchMonth = month === '' || data.issue_month === month;
                    const matchYear = year === '' || data.issue_year === year;
                    const matchStatus = currentStatusFilter === '' || statusCell ===
                        currentStatusFilter;

                    return matchSearch && matchMonth && matchYear && matchStatus;
                });
                currentPage = 1;
                renderTable();
            };

            const renderTable = () => {
                rows.forEach(r => r.style.display = 'none');
                const start = (currentPage - 1) * perPage;
                const paginatedRows = filteredRows.slice(start, start + perPage);
                paginatedRows.forEach(r => r.style.display = '');

                const infoEl = document.getElementById('paginationInfo');
                infoEl.innerHTML = filteredRows.length === 0 ?
                    '<span class="text-rose-500">Data tidak ditemukan.</span>' :
                    `Menampilkan <span class="text-slate-800">${start + 1}-${Math.min(start + perPage, filteredRows.length)}</span> dari <span class="text-slate-800">${filteredRows.length}</span> data`;
                renderPagination();
            };

            const renderPagination = () => {
                const controls = document.getElementById('paginationControls');
                controls.innerHTML = '';
                const totalPages = Math.ceil(filteredRows.length / perPage);
                if (totalPages <= 1) return;

                const createBtn = (html, disabled, onClick) => {
                    const btn = document.createElement('button');
                    btn.innerHTML = html;
                    btn.className = 'page-btn';
                    btn.disabled = disabled;
                    btn.onclick = onClick;
                    return btn;
                };

                controls.appendChild(createBtn(
                    '<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" /></svg>',
                    currentPage === 1, () => {
                        currentPage--;
                        renderTable();
                    }));
                for (let i = 1; i <= totalPages; i++) {
                    const btn = createBtn(i, false, () => {
                        currentPage = i;
                        renderTable();
                    });
                    if (i === currentPage) btn.classList.add('active');
                    controls.appendChild(btn);
                }
                controls.appendChild(createBtn(
                    '<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" /></svg>',
                    currentPage === totalPages, () => {
                        currentPage++;
                        renderTable();
                    }));
            };

            // Event Listeners Filter
            document.getElementById('searchInput').addEventListener('input', applyFilters);
            document.getElementById('monthFilter').addEventListener('change', applyFilters);
            document.getElementById('yearFilter').addEventListener('change', applyFilters);
            document.getElementById('refreshBtn').addEventListener('click', () => window.location.reload());

            const tabs = document.querySelectorAll('.segment-btn');
            tabs.forEach(btn => {
                btn.addEventListener('click', (e) => {
                    tabs.forEach(t => t.classList.remove('active'));
                    e.currentTarget.classList.add('active');
                    currentStatusFilter = e.currentTarget.dataset.status;
                    applyFilters();
                });
            });

            renderTable();

            // ================= 3. MODAL LOGIC =================
            const modal = document.getElementById('detailModal');

            const iconInternal =
                `<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>`;
            const iconExternal =
                `<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" /></svg>`;
            const iconSupplier =
                `<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>`;

            const openModal = (data) => {
                document.getElementById('modalTitle').textContent = data.no_ncr;

                // DIBALIK: Open = Hijau, Closed = Merah
                let bClass = data.status.toLowerCase() === 'closed' ? 'badge-closed' : (data.status
                    .toLowerCase() === 'monitoring' ? 'badge-monitoring' : 'badge-open');

                let scopeIcon = '';
                if (data.audit_scope.toLowerCase() === 'internal') scopeIcon = iconInternal;
                else if (data.audit_scope.toLowerCase() === 'external') scopeIcon = iconExternal;
                else scopeIcon = iconSupplier;

                document.getElementById('modalBody').innerHTML = `
                    <div class="detail-item">
                        <div class="detail-label flex items-center gap-2">
                            <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            Issue Date
                        </div>
                        <div class="detail-value font-mono text-sm bg-white px-3 py-1.5 rounded-lg border border-slate-200 w-max shadow-sm">${data.issue_date}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label flex items-center gap-2">
                            <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                            Audit Scope
                        </div>
                        <div class="detail-value uppercase tracking-wider flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-white shadow-sm border border-slate-100 flex items-center justify-center text-indigo-500">
                                ${scopeIcon}
                            </div>
                            ${data.audit_scope}
                        </div>
                    </div>
                    <div class="detail-item sm:col-span-2">
                        <div class="detail-label flex items-center gap-2">
                            <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                            Deskripsi Temuan / Issue
                        </div>
                        <div class="detail-value text-slate-800 text-base bg-white p-4 rounded-xl border border-slate-200 shadow-sm">${data.issue}</div>
                    </div>
                    <div class="detail-item sm:col-span-2">
                        <div class="detail-label flex items-center gap-2">
                            <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            Status Log Terkini
                        </div>
                        <div class="mt-2"><span class="badge-glow ${bClass} shadow-sm px-4 py-2 text-sm"><span class="badge-dot"></span>${data.status}</span></div>
                    </div>
                `;
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                document.body.style.overflow = 'hidden';
            };

            const closeModal = () => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.style.overflow = '';
            };

            tbody.addEventListener('click', (e) => {
                const btn = e.target.closest('.btn-view');
                if (btn) openModal(JSON.parse(btn.closest('tr').dataset.item));
            });
            document.getElementById('modalClose').addEventListener('click', closeModal);
            document.getElementById('modalClose2').addEventListener('click', closeModal);
            document.getElementById('modalBackdrop').addEventListener('click', closeModal);
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') closeModal();
            });
        });
    </script>
@endpush

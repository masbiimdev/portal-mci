@extends('layouts.home')

@section('title', 'MCI | Portal Kalibrasi')

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
            pointer-events: none;
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

        .modern-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            min-width: 1000px;
        }

        .modern-table th {
            letter-spacing: 0.05em;
            color: #64748b;
            font-weight: 700;
            background-color: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
            padding: 1rem 1.5rem;
            text-transform: uppercase;
            font-size: 0.75rem;
            text-align: left;
            white-space: nowrap;
        }

        .modern-table td {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
            font-size: 0.875rem;
        }

        #toolsTbody tr:last-child td {
            border-bottom: none;
        }

        #toolsTbody tr {
            transition: background-color 0.2s;
        }

        #toolsTbody tr:hover {
            background-color: #f8fafc;
        }

        /* Modern Status Badges */
        .badge-status {
            padding: 0.4rem 0.8rem;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            letter-spacing: 0.02em;
            white-space: nowrap;
        }

        .badge-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
        }

        .badge-ok {
            background: #ecfdf5;
            color: #047857;
            border: 1px solid #d1fae5;
        }

        .badge-ok .badge-dot {
            background-color: #10b981;
        }

        .badge-proses {
            background: #fffbeb;
            color: #b45309;
            border: 1px solid #fef3c7;
        }

        .badge-proses .badge-dot {
            background-color: #f59e0b;
            animation: pulse 2s infinite;
        }

        .badge-due {
            background: #fef2f2;
            color: #b91c1c;
            border: 1px solid #fee2e2;
        }

        .badge-due .badge-dot {
            background-color: #ef4444;
            animation: ping 1.5s cubic-bezier(0, 0, 0.2, 1) infinite;
        }

        .badge-unknown {
            background: #f8fafc;
            color: #475569;
            border: 1px solid #e2e8f0;
        }

        .badge-unknown .badge-dot {
            background-color: #94a3b8;
        }

        /* Detail Button */
        .btn-detail {
            background: #f1f5f9;
            color: #334155;
            border: 1px solid transparent;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .btn-detail:hover {
            background: var(--primary);
            color: white;
            box-shadow: 0 4px 12px rgba(14, 165, 233, 0.25);
            transform: translateY(-1px);
        }

        /* ============== INPUTS & BUTTONS ============== */
        .input-bento {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            transition: var(--transition-bento);
            outline: none;
            padding: 0.6rem 1rem;
            border-radius: 12px;
            font-size: 0.875rem;
            font-weight: 500;
            color: #0f172a;
        }

        .input-bento:focus {
            background: #ffffff;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px #e0f2fe;
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

        .btn-action-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            padding: 0.6rem;
            border-radius: 12px;
            color: #64748b;
            cursor: pointer;
            transition: all 0.2s;
            height: 40px;
            width: 40px;
        }

        .btn-action-icon:hover {
            background: #f8fafc;
            color: var(--primary);
            border-color: #bae6fd;
        }

        /* ============== PAGINATION ============== */
        .pagination {
            display: flex;
            gap: 0.35rem;
        }

        .pagination button {
            min-width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            background: #ffffff;
            color: #64748b;
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .pagination button:hover:not(:disabled) {
            background: #f8fafc;
            color: #0f172a;
            border-color: #cbd5e1;
        }

        .pagination button.active {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .pagination button:disabled {
            opacity: 0.4;
            cursor: not-allowed;
            background: #f8fafc;
        }

        /* ============== MODAL ============== */
        .modal-backdrop {
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(8px);
        }

        .modal-card {
            max-height: 90vh;
            overflow-y: auto;
            border-radius: 28px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.3);
            animation: modalPop 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        @keyframes modalPop {
            from {
                opacity: 0;
                transform: scale(0.95) translateY(20px);
            }

            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        .detail-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.25rem;
        }

        @media(min-width: 640px) {
            .detail-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .detail-item {
            background: #f8fafc;
            padding: 1.25rem;
            border-radius: 20px;
            border: 1px solid #e2e8f0;
            transition: border-color 0.2s;
        }

        .detail-item:hover {
            border-color: #cbd5e1;
        }

        .detail-label {
            font-size: 0.7rem;
            color: #64748b;
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 0.05em;
            margin-bottom: 0.4rem;
        }

        .detail-value {
            font-size: 1rem;
            font-weight: 700;
            color: #0f172a;
        }

        .font-mono {
            font-family: 'JetBrains Mono', monospace;
        }
    </style>
@endpush

@section('content')
    <div class="max-w-[1400px] mx-auto py-10 px-4 sm:px-6 lg:px-8">

        {{-- HEADER SECTION --}}
        <header class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-5">
            <div>
                <nav class="flex items-center mb-3 text-xs font-bold text-slate-400 uppercase tracking-widest">
                    <span class="hover:text-slate-600 cursor-pointer transition-colors">Kalibrasi</span>
                    <span class="mx-2 text-slate-300">/</span>
                    <span class="text-sky-500">Dashboard</span>
                </nav>
                <div class="flex items-center gap-3 mb-2">
                    <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-800 tracking-tight leading-tight">
                        Portal <span
                            class="text-transparent bg-clip-text bg-gradient-to-r from-sky-500 to-blue-600">Kalibrasi</span>
                    </h1>
                </div>
                <p class="text-slate-500 text-sm font-medium mt-2">Monitoring status dan jadwal kalibrasi instrumen secara
                    real-time.</p>
            </div>

            <div
                class="bg-white border border-slate-200 text-slate-600 px-5 py-3.5 rounded-[20px] text-xs font-medium flex gap-3 items-center shadow-sm max-w-md">
                <div class="p-2 bg-sky-50 rounded-xl text-sky-500 flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>Sistem memantau <span
                        class="font-extrabold text-slate-800">{{ number_format($totalTools ?? 0) }}</span> instrumen.
                    Prioritaskan status Due/Jatuh Tempo.</div>
            </div>
        </header>

        {{-- ROW 1: SUMMARY CARDS BENTO --}}
        <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 sm:gap-6 mb-6">
            @php
                $statusOk = $statusOk ?? 0;
                $statusProses = $statusProses ?? 0;
                $dueSoon = $dueSoon ?? 0;
                $totalTools = $totalTools ?? 0;
            @endphp

            <div class="bento-card bento-stat bg-sky">
                <div class="flex justify-between items-start mb-4 relative z-10">
                    <div>
                        <div class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Total Instrumen</div>
                        <div class="text-3xl font-black text-slate-800 font-mono tracking-tight">
                            {{ number_format($totalTools) }}</div>
                    </div>
                    <div class="stat-icon-wrap stat-sky">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                    </div>
                </div>
                <div class="text-xs font-semibold text-slate-500 relative z-10">Item terdaftar dalam sistem</div>
            </div>

            <div class="bento-card bento-stat bg-emerald">
                <div class="flex justify-between items-start mb-4 relative z-10">
                    <div>
                        <div class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Status OK</div>
                        <div class="text-3xl font-black text-slate-800 font-mono tracking-tight">
                            {{ number_format($statusOk) }}</div>
                    </div>
                    <div class="stat-icon-wrap stat-emerald">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div
                    class="text-[11px] font-bold text-emerald-700 bg-emerald-100/80 inline-block px-2.5 py-1 rounded-lg w-max relative z-10">
                    Siap Digunakan</div>
            </div>

            <div class="bento-card bento-stat bg-amber">
                <div class="flex justify-between items-start mb-4 relative z-10">
                    <div>
                        <div class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Proses Kalibrasi</div>
                        <div class="text-3xl font-black text-slate-800 font-mono tracking-tight">
                            {{ number_format($statusProses) }}</div>
                    </div>
                    <div class="stat-icon-wrap stat-amber">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                </div>
                <div
                    class="text-[11px] font-bold text-amber-700 bg-amber-100/80 inline-block px-2.5 py-1 rounded-lg w-max relative z-10">
                    Sedang dikerjakan</div>
            </div>

            <div class="bento-card bento-stat bg-rose border-b-4 border-rose-400">
                <div class="flex justify-between items-start mb-4 relative z-10">
                    <div>
                        <div class="text-xs font-bold text-rose-500/80 uppercase tracking-widest mb-1">Due < 15 Hari</div>
                                <div class="text-3xl font-black text-slate-800 font-mono tracking-tight">
                                    {{ number_format($dueSoon) }}</div>
                        </div>
                        <div class="stat-icon-wrap stat-rose">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div
                        class="text-[11px] font-bold text-rose-700 bg-rose-100/80 inline-block px-2.5 py-1 rounded-lg w-max relative z-10">
                        Segera Kalibrasi Ulang</div>
                </div>
        </section>

        {{-- ROW 2: CHARTS BENTO --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 sm:gap-6 mb-6">
            <div class="bento-card p-6 sm:p-8 flex flex-col">
                <h2 class="text-sm font-bold text-slate-800 uppercase tracking-widest mb-4">Distribusi Status</h2>
                <div class="flex-grow relative min-h-[220px] flex items-center justify-center">
                    <canvas id="statusPie"></canvas>
                </div>
            </div>

            <div class="lg:col-span-2 bento-card p-6 sm:p-8 flex flex-col">
                <h2 class="text-sm font-bold text-slate-800 uppercase tracking-widest mb-4">Tren Penjadwalan Kalibrasi</h2>
                <div class="flex-grow relative min-h-[220px]">
                    <canvas id="trendLine"></canvas>
                </div>
            </div>
        </div>

        {{-- ROW 3: TABLE BENTO --}}
        <section class="bento-card flex flex-col p-0">
            <div class="p-6 sm:p-8 border-b border-slate-100 bg-white">
                <div class="flex flex-wrap gap-4 justify-between items-center">
                    <div class="flex flex-wrap items-center gap-3 w-full lg:w-auto">
                        <div class="relative w-full sm:w-80">
                            <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <input id="searchInput" type="search" placeholder="Cari alat, no. seri, merk..."
                                class="input-bento w-full pl-11" />
                        </div>
                        <div class="relative w-full sm:w-auto">
                            <select id="statusFilter" class="input-bento pr-10 appearance-none w-full">
                                <option value="">Semua Status</option>
                                <option value="DUE SOON">Due Soon (Jatuh Tempo)</option>
                                <option value="PROSES">Proses Kalibrasi</option>
                                <option value="OK">Status OK</option>
                            </select>
                            <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 pointer-events-none"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 w-full sm:w-auto justify-end">
                        <div class="flex items-center gap-2">
                            <span
                                class="text-xs font-semibold text-slate-500 uppercase tracking-wider hidden sm:block">Show</span>
                            <select id="perPage" class="input-bento py-1.5 px-3">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                            </select>
                        </div>
                        <button id="refreshBtn" class="btn-action-icon btn-bento" title="Refresh Data">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div class="table-responsive-wrapper bg-white flex-1">
                <table id="toolsTable" class="modern-table">
                    <thead>
                        <tr>
                            <th width="5%" class="text-center">No</th>
                            <th width="25%">Instrumen</th>
                            <th width="20%">No. Seri & Merk</th>
                            <th width="15%">Status</th>
                            <th width="12%">Tgl Kalibrasi</th>
                            <th width="13%">Tgl Ulang (Due)</th>
                            <th width="10%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="toolsTbody">
                        {{-- LOGIKA PENGURUTAN PHP AGAR DUE SOON DI ATAS --}}
                        @php
                            $sortedTools = $tools
                                ->map(function ($t) {
                                    $history = optional($t->latestHistory);
                                    $statusRaw = $history->status_kalibrasi ?? '-';

                                    $sortOrder = 99;
                                    if (stripos($statusRaw, 'Jatuh Tempo') !== false) {
                                        $sortOrder = 1;
                                    } elseif (strcasecmp($statusRaw, 'Proses') === 0) {
                                        $sortOrder = 2;
                                    } elseif (strcasecmp($statusRaw, 'OK') === 0) {
                                        $sortOrder = 3;
                                    }

                                    return [
                                        'tool' => $t,
                                        'history' => $history,
                                        'status' => $statusRaw,
                                        'sort_order' => $sortOrder,
                                    ];
                                })
                                ->sortBy('sort_order')
                                ->values();
                        @endphp

                        @forelse($sortedTools as $index => $item)
                            @php
                                $t = $item['tool'];
                                $history = $item['history'];
                                $status = $item['status'];

                                $jsonData = json_encode([
                                    'id' => $t->id,
                                    'nama' => $t->nama_alat ?? '',
                                    'merek' => $t->merek ?? '',
                                    'no_seri' => $t->no_seri ?? '',
                                    'status' => $status,
                                    'tgl_kalibrasi' => $history->tgl_kalibrasi
                                        ? $history->tgl_kalibrasi->format('d M Y')
                                        : null,
                                    'tgl_kalibrasi_ulang' => $history->tgl_kalibrasi_ulang
                                        ? $history->tgl_kalibrasi_ulang->format('d M Y')
                                        : null,
                                    'keterangan' => $history->keterangan ?? '-',
                                ]);

                                if (strcasecmp($status, 'OK') === 0) {
                                    $statusClass = 'badge-ok';
                                    $label = 'OK';
                                } elseif (strcasecmp($status, 'Proses') === 0) {
                                    $statusClass = 'badge-proses';
                                    $label = 'Proses';
                                } elseif (stripos($status, 'Jatuh Tempo') !== false) {
                                    $statusClass = 'badge-due';
                                    $label = 'Due Soon';
                                } else {
                                    $statusClass = 'badge-unknown';
                                    $label = 'Pending';
                                }
                            @endphp

                            <tr data-tool="{{ $jsonData }}">
                                <td class="text-slate-400 font-bold text-center">{{ $index + 1 }}</td>
                                <td>
                                    <div class="font-bold text-slate-800">{{ e($t->nama_alat) }}</div>
                                </td>
                                <td>
                                    <div class="font-mono text-sm font-bold text-slate-700">{{ e($t->no_seri ?? '-') }}
                                    </div>
                                    <div class="text-[11px] font-bold uppercase tracking-wider text-slate-400 mt-1">
                                        {{ e($t->merek ?? 'Tanpa Merk') }}</div>
                                </td>
                                <td>
                                    <span class="badge-status {{ $statusClass }}">
                                        <span class="badge-dot"></span>
                                        {{ $label }}
                                    </span>
                                </td>
                                <td class="font-mono text-sm font-medium text-slate-600">
                                    {{ $history->tgl_kalibrasi ? $history->tgl_kalibrasi->format('d/m/Y') : '-' }}
                                </td>
                                <td
                                    class="font-mono text-sm font-bold {{ stripos($status, 'Jatuh Tempo') !== false ? 'text-red-600' : 'text-slate-800' }}">
                                    {{ $history->tgl_kalibrasi_ulang ? $history->tgl_kalibrasi_ulang->format('d/m/Y') : '-' }}
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn-detail">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        Detail
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-16 text-center">
                                    <div
                                        class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-slate-100">
                                        <svg class="w-8 h-8 text-slate-300" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-bold text-slate-800">Data Tidak Ditemukan</h3>
                                    <p class="text-slate-500 text-sm mt-1 font-medium">Belum ada instrumen yang didaftarkan
                                        untuk kalibrasi.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div
                class="p-6 border-t border-slate-100 bg-white flex flex-col sm:flex-row items-center justify-between gap-4">
                <div id="paginationInfo" class="text-sm font-semibold text-slate-500">Memuat data...</div>
                <div id="paginationControls" class="pagination"></div>
            </div>
        </section>
    </div>

    {{-- MODAL DETAIL BENTO STYLE --}}
    <div id="detailModal" class="fixed inset-0 hidden items-center justify-center z-[100]" role="dialog"
        aria-modal="true">
        <div class="absolute inset-0 modal-backdrop" id="modalBackdrop"></div>
        <div class="relative modal-card bg-white w-full max-w-2xl m-4 z-10 flex flex-col">

            <div
                class="px-8 py-6 border-b border-slate-100 flex justify-between items-center sticky top-0 bg-white/95 backdrop-blur z-20">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-[18px] bg-sky-50 flex items-center justify-center border border-sky-100">
                        <svg class="w-6 h-6 text-sky-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 id="modalTitle" class="text-xl font-extrabold text-slate-800 tracking-tight">Detail Instrumen
                        </h3>
                        <p class="text-xs font-semibold text-slate-500 mt-1 uppercase tracking-wider">Informasi lengkap
                            kalibrasi</p>
                    </div>
                </div>
                <button id="modalClose"
                    class="p-2 bg-slate-50 hover:bg-rose-50 rounded-xl border border-transparent hover:border-rose-100 transition-colors text-slate-400 hover:text-rose-500">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="p-8">
                <div id="modalBody" class="detail-grid">
                </div>
            </div>

            <div
                class="px-8 py-5 bg-slate-50 border-t border-slate-100 flex justify-end rounded-b-[28px] sticky bottom-0 z-20">
                <button id="modalClose2"
                    class="px-6 py-2.5 bg-white border border-slate-200 text-slate-700 hover:bg-slate-100 font-bold rounded-xl transition-all shadow-sm">Tutup
                    Panel</button>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Global Data
        window._pieData = @json($pieData ?? ['ok' => 0, 'proses' => 0, 'due' => 0]);
        window.__BAR_LABELS__ = @json($barLabels ?? []);
        window.__BAR_VALUES__ = @json($barValues ?? []);

        document.addEventListener('DOMContentLoaded', function() {
            // ================= CHARTS =================
            const initCharts = () => {
                Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";
                Chart.defaults.color = '#94a3b8';

                // Pie Chart
                const pieCtx = document.getElementById('statusPie');
                if (pieCtx) {
                    new Chart(pieCtx, {
                        type: 'doughnut',
                        data: {
                            labels: ['OK', 'Proses', 'Due / Jatuh Tempo'],
                            datasets: [{
                                data: [window._pieData.ok, window._pieData.proses, window
                                    ._pieData.due
                                ],
                                backgroundColor: ['#10b981', '#f59e0b', '#ef4444'],
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
                                            weight: '700',
                                            size: 12
                                        }
                                    }
                                },
                                tooltip: {
                                    backgroundColor: 'rgba(15, 23, 42, 0.9)',
                                    titleFont: {
                                        size: 13,
                                        weight: '800'
                                    },
                                    bodyFont: {
                                        size: 13,
                                        weight: '600'
                                    },
                                    padding: 12,
                                    cornerRadius: 12,
                                    usePointStyle: true
                                }
                            }
                        }
                    });
                }

                // Line Chart
                const lineCtx = document.getElementById('trendLine');
                if (lineCtx) {
                    const ctx = lineCtx.getContext('2d');
                    const gradient = ctx.createLinearGradient(0, 0, 0, 300);
                    gradient.addColorStop(0, 'rgba(14, 165, 233, 0.4)');
                    gradient.addColorStop(1, 'rgba(14, 165, 233, 0.0)');

                    new Chart(lineCtx, {
                        type: 'line',
                        data: {
                            labels: window.__BAR_LABELS__,
                            datasets: [{
                                label: 'Jadwal Kalibrasi',
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
                                },
                                tooltip: {
                                    backgroundColor: 'rgba(15, 23, 42, 0.9)',
                                    titleFont: {
                                        size: 13,
                                        weight: '800'
                                    },
                                    bodyFont: {
                                        size: 13,
                                        weight: '600'
                                    },
                                    padding: 12,
                                    cornerRadius: 12,
                                    displayColors: false
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    grid: {
                                        borderDash: [5, 5],
                                        color: '#f1f5f9',
                                        drawBorder: false
                                    },
                                    ticks: {
                                        stepSize: 1,
                                        font: {
                                            weight: '600'
                                        },
                                        padding: 10
                                    }
                                },
                                x: {
                                    grid: {
                                        display: false,
                                        drawBorder: false
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

            // ================= TABLE LOGIC =================
            const tbody = document.getElementById('toolsTbody');
            const rows = Array.from(tbody.querySelectorAll('tr[data-tool]'));

            let filteredRows = [...rows];
            let currentPage = 1;
            let perPage = 10;

            const applyFilters = () => {
                const search = document.getElementById('searchInput').value.toLowerCase();
                const status = document.getElementById('statusFilter').value.toLowerCase();

                filteredRows = rows.filter(row => {
                    const data = JSON.parse(row.dataset.tool);
                    const text = `${data.nama} ${data.no_seri} ${data.merek}`.toLowerCase();
                    const statusCell = data.status.toLowerCase();

                    const matchSearch = search === '' || text.includes(search);
                    const matchStatus = status === '' || statusCell.includes(status);

                    return matchSearch && matchStatus;
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
                if (filteredRows.length === 0) {
                    infoEl.innerHTML = '<span class="text-rose-500 font-bold">Tidak ada data ditemukan.</span>';
                } else {
                    infoEl.innerHTML =
                        `Menampilkan <strong class="text-slate-800">${start + 1}-${Math.min(start + perPage, filteredRows.length)}</strong> dari <strong class="text-slate-800">${filteredRows.length}</strong> data`;
                }

                renderPagination();
            };

            const renderPagination = () => {
                const controls = document.getElementById('paginationControls');
                controls.innerHTML = '';
                const totalPages = Math.ceil(filteredRows.length / perPage);

                if (totalPages <= 1) return;

                const btnPrev = document.createElement('button');
                btnPrev.innerHTML =
                    '<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" /></svg>';
                btnPrev.disabled = currentPage === 1;
                btnPrev.onclick = () => {
                    currentPage--;
                    renderTable();
                };
                controls.appendChild(btnPrev);

                for (let i = 1; i <= totalPages; i++) {
                    const btnPage = document.createElement('button');
                    btnPage.textContent = i;
                    if (i === currentPage) btnPage.classList.add('active');
                    btnPage.onclick = () => {
                        currentPage = i;
                        renderTable();
                    };
                    controls.appendChild(btnPage);
                }

                const btnNext = document.createElement('button');
                btnNext.innerHTML =
                    '<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" /></svg>';
                btnNext.disabled = currentPage === totalPages;
                btnNext.onclick = () => {
                    currentPage++;
                    renderTable();
                };
                controls.appendChild(btnNext);
            };

            document.getElementById('searchInput').addEventListener('input', applyFilters);
            document.getElementById('statusFilter').addEventListener('change', applyFilters);
            document.getElementById('perPage').addEventListener('change', (e) => {
                perPage = parseInt(e.target.value);
                applyFilters();
            });

            document.getElementById('refreshBtn').addEventListener('click', () => {
                const btn = document.getElementById('refreshBtn');
                btn.innerHTML =
                    '<svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>';
                window.location.reload();
            });

            renderTable();

            // ================= MODAL LOGIC =================
            const modal = document.getElementById('detailModal');

            const openModal = (data) => {
                document.getElementById('modalTitle').textContent = data.nama;

                let badgeClass = 'bg-slate-100 text-slate-600';
                let label = 'Pending';

                if (data.status === 'OK') {
                    badgeClass = 'bg-emerald-100 text-emerald-700 border border-emerald-200';
                    label = 'OK';
                } else if (data.status === 'Proses') {
                    badgeClass = 'bg-amber-100 text-amber-700 border border-amber-200';
                    label = 'Proses';
                } else if (data.status.includes('Jatuh Tempo')) {
                    badgeClass = 'bg-rose-100 text-rose-700 border border-rose-200';
                    label = 'Jatuh Tempo';
                }

                const isDue = data.status.includes('Jatuh Tempo');

                document.getElementById('modalBody').innerHTML = `
                    <div class="detail-item">
                        <div class="detail-label">Nomor Seri</div>
                        <div class="detail-value font-mono">${data.no_seri || '-'}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Merk</div>
                        <div class="detail-value">${data.merek || '-'}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Status Terkini</div>
                        <div class="detail-value mt-1">
                            <span class="inline-block px-3 py-1 rounded-lg text-xs font-extrabold uppercase tracking-wider ${badgeClass}">${label}</span>
                        </div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Tgl Kalibrasi Terakhir</div>
                        <div class="detail-value font-mono text-slate-600">${data.tgl_kalibrasi || '-'}</div>
                    </div>
                    <div class="detail-item sm:col-span-2 ${isDue ? 'bg-rose-50 border-rose-200 shadow-inner' : 'bg-sky-50 border-sky-200'}">
                        <div class="detail-label ${isDue ? 'text-rose-600' : 'text-sky-600'}">Jadwal Kalibrasi Ulang (DUE DATE)</div>
                        <div class="detail-value ${isDue ? 'text-rose-700' : 'text-sky-900'} text-xl font-mono">${data.tgl_kalibrasi_ulang || '-'}</div>
                    </div>
                    <div class="detail-item sm:col-span-2">
                        <div class="detail-label">Keterangan / Catatan Riwayat</div>
                        <div class="detail-value font-medium text-slate-600 text-sm leading-relaxed">${data.keterangan || 'Tidak ada catatan.'}</div>
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
                const btn = e.target.closest('.btn-detail');
                if (btn) {
                    const tr = btn.closest('tr');
                    const data = JSON.parse(tr.dataset.tool);
                    openModal(data);
                }
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

@extends('layouts.home')

@section('title', 'MCI | Portal Kalibrasi')

@push('css')
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --primary: #0ea5e9;
            --primary-dark: #0284c7;
            --primary-light: #e0f2fe;
            --surface: #ffffff;
            --bg-color: #f8fafc;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-main);
            -webkit-font-smoothing: antialiased;
        }

        /* ============== BACKGROUND EFFECTS ============== */
        .dashboard-bg {
            background:
                radial-gradient(circle at 15% 50%, rgba(14, 165, 233, 0.04) 0%, transparent 25%),
                radial-gradient(circle at 85% 30%, rgba(244, 63, 94, 0.03) 0%, transparent 25%);
            background-attachment: fixed;
        }

        /* ============== SUMMARY CARDS ============== */
        .summary-card {
            background: var(--surface);
            border-radius: 20px;
            padding: 1.75rem;
            border: 1px solid rgba(226, 232, 240, 0.8);
            box-shadow: var(--shadow-sm);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 140px;
        }

        .summary-card::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.4) 100%);
            pointer-events: none;
        }

        .summary-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-md);
            border-color: transparent;
        }

        /* Top Accent Lines */
        .summary-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
        }

        .card-total::before {
            background: var(--primary);
        }

        .card-ok::before {
            background: #10b981;
        }

        .card-proses::before {
            background: #f59e0b;
        }

        .card-due::before {
            background: #ef4444;
        }

        /* Custom Hover Glows */
        .card-total:hover {
            box-shadow: 0 10px 25px -5px rgba(14, 165, 233, 0.15);
        }

        .card-ok:hover {
            box-shadow: 0 10px 25px -5px rgba(16, 185, 129, 0.15);
        }

        .card-proses:hover {
            box-shadow: 0 10px 25px -5px rgba(245, 158, 11, 0.15);
        }

        .card-due:hover {
            box-shadow: 0 10px 25px -5px rgba(239, 68, 68, 0.15);
        }

        .summary-title {
            font-size: 0.8rem;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .summary-value {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--text-main);
            line-height: 1.1;
            margin-top: 0.5rem;
            letter-spacing: -0.02em;
        }

        .summary-desc {
            font-size: 0.8rem;
            font-weight: 500;
            color: var(--text-muted);
            margin-top: auto;
            padding-top: 1rem;
        }

        /* ============== CONTROLS ============== */
        .controls-wrapper {
            background: var(--surface);
            padding: 1.25rem;
            border-radius: 20px 20px 0 0;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            justify-content: space-between;
            align-items: center;
        }

        .input-styled {
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 0.6rem 1rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--text-main);
            background: var(--bg-color);
            transition: all 0.2s;
            outline: none;
            width: 100%;
        }

        @media (min-width: 640px) {
            .input-styled {
                width: auto;
            }
        }

        .input-styled:focus {
            background: var(--surface);
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.15);
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            background: var(--surface);
            border: 1px solid var(--border-color);
            padding: 0.6rem;
            border-radius: 10px;
            color: var(--text-muted);
            cursor: pointer;
            transition: all 0.2s;
            height: 40px;
            width: 40px;
        }

        .btn-action:hover {
            background: var(--bg-color);
            color: var(--primary);
            border-color: var(--primary-light);
        }

        /* ============== TABLE STYLES ============== */
        .table-container {
            background: var(--surface);
            border-radius: 20px;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-md);
            margin-bottom: 2rem;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        table.modern-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            min-width: 1000px;
        }

        table.modern-table th {
            background: #f8fafc;
            color: #475569;
            font-weight: 700;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 1rem 1.5rem;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
            white-space: nowrap;
        }

        table.modern-table td {
            padding: 1rem 1.5rem;
            font-size: 0.875rem;
            color: var(--text-main);
            border-bottom: 1px solid var(--bg-color);
            vertical-align: middle;
        }

        table.modern-table tbody tr {
            transition: all 0.2s ease;
        }

        table.modern-table tbody tr:hover {
            background-color: #f1f5f9;
            /* Slate 100 */
        }

        /* Zebra striping tipis */
        table.modern-table tbody tr:nth-child(even) {
            background-color: #fcfcfd;
        }

        table.modern-table tbody tr:nth-child(even):hover {
            background-color: #f1f5f9;
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

        /* Button Detail Modern */
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

        /* ============== PAGINATION ============== */
        .pagination-wrapper {
            padding: 1rem 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
            justify-content: space-between;
            align-items: center;
            background: var(--surface);
            border-radius: 0 0 20px 20px;
        }

        @media (min-width: 640px) {
            .pagination-wrapper {
                flex-direction: row;
            }
        }

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
            border-radius: 8px;
            border: 1px solid var(--border-color);
            background: var(--surface);
            color: var(--text-muted);
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .pagination button:hover:not(:disabled) {
            background: var(--bg-color);
            color: var(--text-main);
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
            background: var(--bg-color);
        }

        /* ============== MODAL ============== */
        .modal-backdrop {
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(8px);
        }

        .modal-card {
            max-height: 90vh;
            overflow-y: auto;
            border-radius: 24px;
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
            background: var(--bg-color);
            padding: 1.25rem;
            border-radius: 16px;
            border: 1px solid var(--border-color);
            transition: border-color 0.2s;
        }

        .detail-item:hover {
            border-color: #cbd5e1;
        }

        .detail-label {
            font-size: 0.7rem;
            color: var(--text-muted);
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 0.05em;
            margin-bottom: 0.4rem;
        }

        .detail-value {
            font-size: 1rem;
            font-weight: 700;
            color: var(--text-main);
        }
    </style>
@endpush

@section('content')
    <div class="dashboard-bg min-h-screen py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- HEADER SECTION --}}
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-10 h-10 rounded-xl bg-sky-100 flex items-center justify-center text-sky-600">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                            </svg>
                        </div>
                        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Portal Kalibrasi</h1>
                    </div>
                    <p class="text-slate-500 text-sm font-medium">Monitoring status dan jadwal kalibrasi instrumen secara
                        real-time.</p>
                </div>

                <div
                    class="bg-white border border-slate-200 text-slate-600 px-4 py-3 rounded-xl text-xs font-medium flex gap-3 items-start max-w-md shadow-sm">
                    <svg class="w-5 h-5 flex-shrink-0 text-sky-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>Sistem aktif memantau <span
                            class="font-bold text-slate-800">{{ number_format($totalTools ?? 0) }}</span> instrumen.
                        Prioritaskan instrumen dengan status Due / Jatuh Tempo.</div>
                </div>
            </div>

            {{-- SUMMARY CARDS --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
                @php
                    $statusOk = $statusOk ?? 0;
                    $statusProses = $statusProses ?? 0;
                    $dueSoon = $dueSoon ?? 0;
                    $totalTools = $totalTools ?? 0;
                @endphp

                <div class="summary-card card-total">
                    <div class="summary-title">
                        <svg class="w-4 h-4 text-sky-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                        Total Instrumen
                    </div>
                    <div class="summary-value">{{ number_format($totalTools) }}</div>
                    <div class="summary-desc">Item terdaftar dalam sistem</div>
                </div>

                <div class="summary-card card-due">
                    <div class="summary-title">
                        <svg class="w-4 h-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Due &lt; 15 Hari
                    </div>
                    <div class="summary-value text-red-600">{{ number_format($dueSoon) }}</div>
                    <div class="summary-desc">Segera kalibrasi ulang</div>
                </div>

                <div class="summary-card card-proses">
                    <div class="summary-title">
                        <svg class="w-4 h-4 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Proses Kalibrasi
                    </div>
                    <div class="summary-value text-amber-600">{{ number_format($statusProses) }}</div>
                    <div class="summary-desc">Sedang dalam pengerjaan</div>
                </div>

                <div class="summary-card card-ok">
                    <div class="summary-title">
                        <svg class="w-4 h-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Status OK
                    </div>
                    <div class="summary-value text-emerald-600">{{ number_format($statusOk) }}</div>
                    <div class="summary-desc">Instrumen siap digunakan</div>
                </div>
            </div>

            {{-- CHARTS SECTION --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <div class="bg-white border border-slate-200 shadow-sm rounded-[20px] p-6 flex flex-col">
                    <h2 class="text-sm font-bold text-slate-800 uppercase tracking-widest mb-4">Distribusi Status</h2>
                    <div class="flex-grow relative min-h-[200px] flex items-center justify-center">
                        <canvas id="statusPie"></canvas>
                    </div>
                </div>

                <div class="lg:col-span-2 bg-white border border-slate-200 shadow-sm rounded-[20px] p-6 flex flex-col">
                    <h2 class="text-sm font-bold text-slate-800 uppercase tracking-widest mb-4">Tren Penjadwalan Kalibrasi
                    </h2>
                    <div class="flex-grow relative min-h-[200px]">
                        <canvas id="trendLine"></canvas>
                    </div>
                </div>
            </div>

            {{-- TABLE SECTION --}}
            <div class="table-container">
                <div class="controls-wrapper">
                    <div class="flex flex-wrap items-center gap-3 w-full lg:w-auto">
                        <div class="relative w-full sm:w-80">
                            <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <input id="searchInput" type="search" placeholder="Cari alat, nomor seri, atau merk..."
                                class="input-styled pl-10" />
                        </div>
                        <div class="relative w-full sm:w-auto">
                            <select id="statusFilter"
                                class="input-styled pr-10 appearance-none font-semibold text-slate-600">
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

                    <div class="flex items-center gap-3 w-full sm:w-auto mt-3 sm:mt-0 justify-end">
                        <div class="flex items-center gap-2">
                            <span
                                class="text-xs font-semibold text-slate-500 uppercase tracking-wider hidden sm:block">Tampilkan</span>
                            <select id="perPage" class="input-styled py-1.5 px-3">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                            </select>
                        </div>
                        <button id="refreshBtn" class="btn-action" title="Refresh Data">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="table-wrapper">
                    <table id="toolsTable" class="modern-table">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
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

                                        // Tentukan urutan prioritas (Makin kecil = makin atas)
                                        $sortOrder = 99; // Default terbawah (Tidak ada data)
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

                                    // Mapping JSON data untuk modal
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

                                    // Styling Badge
                                    if (strcasecmp($status, 'OK') === 0) {
                                        $statusClass = 'badge-ok';
                                        $label = 'OK';
                                    } elseif (strcasecmp($status, 'Proses') === 0) {
                                        $statusClass = 'badge-proses';
                                        $label = 'Proses';
                                    } elseif (stripos($status, 'Jatuh Tempo') !== false) {
                                        $statusClass = 'badge-due';
                                        $label = 'Due Soon'; // Singkat di tabel agar rapi
                                    } else {
                                        $statusClass = 'badge-unknown';
                                        $label = 'Pending';
                                    }
                                @endphp

                                <tr data-tool="{{ $jsonData }}">
                                    <td class="text-slate-500 font-bold text-center">{{ $index + 1 }}</td>
                                    <td>
                                        <div class="font-bold text-slate-800">{{ e($t->nama_alat) }}</div>
                                    </td>
                                    <td>
                                        <div class="font-mono text-sm font-semibold text-slate-700">
                                            {{ e($t->no_seri ?? '-') }}</div>
                                        <div class="text-[11px] font-bold uppercase tracking-wider text-slate-400 mt-0.5">
                                            {{ e($t->merek ?? 'Tanpa Merk') }}</div>
                                    </td>
                                    <td>
                                        <span class="badge-status {{ $statusClass }}">
                                            <span class="badge-dot"></span>
                                            {{ $label }}
                                        </span>
                                    </td>
                                    <td class="font-mono text-xs font-medium text-slate-600">
                                        {{ $history->tgl_kalibrasi ? $history->tgl_kalibrasi->format('d/m/Y') : '-' }}
                                    </td>
                                    <td
                                        class="font-mono text-sm font-bold {{ stripos($status, 'Jatuh Tempo') !== false ? 'text-red-600' : 'text-slate-800' }}">
                                        {{ $history->tgl_kalibrasi_ulang ? $history->tgl_kalibrasi_ulang->format('d/m/Y') : '-' }}
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn-detail">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
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
                                            class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                            <svg class="w-8 h-8 text-slate-300" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                            </svg>
                                        </div>
                                        <h3 class="text-lg font-bold text-slate-800">Data Tidak Ditemukan</h3>
                                        <p class="text-slate-500 text-sm mt-1">Belum ada instrumen yang didaftarkan untuk
                                            kalibrasi.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="pagination-wrapper">
                    <div id="paginationInfo" class="text-sm font-semibold text-slate-500">Memuat data...</div>
                    <div id="paginationControls" class="pagination"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL DETAIL --}}
    <div id="detailModal" class="fixed inset-0 hidden items-center justify-center z-[100]" role="dialog"
        aria-modal="true">
        <div class="absolute inset-0 modal-backdrop" id="modalBackdrop"></div>
        <div class="relative modal-card bg-white w-full max-w-2xl m-4 z-10 flex flex-col">

            <div
                class="px-8 py-5 border-b border-slate-100 flex justify-between items-center sticky top-0 bg-white/95 backdrop-blur z-20">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center">
                        <svg class="w-5 h-5 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 id="modalTitle" class="text-xl font-extrabold text-slate-800 uppercase tracking-tight">Detail
                            Instrumen</h3>
                        <p class="text-xs font-semibold text-slate-400 mt-0.5">Informasi lengkap kalibrasi</p>
                    </div>
                </div>
                <button id="modalClose"
                    class="p-2 bg-slate-50 hover:bg-rose-50 rounded-full transition-colors text-slate-400 hover:text-rose-500">
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
                class="px-8 py-5 bg-slate-50 border-t border-slate-100 flex justify-end rounded-b-[24px] sticky bottom-0 z-20">
                <button id="modalClose2"
                    class="px-8 py-2.5 bg-slate-800 hover:bg-slate-700 text-white font-bold tracking-wide rounded-xl transition-all shadow-md hover:shadow-lg">Tutup
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
                                            weight: '600'
                                        }
                                    }
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
                    // Karena kita parse JSON dari atribut, pencarian lebih akurat
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
                    infoEl.innerHTML = '<span class="text-rose-500">Tidak ada data ditemukan.</span>';
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

                // Tentukan warna badge status di dalam modal
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
                            <span class="inline-block px-3 py-1 rounded-lg text-xs font-bold uppercase tracking-wider ${badgeClass}">${label}</span>
                        </div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Tanggal Kalibrasi Terakhir</div>
                        <div class="detail-value font-mono text-slate-600">${data.tgl_kalibrasi || '-'}</div>
                    </div>
                    <div class="detail-item sm:col-span-2 ${isDue ? 'bg-rose-50 border-rose-200' : 'bg-sky-50 border-sky-200'}">
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

            // Event listener menggunakan Event Delegation (sangat aman)
            tbody.addEventListener('click', (e) => {
                const btn = e.target.closest('.btn-detail');
                if (btn) {
                    const tr = btn.closest('tr');
                    // Data JSON diambil dari atribut tr
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

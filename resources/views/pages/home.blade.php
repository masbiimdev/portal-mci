@extends('layouts.home')

@section('title', 'Dashboard — Portal MCI')

@push('css')
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        :root {
            /* Color Palette */
            --primary: #2563eb;
            --primary-hover: #1d4ed8;
            --primary-light: #eff6ff;
            --secondary: #475569;
            --success: #059669;
            --success-light: #dcfce7;
            --warning: #d97706;
            --warning-light: #fef3c7;
            --danger: #dc2626;
            --danger-light: #fee2e2;

            /* Surface & Background */
            --bg-color: #f1f5f9;
            --surface: #ffffff;
            --surface-hover: #f8fafc;

            /* Text */
            --text-main: #0f172a;
            --text-muted: #64748b;
            --border-color: #e2e8f0;

            /* Shadows & Radius */
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.05), 0 2px 4px -2px rgb(0 0 0 / 0.05);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.05), 0 4px 6px -4px rgb(0 0 0 / 0.05);
            --shadow-float: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);

            --radius-md: 12px;
            --radius-lg: 16px;
            --radius-xl: 24px;

            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-main);
            margin: 0;
            -webkit-font-smoothing: antialiased;
        }

        .container {
            max-width: 1440px;
            margin: 0 auto;
            padding: 2rem 1.5rem;
        }

        /* ============== HERO BANNER ============== */
        .hero-banner {
            background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%);
            border-radius: var(--radius-xl);
            padding: 2.5rem 3rem;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: var(--shadow-lg);
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
        }

        /* Abstract glowing blobs inside banner */
        .hero-banner::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -10%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.3) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .hero-banner::after {
            content: '';
            position: absolute;
            bottom: -50%;
            right: -5%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(14, 165, 233, 0.2) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .hero-text {
            position: relative;
            z-index: 2;
        }

        .hero-text h1 {
            font-size: 2.5rem;
            font-weight: 800;
            margin: 0 0 0.5rem 0;
            letter-spacing: -0.02em;
        }

        .hero-text p {
            color: #cbd5e1;
            font-size: 1.05rem;
            margin: 0;
            max-width: 550px;
            line-height: 1.6;
        }

        .hero-date {
            display: inline-block;
            background: rgba(255, 255, 255, 0.1);
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            margin-bottom: 1rem;
            backdrop-filter: blur(4px);
        }

        /* ============== KPI CARDS ============== */
        .kpi-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2.5rem;
        }

        .kpi-card {
            background: var(--surface);
            padding: 1.5rem;
            border-radius: var(--radius-lg);
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
        }

        .kpi-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
        }

        .kpi-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-md);
        }

        .kpi-content {
            display: flex;
            flex-direction: column;
        }

        .kpi-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.5rem;
        }

        .kpi-value {
            font-size: 2rem;
            font-weight: 800;
            color: var(--text-main);
            line-height: 1;
        }

        .kpi-icon-wrap {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .card-total::before {
            background: var(--primary);
        }

        .card-total .kpi-icon-wrap {
            background: var(--primary-light);
            color: var(--primary);
        }

        .card-ok::before {
            background: var(--success);
        }

        .card-ok .kpi-icon-wrap {
            background: var(--success-light);
            color: var(--success);
        }

        .card-proses::before {
            background: var(--warning);
        }

        .card-proses .kpi-icon-wrap {
            background: var(--warning-light);
            color: var(--warning);
        }

        .card-due::before {
            background: var(--danger);
        }

        .card-due .kpi-icon-wrap {
            background: var(--danger-light);
            color: var(--danger);
        }

        /* ============== BENTO LAYOUT ============== */
        .main-layout {
            display: grid;
            grid-template-columns: 1fr 380px;
            gap: 2rem;
        }

        @media (max-width: 1024px) {
            .main-layout {
                grid-template-columns: 1fr;
            }

            .hero-banner {
                flex-direction: column;
                align-items: flex-start;
                padding: 2rem;
            }
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 1.25rem;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--text-main);
            margin: 0;
        }

        .section-link {
            font-size: 0.875rem;
            color: var(--primary);
            font-weight: 600;
            text-decoration: none;
        }

        .section-link:hover {
            text-decoration: underline;
        }

        /* ============== QUICK ACTIONS ============== */
        .quick-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.25rem;
            margin-bottom: 2.5rem;
        }

        .action-card {
            background: var(--surface);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
            text-decoration: none;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .action-card:hover {
            border-color: var(--primary);
            box-shadow: var(--shadow-md);
            transform: translateY(-3px);
        }

        .action-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .action-text h4 {
            margin: 0 0 0.25rem 0;
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--text-main);
        }

        .action-text p {
            margin: 0;
            font-size: 0.85rem;
            color: var(--text-muted);
            line-height: 1.4;
        }

        /* ============== MODERN TABLE ============== */
        .table-card {
            background: var(--surface);
            border-radius: var(--radius-xl);
            border: 1px solid var(--border-color);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
        }

        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            white-space: nowrap;
        }

        th {
            background: #f8fafc;
            padding: 1.25rem 1.5rem;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-muted);
            text-align: left;
            border-bottom: 1px solid var(--border-color);
        }

        td {
            padding: 1.25rem 1.5rem;
            font-size: 0.95rem;
            color: var(--text-main);
            border-bottom: 1px solid var(--border-color);
            vertical-align: middle;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover td {
            background: var(--surface-hover);
        }

        /* Highlight Critical Row */
        tr.row-critical td {
            background: #fffcfc;
        }

        tr.row-critical:hover td {
            background: #fee2e2;
        }

        .item-name-cell {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .item-avatar {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            background: var(--bg-color);
            border: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1rem;
            color: var(--secondary);
        }

        .badge {
            padding: 0.4rem 0.75rem;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
        }

        .badge-ok {
            background: var(--success-light);
            color: var(--success);
        }

        .badge-proses {
            background: var(--warning-light);
            color: var(--warning);
        }

        .badge-due {
            background: var(--danger-light);
            color: var(--danger);
        }

        .badge-unknown {
            background: var(--bg-color);
            color: var(--text-muted);
        }

        .btn-action {
            background: var(--bg-color);
            color: var(--primary);
            border: 1px solid transparent;
            padding: 0.4rem 0.8rem;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
        }

        .btn-action:hover {
            background: var(--primary-light);
            border-color: #bfdbfe;
        }

        /* ============== SIDEBAR ============== */
        .sidebar-widget {
            background: var(--surface);
            border-radius: var(--radius-xl);
            border: 1px solid var(--border-color);
            padding: 1.5rem;
            box-shadow: var(--shadow-sm);
            margin-bottom: 1.5rem;
        }

        /* Combined Time & Weather */
        .time-weather-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px dashed var(--border-color);
        }

        .time-area h2 {
            font-size: 2.5rem;
            font-weight: 800;
            margin: 0;
            line-height: 1;
            font-variant-numeric: tabular-nums;
        }

        .time-area p {
            margin: 5px 0 0 0;
            font-size: 0.85rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        .weather-area {
            text-align: right;
        }

        .weather-temp {
            font-size: 1.5rem;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 5px;
            justify-content: flex-end;
        }

        .weather-loc {
            font-size: 0.8rem;
            color: var(--text-muted);
            margin-top: 2px;
        }

        /* Prayer Widget */
        .prayer-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .prayer-header h3 {
            margin: 0;
            font-size: 1rem;
            font-weight: 700;
            color: var(--text-main);
        }

        .prayer-card {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            border-radius: var(--radius-md);
            padding: 1.5rem;
            text-align: center;
            color: white;
            margin-bottom: 1rem;
        }

        .prayer-card h4 {
            margin: 0;
            font-size: 0.85rem;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .prayer-card .time {
            font-size: 2.5rem;
            font-weight: 800;
            margin: 0.5rem 0;
            font-variant-numeric: tabular-nums;
        }

        .prayer-card .countdown {
            font-size: 0.85rem;
            color: #38bdf8;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .progress-bg {
            width: 100%;
            height: 6px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }

        .progress-bar {
            height: 100%;
            background: #38bdf8;
            border-radius: 10px;
            transition: width 1s linear;
        }

        .prayer-list {
            display: grid;
            gap: 0.5rem;
        }

        .prayer-item {
            display: flex;
            justify-content: space-between;
            padding: 0.75rem 1rem;
            background: var(--bg-color);
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text-muted);
            border: 1px solid transparent;
        }

        .prayer-item.active {
            background: var(--primary-light);
            color: var(--primary-dark);
            border-color: #bfdbfe;
            box-shadow: 0 2px 4px rgba(59, 130, 246, 0.1);
        }

        .prayer-item.active span:last-child {
            font-weight: 800;
        }

        /* Tip Card */
        .tip-card {
            background: #fffbeb;
            border: 1px solid #fde68a;
            border-radius: var(--radius-lg);
            padding: 1.25rem;
        }

        .tip-card h4 {
            margin: 0 0 0.5rem 0;
            font-size: 0.9rem;
            color: #d97706;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .tip-card p {
            margin: 0;
            font-size: 0.85rem;
            color: #92400e;
            line-height: 1.5;
        }
    </style>
@endpush

@section('content')
    <div class="container">

        <div class="hero-banner">
            <div class="hero-text">
                <div class="hero-date" id="heroDate">Memuat tanggal...</div>
                <h1 id="greetingMsg">Selamat Datang, {{ Auth::user()->name ?? 'Pengguna' }}</h1>
                <p>Pantau jadwal kalibrasi, cek ketersediaan inventory, dan kelola aktivitas hari ini dalam satu dashboard
                    terintegrasi.</p>
            </div>
            <div style="position: relative; width: 150px; height: 150px; z-index: 1; display: none;" class="md-show">
                <div
                    style="position: absolute; width: 80px; height: 80px; background: rgba(255,255,255,0.2); border-radius: 20px; transform: rotate(15deg); top: 10px; left: 10px; backdrop-filter: blur(10px);">
                </div>
                <div
                    style="position: absolute; width: 100px; height: 100px; background: rgba(255,255,255,0.3); border-radius: 50%; bottom: 10px; right: 10px; backdrop-filter: blur(10px); display: flex; align-items: center; justify-content: center; font-size: 2.5rem;">
                    📊</div>
            </div>
        </div>

        <div class="kpi-grid">
            <div class="kpi-card card-total">
                <div class="kpi-content">
                    <span class="kpi-label">Total Inventory</span>
                    <span class="kpi-value">{{ number_format($totalTools ?? 0) }}</span>
                </div>
                <div class="kpi-icon-wrap"><svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg></div>
            </div>
            <div class="kpi-card card-ok">
                <div class="kpi-content">
                    <span class="kpi-label">Status OK</span>
                    <span class="kpi-value">{{ number_format($statusOk ?? 0) }}</span>
                </div>
                <div class="kpi-icon-wrap"><svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg></div>
            </div>
            <div class="kpi-card card-proses">
                <div class="kpi-content">
                    <span class="kpi-label">Sedang Kalibrasi</span>
                    <span class="kpi-value">{{ number_format($statusProses ?? 0) }}</span>
                </div>
                <div class="kpi-icon-wrap"><svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg></div>
            </div>
            <div class="kpi-card card-due">
                <div class="kpi-content">
                    <span class="kpi-label">Due &lt; 15 Hari</span>
                    <span class="kpi-value">{{ number_format($dueSoon ?? 0) }}</span>
                </div>
                <div class="kpi-icon-wrap"><svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg></div>
            </div>
        </div>

        <div class="main-layout">
            <main>
                <div class="section-header">
                    <h2 class="section-title">Akses Cepat</h2>
                </div>
                <div class="quick-grid">
                    <a href="/schedule" class="action-card">
                        <div class="action-icon" style="background: #e0e7ff; color: #1d4ed8;">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="action-text">
                            <h4>Jadwal & Agenda</h4>
                            <p>Pantau kegiatan saksi & inspeksi harian</p>
                        </div>
                    </a>

                    <a href="/kalibrasi" class="action-card">
                        <div class="action-icon" style="background: #fef3c7; color: #d97706;">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                            </svg>
                        </div>
                        <div class="action-text">
                            <h4>Modul Kalibrasi</h4>
                            <p>Perbarui status instrumen pabrik</p>
                        </div>
                    </a>

                    <a href="/portal/inventory" class="action-card">
                        <div class="action-icon" style="background: #dcfce7; color: #059669;">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
                            </svg>
                        </div>
                        <div class="action-text">
                            <h4>Stok Material</h4>
                            <p>Cek ketersediaan valve & spare part</p>
                        </div>
                    </a>

                    <a href="/export" class="action-card">
                        <div class="action-icon" style="background: #f3e8ff; color: #7e22ce;">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                        </div>
                        <div class="action-text">
                            <h4>Unduh Laporan</h4>
                            <p>Export data ke format Spreadsheet</p>
                        </div>
                    </a>
                </div>

                <div class="section-header">
                    <h2 class="section-title">Prioritas Kalibrasi</h2>
                    <a href="/kalibrasi" class="section-link">Buka Modul &rarr;</a>
                </div>

                <div class="table-card">
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>Instrumen</th>
                                    <th>Status</th>
                                    <th>Jadwal Ulang</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($tools->take(6) as $t)
                                    @php
                                        $h = $t->latestHistory;
                                        $s = strtolower(optional($h)->status_kalibrasi ?? '-');

                                        $badgeClass = 'badge-unknown';
                                        $icon = '➖';
                                        $isCritical = false;

                                        if ($s === 'ok') {
                                            $badgeClass = 'badge-ok';
                                            $icon = '✓';
                                        } elseif ($s === 'proses') {
                                            $badgeClass = 'badge-proses';
                                            $icon = '⚙️';
                                        } elseif (str_contains($s, 'jatuh tempo') || $s === 'due') {
                                            $badgeClass = 'badge-due';
                                            $icon = '⚠️';
                                            $isCritical = true;
                                        }

                                        $initial = strtoupper(substr($t->nama_alat, 0, 2));
                                    @endphp
                                    <tr class="{{ $isCritical ? 'row-critical' : '' }}">
                                        <td>
                                            <div class="item-name-cell">
                                                <div class="item-avatar"
                                                    style="{{ $isCritical ? 'background: #fee2e2; color: #dc2626; border-color: #fca5a5;' : '' }}">
                                                    {{ $initial }}</div>
                                                <div>
                                                    <div style="font-weight: 700; color: var(--text-main);">
                                                        {{ $t->nama_alat }}</div>
                                                    <div
                                                        style="font-size: 0.8rem; color: var(--text-muted); margin-top: 2px; font-family: monospace;">
                                                        SN: {{ $t->no_seri }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span class="badge {{ $badgeClass }}">{{ $icon }}
                                                {{ strtoupper($s) }}</span></td>
                                        <td
                                            style="font-family: monospace; font-weight: 600; color: {{ $isCritical ? '#dc2626' : 'inherit' }}">
                                            {{ optional($h)->tgl_kalibrasi_ulang ? $h->tgl_kalibrasi_ulang->format('d/m/Y') : '-' }}
                                        </td>
                                        <td>
                                            <button class="btn-action">Detail</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4"
                                            style="text-align:center; padding: 4rem 1rem; color: var(--text-muted);">
                                            <svg class="w-12 h-12 mx-auto mb-3 text-slate-300" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <div style="font-weight: 600; font-size: 1.1rem; color: var(--text-main);">
                                                Semua Aman!</div>
                                            <p style="font-size: 0.9rem; margin-top: 0.25rem;">Tidak ada instrumen yang
                                                mendekati batas kalibrasi.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>

            <aside>
                <div class="sidebar-widget">
                    <div class="time-weather-header">
                        <div class="time-area">
                            <h2 id="localTime">--:--</h2>
                            <p id="localDate">Memuat...</p>
                        </div>
                        <div class="weather-area">
                            <div class="weather-temp">
                                <span id="weatherIcon">⛅</span>
                                <span id="temp">--°</span>
                            </div>
                            <div class="weather-loc" id="weatherCity">Mencari lokasi...</div>
                        </div>
                    </div>

                    <div class="prayer-section">
                        <div class="prayer-header">
                            <h3>Jadwal Sholat</h3>
                            <svg class="w-5 h-5 text-slate-400" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>

                        <div class="prayer-card">
                            <h4 id="prayerNextLabel">Berikutnya</h4>
                            <div class="time" id="nextPrayerTime">--:--</div>
                            <div class="countdown" id="nextPrayerCountdown">Menghitung...</div>
                            <div class="progress-bg">
                                <div id="prayerProgress" class="progress-bar" style="width: 0%;"></div>
                            </div>
                        </div>

                        <div class="prayer-list" id="prayerListDOM">
                            <div class="prayer-item"><span>Subuh</span><span>--:--</span></div>
                            <div class="prayer-item"><span>Dzuhur</span><span>--:--</span></div>
                            <div class="prayer-item"><span>Ashar</span><span>--:--</span></div>
                            <div class="prayer-item"><span>Maghrib</span><span>--:--</span></div>
                            <div class="prayer-item"><span>Isya</span><span>--:--</span></div>
                        </div>
                    </div>
                </div>

                <div class="tip-card">
                    <h4><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg> Tip Sistem</h4>
                    <p>Pastikan untuk mengekspor laporan inventory di akhir bulan untuk pencocokan data fisik di gudang.</p>
                </div>
            </aside>
        </div>
    </div>
@endsection

@push('js')
    <script>
        'use strict';

        const DashboardApp = {
            // Default ke Jakarta Timur
            coords: {
                lat: -6.2383,
                lon: 106.9892
            },
            prayerTimings: null,
            prayerInterval: null,

            init() {
                this.setGreeting();
                this.initClock();
                this.initLocationAndData();
            },

            // 0. DYNAMIC GREETING
            setGreeting() {
                const hour = new Date().getHours();
                let greeting = 'Selamat Malam';
                if (hour >= 5 && hour < 12) greeting = 'Selamat Pagi';
                else if (hour >= 12 && hour < 15) greeting = 'Selamat Siang';
                else if (hour >= 15 && hour < 18) greeting = 'Selamat Sore';

                const name = "{{ Auth::user()->name ?? 'Pengguna' }}";
                document.getElementById('greetingMsg').innerHTML =
                    `${greeting}, ${name} <span style="font-size:2rem; vertical-align:middle;">👋</span>`;
            },

            // 1. CLOCK & DATE
            initClock() {
                const timeEl = document.getElementById('localTime');
                const dateEl = document.getElementById('localDate');
                const heroDate = document.getElementById('heroDate');

                const updateTime = () => {
                    const now = new Date();
                    timeEl.textContent = now.toLocaleTimeString('id-ID', {
                        hour: '2-digit',
                        minute: '2-digit'
                    });

                    const dateStr = now.toLocaleDateString('id-ID', {
                        weekday: 'long',
                        day: 'numeric',
                        month: 'long',
                        year: 'numeric'
                    });
                    dateEl.textContent = dateStr;
                    if (heroDate) heroDate.textContent = dateStr;
                };

                updateTime();
                setInterval(updateTime, 1000);
            },

            // 2. LOCATION & DATA FETCH
            initLocationAndData() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        (pos) => {
                            this.coords.lat = pos.coords.latitude;
                            this.coords.lon = pos.coords.longitude;
                            this.fetchData();
                            this.getCityName(this.coords.lat, this.coords.lon);
                        },
                        () => {
                            this.fetchData();
                            document.getElementById('weatherCity').textContent = "Jakarta Timur (Default)";
                        }, {
                            timeout: 5000
                        }
                    );
                } else {
                    this.fetchData();
                    document.getElementById('weatherCity').textContent = "Jakarta Timur (Default)";
                }
            },

            fetchData() {
                this.fetchWeather();
                this.fetchPrayer();
            },

            // 3. REVERSE GEOCODING (Get City Name)
            async getCityName(lat, lon) {
                try {
                    const res = await fetch(
                        `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}&zoom=10`);
                    const data = await res.json();
                    let city = data.address.city || data.address.town || data.address.county || data.address
                        .state || "Lokasi Anda";
                    document.getElementById('weatherCity').textContent = city;
                } catch (e) {
                    document.getElementById('weatherCity').textContent = "GPS Aktif";
                }
            },

            // 4. WEATHER (Open-Meteo)
            async fetchWeather() {
                try {
                    const res = await fetch(
                        `https://api.open-meteo.com/v1/forecast?latitude=${this.coords.lat}&longitude=${this.coords.lon}&current_weather=true`
                        );
                    const data = await res.json();

                    const temp = Math.round(data.current_weather.temperature);
                    const code = data.current_weather.weathercode;

                    let icon = '⛅';
                    if (code === 0) icon = '☀️';
                    else if (code >= 1 && code <= 3) icon = '⛅';
                    else if (code >= 45 && code <= 48) icon = '🌫️';
                    else if (code >= 51 && code <= 67) icon = '🌧️';
                    else if (code >= 71 && code <= 77) icon = '❄️';
                    else if (code >= 80 && code <= 99) icon = '⛈️';

                    document.getElementById('weatherIcon').textContent = icon;
                    document.getElementById('temp').textContent = `${temp}°C`;
                } catch (error) {
                    console.error("Gagal load cuaca:", error);
                }
            },

            // 5. PRAYER (Aladhan)
            async fetchPrayer() {
                try {
                    const d = new Date();
                    const res = await fetch(
                        `https://api.aladhan.com/v1/timings/${d.getDate()}-${d.getMonth()+1}-${d.getFullYear()}?latitude=${this.coords.lat}&longitude=${this.coords.lon}&method=2`
                        );
                    const data = await res.json();

                    this.prayerTimings = data.data.timings;

                    if (this.prayerInterval) clearInterval(this.prayerInterval);
                    this.prayerInterval = setInterval(() => this.calculateNextPrayer(), 1000);
                    this.calculateNextPrayer();

                } catch (error) {
                    console.error("Gagal load sholat:", error);
                }
            },

            // 6. PRAYER LOGIC & UI
            calculateNextPrayer() {
                if (!this.prayerTimings) return;

                const now = new Date();
                const schedule = [{
                        key: 'Fajr',
                        name: 'Subuh',
                        time: this.prayerTimings.Fajr
                    },
                    {
                        key: 'Dhuhr',
                        name: 'Dzuhur',
                        time: this.prayerTimings.Dhuhr
                    },
                    {
                        key: 'Asr',
                        name: 'Ashar',
                        time: this.prayerTimings.Asr
                    },
                    {
                        key: 'Maghrib',
                        name: 'Maghrib',
                        time: this.prayerTimings.Maghrib
                    },
                    {
                        key: 'Isha',
                        name: 'Isya',
                        time: this.prayerTimings.Isha
                    }
                ];

                const listDom = document.getElementById('prayerListDOM');
                let listHTML = '';
                let nextPrayer = null;
                let targetDate = null;

                for (let p of schedule) {
                    const [h, m] = p.time.split(':');
                    let pDate = new Date();
                    pDate.setHours(h, m, 0, 0);

                    let isActive = false;
                    if (pDate > now && !nextPrayer) {
                        nextPrayer = p;
                        targetDate = pDate;
                        isActive = true;
                    }

                    listHTML +=
                        `<div class="prayer-item ${isActive ? 'active' : ''}"><span>${p.name}</span><span>${p.time}</span></div>`;
                }

                if (!nextPrayer) {
                    nextPrayer = {
                        name: 'Subuh (Besok)',
                        time: schedule[0].time
                    };
                    const [h, m] = schedule[0].time.split(':');
                    targetDate = new Date();
                    targetDate.setDate(targetDate.getDate() + 1);
                    targetDate.setHours(h, m, 0, 0);
                    listHTML = listHTML.replace('prayer-item', 'prayer-item active');
                }

                listDom.innerHTML = listHTML;

                document.getElementById('prayerNextLabel').textContent = `Menuju ${nextPrayer.name}`;
                document.getElementById('nextPrayerTime').textContent = nextPrayer.time;

                const diffMs = targetDate - now;
                const diffHrs = Math.floor(diffMs / 3600000);
                const diffMins = Math.floor((diffMs % 3600000) / 60000);
                const diffSecs = Math.floor((diffMs % 60000) / 1000);

                let cdText = '';
                if (diffHrs > 0) cdText += `${diffHrs}j `;
                cdText += `${diffMins}m ${diffSecs}s`;
                document.getElementById('nextPrayerCountdown').textContent = `- ${cdText} lagi`;

                // Progress Bar Animasi (1 jam referensi)
                const totalMs = 3600000;
                const progressBar = document.getElementById('prayerProgress');

                if (diffMs <= totalMs) {
                    const percentage = 100 - ((diffMs / totalMs) * 100);
                    progressBar.style.width = `${percentage}%`;
                    progressBar.style.background = (diffMs < 600000) ? 'var(--danger)' :
                    '#38bdf8'; // merah jika < 10 menit
                } else {
                    progressBar.style.width = '0%';
                }
            }
        };

        document.addEventListener('DOMContentLoaded', () => DashboardApp.init());
    </script>
@endpush

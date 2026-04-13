@extends('layouts.admin')
@section('title', 'Dashboard | Main')

@push('css')
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700;800&display=swap"
        rel="stylesheet">

    <style>
        /* ========== CSS VARIABLES (MINIMALIST FULL SCREEN BENTO) ========== */
        :root {
            /* Accent Colors */
            --primary: #2563eb;
            --primary-subtle: #eff6ff;
            --success: #10b981;
            --success-subtle: #ecfdf5;
            --warning: #f59e0b;
            --warning-subtle: #fffbeb;
            --danger: #ef4444;
            --danger-subtle: #fef2f2;
            --info: #0ea5e9;
            --info-subtle: #f0f9ff;
            --purple: #8b5cf6;
            --purple-subtle: #f5f3ff;

            /* Base Colors */
            --text-dark: #0f172a;
            --text-muted: #64748b;
            --text-light: #94a3b8;
            --bg-body: #f8fafc;
            --bg-card: #ffffff;
            --border-color: #e2e8f0;
            --border-hover: #cbd5e1;

            /* Layout & Spacing */
            --radius-lg: 24px;
            --radius-md: 16px;
            --radius-sm: 12px;
            --gap: 1.5rem;

            /* Effects */
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-card: 0 4px 6px -1px rgba(0, 0, 0, 0.02), 0 2px 4px -2px rgba(0, 0, 0, 0.02);
            --shadow-hover: 0 10px 15px -3px rgba(0, 0, 0, 0.04), 0 4px 6px -4px rgba(0, 0, 0, 0.02);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            box-sizing: border-box;
            outline: none;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-dark);
            -webkit-font-smoothing: antialiased;
            background-image: radial-gradient(var(--border-color) 1px, transparent 1px);
            background-size: 24px 24px;
            min-height: 100vh;
        }

        /* FULL SCREEN CONTAINER */
        .container-main {
            width: 100%;
            min-height: 100vh;
            margin: 0;
            padding: 2rem;
            /* Jarak aman dari tepi layar */
        }

        /* ============== 1. BENTO CARD BASE ============== */
        .bento-card {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-card);
            transition: var(--transition);
            opacity: 0;
            transform: translateY(15px);
            animation: fadeUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .bento-card:hover {
            box-shadow: var(--shadow-hover);
            border-color: var(--border-hover);
            transform: translateY(-2px);
        }

        @keyframes fadeUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .section-title {
            color: var(--text-muted);
            font-weight: 700;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 2.5rem 0 1rem 0.5rem;
            display: flex;
            align-items: center;
            gap: 8px;
            opacity: 0;
            animation: fadeUp 0.6s forwards;
        }

        /* ============== 2. PAGE HEADER ============== */
        .page-header {
            padding: 2.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .header-content h2 {
            font-size: 1.75rem;
            font-weight: 800;
            margin: 0 0 0.5rem 0;
            letter-spacing: -0.02em;
            color: var(--text-dark);
        }

        .header-content p {
            color: var(--text-muted);
            font-size: 0.95rem;
            margin: 0;
            font-weight: 500;
        }

        .header-date {
            background: var(--bg-body);
            border: 1px solid var(--border-color);
            padding: 0.6rem 1.25rem;
            border-radius: 999px;
            font-size: 0.85rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--text-muted);
        }

        /* ============== 3. QUICK ACCESS GRID ============== */
        .grid-quick {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            /* Auto adjust full width */
            gap: var(--gap);
        }

        .quick-card {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            padding: 1.5rem;
            text-decoration: none;
            border-radius: var(--radius-lg);
        }

        .quick-card:nth-child(1) {
            animation-delay: 0.05s;
        }

        .quick-card:nth-child(2) {
            animation-delay: 0.1s;
        }

        .quick-card:nth-child(3) {
            animation-delay: 0.15s;
        }

        .quick-card:nth-child(4) {
            animation-delay: 0.2s;
        }

        .quick-card:nth-child(5) {
            animation-delay: 0.25s;
        }

        .quick-card:nth-child(6) {
            animation-delay: 0.3s;
        }

        .quick-card .icon-wrapper {
            width: 48px;
            height: 48px;
            border-radius: var(--radius-sm);
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            transition: var(--transition);
        }

        .qc-warning .icon-wrapper {
            background: var(--warning-subtle);
            color: var(--warning);
        }

        .qc-primary .icon-wrapper {
            background: var(--primary-subtle);
            color: var(--primary);
        }

        .qc-danger .icon-wrapper {
            background: var(--danger-subtle);
            color: var(--danger);
        }

        .qc-info .icon-wrapper {
            background: var(--info-subtle);
            color: var(--info);
        }

        .qc-secondary .icon-wrapper {
            background: var(--purple-subtle);
            color: var(--purple);
        }

        .qc-success .icon-wrapper {
            background: var(--success-subtle);
            color: var(--success);
        }

        .quick-card .title {
            font-weight: 700;
            font-size: 0.95rem;
            color: var(--text-dark);
            margin-bottom: 0.25rem;
        }

        .quick-card .meta {
            color: var(--text-muted);
            font-size: 0.75rem;
            font-weight: 600;
        }

        /* ============== 4. KPI GRID ============== */
        .grid-kpi {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            /* Fluid Width */
            gap: var(--gap);
        }

        .kpi-card {
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 160px;
        }

        .kpi-card:nth-child(1) {
            animation-delay: 0.2s;
        }

        .kpi-card:nth-child(2) {
            animation-delay: 0.3s;
        }

        .kpi-card:nth-child(3) {
            animation-delay: 0.4s;
        }

        .kpi-card:nth-child(4) {
            animation-delay: 0.5s;
        }

        .kpi-card:nth-child(5) {
            animation-delay: 0.6s;
        }

        .kpi-head {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
        }

        .kpi-title {
            font-weight: 700;
            font-size: 0.75rem;
            text-transform: uppercase;
            color: var(--text-muted);
            letter-spacing: 0.5px;
        }

        .kpi-value {
            font-weight: 800;
            font-size: 2rem;
            color: var(--text-dark);
            line-height: 1.2;
            font-family: 'JetBrains Mono', monospace;
        }

        .kpi-icon {
            width: 36px;
            height: 36px;
            border-radius: var(--radius-sm);
            font-size: 1.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .kpi-materials .kpi-icon {
            background: var(--primary-subtle);
            color: var(--primary);
        }

        .kpi-users .kpi-icon {
            background: var(--success-subtle);
            color: var(--success);
        }

        .kpi-schedules .kpi-icon {
            background: var(--warning-subtle);
            color: var(--warning);
        }

        .kpi-calibs .kpi-icon {
            background: var(--info-subtle);
            color: var(--info);
        }

        .kpi-docs .kpi-icon {
            background: var(--purple-subtle);
            color: var(--purple);
        }

        .sparkline-wrapper {
            height: 35px;
            width: 100%;
            margin-top: auto;
        }

        /* ============== 5. SPLIT CONTENT (TABLE & TIMELINE) ============== */
        .grid-split {
            display: grid;
            grid-template-columns: 1fr;
            gap: var(--gap);
            margin-bottom: 2rem;
        }

        /* 60% Table, 40% Timeline for Full Screen */
        @media(min-width: 1024px) {
            .grid-split {
                grid-template-columns: 6fr 4fr;
            }
        }

        @media(min-width: 1600px) {
            .grid-split {
                grid-template-columns: 7fr 3fr;
            }
        }

        /* Ultra wide adjustment */

        .insight-card {
            padding: 0;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            animation-delay: 0.5s;
        }

        .insight-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: var(--bg-card);
        }

        .insight-header h6 {
            margin: 0;
            font-weight: 700;
            color: var(--text-dark);
            font-size: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-sm-custom {
            background: var(--bg-body);
            border: 1px solid var(--border-color);
            color: var(--text-muted);
            padding: 0.4rem 1rem;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            text-decoration: none;
            transition: var(--transition);
        }

        .btn-sm-custom:hover {
            background: var(--border-color);
            color: var(--text-dark);
        }

        /* Minimalist Table */
        .table-wrapper {
            overflow-x: auto;
            padding: 0;
        }

        .table-custom {
            width: 100%;
            border-collapse: collapse;
            min-width: 500px;
        }

        .table-custom th {
            color: var(--text-muted);
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid var(--border-color);
            padding: 1rem 1.5rem;
            text-align: left;
            background-color: var(--bg-body);
        }

        .table-custom td {
            padding: 1.25rem 1.5rem;
            vertical-align: middle;
            border-bottom: 1px solid var(--border-color);
        }

        .table-custom tr:last-child td {
            border-bottom: none;
        }

        .table-custom tr:hover td {
            background-color: var(--bg-body);
        }

        /* Thin Progress Bar */
        .progress-sm {
            height: 4px;
            border-radius: 4px;
            background-color: var(--border-color);
            overflow: hidden;
            margin-top: 6px;
            width: 100%;
            max-width: 150px;
            margin-left: auto;
        }

        .progress-sm .progress-bar {
            height: 100%;
            border-radius: 4px;
            transition: width 1s ease;
        }

        .bg-primary-grad {
            background-color: var(--primary);
        }

        .bg-warning-grad {
            background-color: var(--warning);
        }

        .bg-success-grad {
            background-color: var(--success);
        }

        /* Minimalist Timeline */
        .timeline-wrapper {
            position: relative;
            padding: 1.5rem;
            margin: 0;
            list-style: none;
            flex-grow: 1;
            overflow-y: auto;
            max-height: 420px;
        }

        .timeline-wrapper::before {
            content: '';
            position: absolute;
            left: 2.45rem;
            top: 2rem;
            bottom: 2rem;
            width: 1px;
            background: var(--border-color);
            z-index: 1;
        }

        .timeline-item {
            display: flex;
            margin-bottom: 1.5rem;
            position: relative;
            z-index: 2;
            align-items: flex-start;
        }

        .timeline-item:last-child {
            margin-bottom: 0;
        }

        .timeline-icon {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            margin-right: 1.25rem;
            font-size: 1rem;
            z-index: 2;
            box-shadow: 0 0 0 4px var(--bg-card);
        }

        .timeline-content {
            width: 100%;
            padding-top: 4px;
        }

        .timeline-content .title {
            font-weight: 700;
            font-size: 0.9rem;
            color: var(--text-dark);
            margin-bottom: 4px;
        }

        .timeline-content .desc {
            color: var(--text-muted);
            font-size: 0.8rem;
            line-height: 1.5;
            font-weight: 400;
            margin-bottom: 6px;
        }

        .timeline-content .meta {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--text-light);
        }

        .timeline-content .meta i {
            font-size: 0.85rem;
        }

        /* Custom Scrollbar Minimal */
        .custom-scroll::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scroll::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scroll::-webkit-scrollbar-thumb {
            background: var(--border-color);
            border-radius: 10px;
        }

        .custom-scroll::-webkit-scrollbar-thumb:hover {
            background: var(--text-light);
        }

        @media (max-width: 768px) {
            .container-main {
                padding: 1rem;
            }

            .page-header {
                padding: 1.5rem;
                flex-direction: column;
                align-items: flex-start;
            }

            .header-content h2 {
                font-size: 1.5rem;
            }
        }
    </style>
@endpush

@section('content')
    <div class="container-main">

        {{-- PAGE HEADER MINIMALIST --}}
        <div class="bento-card page-header">
            <div class="header-content">
                <h2>Halo, {{ optional(Auth::user())->name ?? 'Admin' }}.</h2>
                <p>Ringkasan operasional dan pemantauan sistem real-time.</p>
            </div>
            <div class="header-date">
                <i class='bx bx-calendar text-muted'></i>
                {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
            </div>
        </div>

        {{-- QUICK ACCESS --}}
        <div class="section-title">Navigasi Akses</div>
        <div class="grid-quick mb-5">
            <a href="{{ route('announcements.index') }}" class="bento-card quick-card qc-warning">
                <div class="icon-wrapper"><i class="bx bx-news"></i></div>
                <div class="title">Pengumuman</div>
                <div class="meta">{{ $totalAnnon ?? 0 }} Update</div>
            </a>
            <a href="{{ url('/activities/witness') }}" class="bento-card quick-card qc-primary">
                <div class="icon-wrapper"><i class="bx bx-calendar"></i></div>
                <div class="title">Jadwal</div>
                <div class="meta">{{ $totalSchedules ?? 0 }} Agenda</div>
            </a>
            <a href="{{ url('/portal/inventory') }}" class="bento-card quick-card qc-danger">
                <div class="icon-wrapper"><i class="bx bx-box"></i></div>
                <div class="title">Inventory</div>
                <div class="meta">{{ $totalMaterial ?? 0 }} Material</div>
            </a>
            <a href="{{ url('/activities/kalibrasi') }}" class="bento-card quick-card qc-info">
                <div class="icon-wrapper"><i class="bx bx-wrench"></i></div>
                <div class="title">Kalibrasi</div>
                <div class="meta">{{ $totalKalibrasi ?? 0 }} Alat</div>
            </a>
            <a href="{{ url('/portal/document') }}" class="bento-card quick-card qc-secondary">
                <div class="icon-wrapper"><i class="bx bx-file"></i></div>
                <div class="title">Dokumen</div>
                <div class="meta">{{ $totalDocuments ?? 0 }} Berkas</div>
            </a>
            @if (optional(Auth::user())->role === 'SUP')
                <a href="{{ route('users.index') }}" class="bento-card quick-card qc-success">
                    <div class="icon-wrapper"><i class="bx bx-group"></i></div>
                    <div class="title">Pengguna</div>
                    <div class="meta">{{ $totalUsers ?? 0 }} Aktif</div>
                </a>
            @endif
        </div>

        {{-- METRIK KPI --}}
        <div class="section-title">Metrik Utama</div>
        <div class="grid-kpi mb-5">
            <div class="bento-card kpi-card kpi-materials">
                <div class="kpi-head">
                    <div>
                        <div class="kpi-title">Inventory</div>
                        <div class="kpi-value">{{ number_format($totalMaterial ?? 0) }}</div>
                    </div>
                    <div class="kpi-icon"><i class="bx bx-archive"></i></div>
                </div>
                <div class="sparkline-wrapper"><canvas id="sparkMaterials"></canvas></div>
            </div>

            <div class="bento-card kpi-card kpi-users">
                <div class="kpi-head">
                    <div>
                        <div class="kpi-title">User Aktif</div>
                        <div class="kpi-value">{{ number_format($totalUsers ?? 0) }}</div>
                    </div>
                    <div class="kpi-icon"><i class="bx bx-user-check"></i></div>
                </div>
                <div class="sparkline-wrapper"><canvas id="sparkUsers"></canvas></div>
            </div>

            <div class="bento-card kpi-card kpi-schedules">
                <div class="kpi-head">
                    <div>
                        <div class="kpi-title">Jadwal Agenda</div>
                        <div class="kpi-value">{{ number_format($totalSchedules ?? 0) }}</div>
                    </div>
                    <div class="kpi-icon"><i class="bx bx-calendar-event"></i></div>
                </div>
                <div class="sparkline-wrapper"><canvas id="sparkSched"></canvas></div>
            </div>

            <div class="bento-card kpi-card kpi-calibs">
                <div class="kpi-head">
                    <div>
                        <div class="kpi-title">Kalibrasi</div>
                        <div class="kpi-value">{{ number_format($totalKalibrasi ?? 0) }}</div>
                    </div>
                    <div class="kpi-icon"><i class="bx bx-slider-alt"></i></div>
                </div>
                <div class="sparkline-wrapper"><canvas id="sparkCalib"></canvas></div>
            </div>

            <div class="bento-card kpi-card kpi-docs">
                <div class="kpi-head">
                    <div>
                        <div class="kpi-title">Dokumen</div>
                        <div class="kpi-value">{{ number_format($totalDocuments ?? 0) }}</div>
                    </div>
                    <div class="kpi-icon"><i class="bx bx-file-blank"></i></div>
                </div>
                <div class="sparkline-wrapper"><canvas id="sparkDocs"></canvas></div>
            </div>
        </div>

        {{-- TABLES & TIMELINE --}}
        <div class="grid-split">

            {{-- PROSES KALIBRASI AKTIF --}}
            <div class="bento-card insight-card">
                <div class="insight-header">
                    <h6><i class="bx bx-cog text-muted"></i> Proses Kalibrasi</h6>
                    <a href="{{ url('/activities/kalibrasi') }}" class="btn-sm-custom">Lihat Semua</a>
                </div>

                <div class="table-wrapper custom-scroll">
                    <table class="table-custom">
                        <thead>
                            <tr>
                                <th width="45%">Instrumen</th>
                                <th width="25%">Tanggal Mulai</th>
                                <th width="30%" style="text-align: right;">Progress</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($activeCalibrations ?? [] as $item)
                                @php
                                    $progress = $item->progress ?? rand(10, 90);
                                    $barColor = 'bg-primary-grad';
                                    if ($progress < 40) {
                                        $barColor = 'bg-warning-grad';
                                    } elseif ($progress > 80) {
                                        $barColor = 'bg-success-grad';
                                    }
                                @endphp
                                <tr>
                                    <td>
                                        <div style="font-weight: 700; font-size: 0.9rem; color: var(--text-dark);">
                                            {{ $item->nama_alat ?? 'Nama Alat' }}
                                        </div>
                                        <div
                                            style="font-family: 'JetBrains Mono', monospace; color: var(--text-muted); font-size: 0.75rem; margin-top: 2px;">
                                            SN: {{ $item->no_seri ?? '-' }}
                                        </div>
                                    </td>
                                    <td>
                                        <div style="font-weight: 600; font-size: 0.85rem; color: var(--text-dark);">
                                            {{ \Carbon\Carbon::parse($item->tgl_mulai ?? $item->created_at)->format('d M Y') }}
                                        </div>
                                    </td>
                                    <td>
                                        <div
                                            style="text-align: right; font-weight: 700; font-size: 0.75rem; color: var(--text-muted); font-family: 'JetBrains Mono', monospace;">
                                            {{ $progress }}%
                                        </div>
                                        <div class="progress-sm">
                                            <div class="progress-bar {{ $barColor }}"
                                                style="width: {{ $progress }}%"></div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" style="text-align: center; padding: 4rem 1rem;">
                                        <i class="bx bx-check-circle"
                                            style="font-size: 2rem; color: var(--text-light); margin-bottom: 8px;"></i>
                                        <div style="font-weight: 600; font-size: 0.9rem; color: var(--text-muted);">Tidak
                                            ada proses yang sedang berjalan.</div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- AKTIVITAS TERBARU --}}
            <div class="bento-card insight-card">
                <div class="insight-header">
                    <h6><i class="bx bx-history text-muted"></i> Log Aktivitas</h6>
                </div>

                <ul class="timeline-wrapper custom-scroll">
                    @forelse($recentActivities ?? [] as $activity)
                        @php
                            $tipe = strtolower($activity->tipe ?? 'system');
                            $iconMap = [
                                'dokumen' => [
                                    'bg' => 'var(--info-subtle)',
                                    'color' => 'var(--info)',
                                    'bx' => 'bx-file',
                                ],
                                'kalibrasi' => [
                                    'bg' => 'var(--warning-subtle)',
                                    'color' => 'var(--warning)',
                                    'bx' => 'bx-wrench',
                                ],
                                'inventory' => [
                                    'bg' => 'var(--danger-subtle)',
                                    'color' => 'var(--danger)',
                                    'bx' => 'bx-box',
                                ],
                                'system' => [
                                    'bg' => 'var(--success-subtle)',
                                    'color' => 'var(--success)',
                                    'bx' => 'bx-check-shield',
                                ],
                            ];
                            $cfg = $iconMap[$tipe] ?? $iconMap['system'];
                            $userName = isset($activity->user->name) ? $activity->user->name : 'System';
                        @endphp

                        <li class="timeline-item">
                            <div class="timeline-icon"
                                style="background: {{ $cfg['bg'] }}; color: {{ $cfg['color'] }}; border: 1px solid {{ $cfg['color'] }}30;">
                                <i class="bx {{ $cfg['bx'] }}"></i>
                            </div>
                            <div class="timeline-content">
                                <div class="title">{{ $activity->judul ?? 'Aktivitas Sistem' }}</div>
                                <div class="desc">{!! $activity->deskripsi ?? '-' !!}</div>
                                <div class="meta">
                                    <span style="display: flex; align-items:center; gap:4px;">
                                        <i class="bx bx-user"></i> {{ $userName }}
                                    </span>
                                    <span style="display: flex; align-items:center; gap:4px;">
                                        <i class="bx bx-time-five"></i>
                                        {{ isset($activity->created_at) ? \Carbon\Carbon::parse($activity->created_at)->diffForHumans() : 'Baru saja' }}
                                    </span>
                                </div>
                            </div>
                        </li>
                    @empty
                        <li style="text-align: center; padding: 4rem 1rem; list-style: none;">
                            <i class="bx bx-list-ul"
                                style="font-size: 2rem; color: var(--text-light); margin-bottom: 8px;"></i>
                            <div style="font-weight: 600; font-size: 0.9rem; color: var(--text-muted);">Belum ada rekam
                                jejak.</div>
                        </li>
                    @endforelse
                </ul>
            </div>

        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @php
        // Data Fallback (Dummy)
        $dataSparkA = $sparkA ?? [10, 15, 20, 18, 25, 30, 28];
        $dataSparkB = $sparkB ?? [5, 8, 12, 10, 15, 12, 18];
    @endphp

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // --- Sparkline Generator ---
            function renderSparkline(elId, dataArray, colorHex) {
                const el = document.getElementById(elId);
                if (!el) return;

                const ctx = el.getContext('2d');
                let gradient = ctx.createLinearGradient(0, 0, 0, 35);
                gradient.addColorStop(0, colorHex + '20'); // 10% opacity
                gradient.addColorStop(1, colorHex + '00'); // 0% opacity

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: dataArray.map((_, i) => i),
                        datasets: [{
                            data: dataArray,
                            borderColor: colorHex,
                            backgroundColor: gradient,
                            fill: true,
                            tension: 0.4,
                            borderWidth: 2,
                            pointRadius: 0,
                            pointHoverRadius: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        layout: {
                            padding: 0
                        },
                        scales: {
                            x: {
                                display: false
                            },
                            y: {
                                display: false,
                                min: Math.min(...dataArray) * 0.8
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                enabled: false
                            }
                        },
                        interaction: {
                            mode: 'none'
                        },
                        animation: {
                            duration: 1000,
                            easing: 'easeOutQuart'
                        }
                    }
                });
            }

            const sparkA = @json($dataSparkA);
            const sparkB = @json($dataSparkB);

            // Warna disesuaikan dengan CSS Variables untuk harmoni
            renderSparkline('sparkMaterials', sparkA, '#2563eb');
            renderSparkline('sparkUsers', sparkB, '#10b981');
            renderSparkline('sparkSched', sparkA, '#f59e0b');
            renderSparkline('sparkCalib', sparkB, '#0ea5e9');
            renderSparkline('sparkDocs', sparkA, '#8b5cf6');
        });
    </script>
@endpush

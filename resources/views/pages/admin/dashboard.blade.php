@extends('layouts.admin')
@section('title', 'Dashboard | Main')

@push('css')
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --bg-body: #f8fafc;
            --bg-card: #ffffff;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --primary: #3b82f6;
            --primary-light: #eff6ff;
            --success: #10b981;
            --success-light: #ecfdf5;
            --warning: #f59e0b;
            --warning-light: #fffbeb;
            --danger: #ef4444;
            --danger-light: #fef2f2;
            --info: #0ea5e9;
            --info-light: #e0f2fe;
            --secondary: #8b5cf6;
            --secondary-light: #f5f3ff;
            --radius-lg: 20px;
            --radius-md: 16px;
            --border-color: #e2e8f0;
            --shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -2px rgba(0, 0, 0, 0.05);
            --shadow-hover: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-main);
        }

        .container-xxl {
            padding-top: 1.5rem;
            padding-bottom: 2rem;
        }

        /* ============== DASHBOARD HEADER ============== */
        .dashboard-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1.5rem;
            margin-bottom: 2rem;
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            border-radius: var(--radius-lg);
            box-shadow: 0 10px 30px -10px rgba(15, 23, 42, 0.5);
            padding: 2rem 2.5rem;
            position: relative;
            overflow: hidden;
            color: white;
        }

        .dashboard-header::after {
            content: '';
            position: absolute;
            top: -50%;
            right: -5%;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.2) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .greeting {
            position: relative;
            z-index: 1;
        }

        .greeting h4 {
            margin: 0 0 0.25rem 0;
            font-size: 1.5rem;
            font-weight: 800;
            color: #ffffff;
            letter-spacing: -0.02em;
        }

        .greeting .sub {
            color: #94a3b8;
            font-size: 0.95rem;
            font-weight: 500;
        }

        .header-date {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            padding: 0.5rem 1rem;
            border-radius: 999px;
            font-size: 0.85rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            z-index: 1;
        }

        /* ============== QUICK ACCESS CARDS ============== */
        .section-title {
            color: var(--text-muted);
            font-weight: 800;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .quick-card {
            border-radius: var(--radius-md);
            transition: var(--transition);
            background: var(--bg-card);
            min-height: 120px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--border-color);
            position: relative;
            overflow: hidden;
            text-align: center;
            box-shadow: var(--shadow-sm);
        }

        .quick-card:hover {
            transform: translateY(-5px);
            border-color: transparent;
        }

        .qc-warning:hover {
            box-shadow: 0 10px 20px -5px rgba(245, 158, 11, 0.2);
            border-color: #fcd34d;
        }

        .qc-primary:hover {
            box-shadow: 0 10px 20px -5px rgba(59, 130, 246, 0.2);
            border-color: #93c5fd;
        }

        .qc-danger:hover {
            box-shadow: 0 10px 20px -5px rgba(239, 68, 68, 0.2);
            border-color: #fca5a5;
        }

        .qc-info:hover {
            box-shadow: 0 10px 20px -5px rgba(14, 165, 233, 0.2);
            border-color: #7dd3fc;
        }

        .qc-secondary:hover {
            box-shadow: 0 10px 20px -5px rgba(139, 92, 246, 0.2);
            border-color: #c4b5fd;
        }

        .qc-success:hover {
            box-shadow: 0 10px 20px -5px rgba(16, 185, 129, 0.2);
            border-color: #6ee7b7;
        }

        .quick-card .icon-wrapper {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            font-size: 1.5rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 0.5rem;
            transition: var(--transition);
        }

        .quick-card:hover .icon-wrapper {
            transform: scale(1.1) rotate(5deg);
        }

        .quick-card .title {
            font-weight: 700;
            font-size: 0.95rem;
            color: var(--text-main);
        }

        .quick-card .meta {
            color: var(--text-muted);
            font-size: 0.75rem;
            font-weight: 600;
            margin-top: 0.2rem;
            background: var(--bg-body);
            padding: 2px 8px;
            border-radius: 999px;
            display: inline-block;
        }

        .icon-warning {
            background: var(--warning-light);
            color: var(--warning);
        }

        .icon-primary {
            background: var(--primary-light);
            color: var(--primary);
        }

        .icon-danger {
            background: var(--danger-light);
            color: var(--danger);
        }

        .icon-info {
            background: var(--info-light);
            color: var(--info);
        }

        .icon-secondary {
            background: var(--secondary-light);
            color: var(--secondary);
        }

        .icon-success {
            background: var(--success-light);
            color: var(--success);
        }

        /* ============== KPI TILES ============== */
        .kpi {
            border-radius: var(--radius-md);
            padding: 1.25rem 1.5rem;
            background: var(--bg-card);
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .kpi::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            border-radius: 4px 0 0 4px;
            background: var(--text-muted);
            transition: var(--transition);
        }

        .kpi-materials::before {
            background: var(--primary);
        }

        .kpi-users::before {
            background: var(--success);
        }

        .kpi-schedules::before {
            background: var(--warning);
        }

        .kpi-calibs::before {
            background: var(--info);
        }

        .kpi-docs::before {
            background: var(--secondary);
        }

        .kpi:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-3px);
        }

        .kpi .kpi-head {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .kpi .kpi-icon {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            font-size: 1.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--bg-body);
        }

        .kpi .kpi-value {
            font-weight: 800;
            font-size: 1.75rem;
            color: var(--text-main);
            line-height: 1;
            letter-spacing: -0.5px;
        }

        .kpi .kpi-sub {
            color: var(--text-muted);
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 6px;
        }

        .stat-pill {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 0.25rem 0.75rem;
            border-radius: 999px;
            font-weight: 700;
            font-size: 0.7rem;
            text-transform: uppercase;
        }

        .sparkline-wrapper {
            height: 35px;
            width: 80px;
        }

        /* ============== INSIGHT CARDS (TABLE & TIMELINE) ============== */
        .insight-card {
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border-color);
            background: var(--bg-card);
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .insight-header {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #fafbfc;
            border-radius: var(--radius-lg) var(--radius-lg) 0 0;
        }

        .insight-header h6 {
            margin: 0;
            font-weight: 800;
            color: var(--text-main);
            font-size: 1.05rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Modern Table */
        .table-custom {
            margin-bottom: 0;
        }

        .table-custom th {
            background: var(--bg-body);
            color: var(--text-muted);
            font-size: 0.7rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid var(--border-color);
            padding: 1rem;
            white-space: nowrap;
        }

        .table-custom td {
            padding: 1rem;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
            font-size: 0.9rem;
            color: var(--text-main);
        }

        .table-custom tr:hover {
            background-color: var(--bg-body);
        }

        /* Progress Bar (Dalam Tabel) */
        .progress-sm {
            height: 6px;
            border-radius: 3px;
            background-color: var(--border-color);
            overflow: hidden;
            margin-top: 4px;
        }

        .progress-sm .progress-bar {
            border-radius: 3px;
        }

        /* Modern Timeline */
        .timeline-wrapper {
            position: relative;
            padding: 1.5rem;
            margin: 0;
            list-style: none;
            flex-grow: 1;
            overflow-y: auto;
            max-height: 450px;
        }

        .timeline-wrapper::-webkit-scrollbar {
            width: 4px;
        }

        .timeline-wrapper::-webkit-scrollbar-track {
            background: transparent;
        }

        .timeline-wrapper::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .timeline-wrapper::before {
            content: '';
            position: absolute;
            left: 2.35rem;
            top: 1.5rem;
            bottom: 1.5rem;
            width: 2px;
            background: var(--border-color);
            z-index: 1;
        }

        .timeline-item {
            display: flex;
            margin-bottom: 1.5rem;
            position: relative;
            z-index: 2;
        }

        .timeline-item:last-child {
            margin-bottom: 0;
        }

        .timeline-icon {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: 3px solid var(--bg-card);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 0 0 2px var(--border-color);
            color: #fff;
            flex-shrink: 0;
            margin-right: 1rem;
            font-size: 0.85rem;
            z-index: 2;
        }

        .timeline-content {
            background: var(--bg-body);
            border: 1px solid var(--border-color);
            padding: 0.75rem 1rem;
            border-radius: 12px;
            width: 100%;
            position: relative;
        }

        /* Segitiga panah timeline */
        .timeline-content::before {
            content: '';
            position: absolute;
            left: -6px;
            top: 10px;
            width: 10px;
            height: 10px;
            background: var(--bg-body);
            border-left: 1px solid var(--border-color);
            border-bottom: 1px solid var(--border-color);
            transform: rotate(45deg);
        }

        /* ============== RESPONSIVE ============== */
        @media (max-width: 768px) {
            .dashboard-header {
                padding: 1.5rem;
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .header-date {
                align-self: flex-start;
            }

            .dashboard-header::after {
                display: none;
            }

            .insight-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }
        }
    </style>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        {{-- HEADER DASHBOARD --}}
        <div class="dashboard-header">
            <div class="greeting">
                <h4>👋 Halo, {{ optional(Auth::user())->name ?? 'Admin' }}!</h4>
                <div class="sub">
                    Pantau metrik, kelola dokumen, dan pantau proses kalibrasi secara real-time.
                </div>
            </div>
            <div class="header-date">
                <i class='bx bx-calendar'></i>
                {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
            </div>
        </div>

        {{-- QUICK ACCESS CARDS --}}
        <div class="section-title"><i class='bx bx-grid-alt'></i> Navigasi Pintas</div>
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-4 col-xl-2">
                <a href="{{ route('announcements.index') }}" class="text-decoration-none">
                    <div class="card quick-card qc-warning h-100">
                        <div class="card-body p-3">
                            <div class="icon-wrapper icon-warning"><i class="bx bx-news"></i></div>
                            <div class="title">Pengumuman</div>
                            <div class="meta">{{ $totalAnnon ?? 0 }} Item</div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-4 col-xl-2">
                <a href="{{ url('/activities/witness') }}" class="text-decoration-none">
                    <div class="card quick-card qc-primary h-100">
                        <div class="card-body p-3">
                            <div class="icon-wrapper icon-primary"><i class="bx bx-calendar"></i></div>
                            <div class="title">Jadwal</div>
                            <div class="meta">{{ $totalSchedules ?? 0 }} Agenda</div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-4 col-xl-2">
                <a href="{{ url('/portal/inventory') }}" class="text-decoration-none">
                    <div class="card quick-card qc-danger h-100">
                        <div class="card-body p-3">
                            <div class="icon-wrapper icon-danger"><i class="bx bx-box"></i></div>
                            <div class="title">Inventory</div>
                            <div class="meta">{{ $totalMaterial ?? 0 }} Material</div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-4 col-xl-2">
                <a href="{{ url('/activities/kalibrasi') }}" class="text-decoration-none">
                    <div class="card quick-card qc-info h-100">
                        <div class="card-body p-3">
                            <div class="icon-wrapper icon-info"><i class="bx bx-wrench"></i></div>
                            <div class="title">Kalibrasi</div>
                            <div class="meta">{{ $totalKalibrasi ?? 0 }} Alat</div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-4 col-xl-2">
                <a href="{{ url('/portal/document') }}" class="text-decoration-none">
                    <div class="card quick-card qc-secondary h-100">
                        <div class="card-body p-3">
                            <div class="icon-wrapper icon-secondary"><i class="bx bx-file"></i></div>
                            <div class="title">Dokumen</div>
                            <div class="meta">{{ $totalDocuments ?? 0 }} File</div>
                        </div>
                    </div>
                </a>
            </div>
            @if (optional(Auth::user())->role === 'SUP')
                <div class="col-6 col-md-4 col-xl-2">
                    <a href="{{ route('users.index') }}" class="text-decoration-none">
                        <div class="card quick-card qc-success h-100">
                            <div class="card-body p-3">
                                <div class="icon-wrapper icon-success"><i class="bx bx-group"></i></div>
                                <div class="title">Users</div>
                                <div class="meta">{{ $totalUsers ?? 0 }} Aktif</div>
                            </div>
                        </div>
                    </a>
                </div>
            @endif
        </div>

        {{-- KPI STATS --}}
        <div class="section-title mt-4"><i class='bx bx-bar-chart-alt-2'></i> Metrik Sistem</div>
        <div class="row g-3 mb-4">
            <div class="col-12 col-sm-6 col-xl">
                <div class="kpi kpi-materials h-100">
                    <div class="kpi-head">
                        <div class="kpi-icon text-primary"><i class="bx bx-archive"></i></div>
                        <div>
                            <div class="kpi-value">{{ number_format($totalMaterial ?? 0) }}</div>
                            <div class="kpi-sub">Item Gudang</div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-auto">
                        <div class="stat-pill text-primary" style="background: var(--primary-light)"><i
                                class="bx bx-package"></i> Stock</div>
                        <div class="sparkline-wrapper"><canvas id="sparkMaterials"></canvas></div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-xl">
                <div class="kpi kpi-users h-100">
                    <div class="kpi-head">
                        <div class="kpi-icon text-success"><i class="bx bx-user-check"></i></div>
                        <div>
                            <div class="kpi-value">{{ number_format($totalUsers ?? 0) }}</div>
                            <div class="kpi-sub">User Aktif</div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-auto">
                        <div class="stat-pill text-success" style="background: var(--success-light)"><i
                                class="bx bx-check-shield"></i> Verified</div>
                        <div class="sparkline-wrapper"><canvas id="sparkUsers"></canvas></div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-xl">
                <div class="kpi kpi-schedules h-100">
                    <div class="kpi-head">
                        <div class="kpi-icon text-warning"><i class="bx bx-calendar-event"></i></div>
                        <div>
                            <div class="kpi-value">{{ number_format($totalSchedules ?? 0) }}</div>
                            <div class="kpi-sub">Jadwal Aktif</div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-auto">
                        <div class="stat-pill text-warning" style="background: var(--warning-light)"><i
                                class="bx bx-time-five"></i> Upcoming</div>
                        <div class="sparkline-wrapper"><canvas id="sparkSched"></canvas></div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-xl">
                <div class="kpi kpi-calibs h-100">
                    <div class="kpi-head">
                        <div class="kpi-icon text-info"><i class="bx bx-slider-alt"></i></div>
                        <div>
                            <div class="kpi-value">{{ number_format($totalKalibrasi ?? 0) }}</div>
                            <div class="kpi-sub">Total Kalibrasi</div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-auto">
                        <div class="stat-pill text-info" style="background: var(--info-light)"><i
                                class="bx bx-check-circle"></i> Selesai</div>
                        <div class="sparkline-wrapper"><canvas id="sparkCalib"></canvas></div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-xl">
                <div class="kpi kpi-docs h-100">
                    <div class="kpi-head">
                        <div class="kpi-icon text-secondary"><i class="bx bx-file-blank"></i></div>
                        <div>
                            <div class="kpi-value">{{ number_format($totalDocuments ?? 0) }}</div>
                            <div class="kpi-sub">Total Dokumen</div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-auto">
                        <div class="stat-pill text-secondary" style="background: var(--secondary-light)"><i
                                class="bx bx-cloud-upload"></i> Arsip</div>
                        <div class="sparkline-wrapper"><canvas id="sparkDocs"></canvas></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- TABLES & TIMELINE --}}
        <div class="row mt-4 g-4">

            {{-- 1. PROSES KALIBRASI AKTIF --}}
            <div class="col-12 col-xl-8">
                <div class="insight-card">
                    <div class="insight-header">
                        <h6>
                            <i class="bx bx-cog bx-spin text-info fs-5"></i>
                            Proses Kalibrasi Aktif
                        </h6>
                        <a href="{{ url('/activities/kalibrasi') }}" class="btn btn-sm fw-bold"
                            style="background: #f1f5f9; color: var(--text-main); border: 1px solid var(--border-color);">Lihat
                            Semua</a>
                    </div>

                    <div class="table-responsive">
                        <table class="table align-middle table-custom">
                            <thead>
                                <tr>
                                    <th class="ps-4" width="40%">Instrumen & No. Seri</th>
                                    <th width="30%">Mulai Proses</th>
                                    <th class="pe-4" width="30%">Progress</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($activeCalibrations ?? [] as $item)
                                    @php
                                        // Cek ketersediaan nilai progress, set default ke 50 jika tidak ada
                                        $progress = $item->progress ?? 50;

                                        $barColor = 'bg-primary';
                                        if ($progress < 40) {
                                            $barColor = 'bg-warning';
                                        } elseif ($progress > 80) {
                                            $barColor = 'bg-success';
                                        }
                                    @endphp
                                    <tr>
                                        <td class="ps-4">
                                            <div class="fw-bold" style="color: var(--text-main); font-size: 0.95rem;">
                                                {{ $item->nama_alat ?? 'Nama Alat' }}</div>
                                            <div
                                                style="font-family: monospace; color: var(--text-muted); font-size: 0.8rem;">
                                                SN: {{ $item->no_seri ?? '-' }}</div>
                                        </td>
                                        <td>
                                            <div class="fw-bold" style="color: var(--text-main); font-size: 0.85rem;">
                                                {{ \Carbon\Carbon::parse($item->tgl_mulai ?? $item->created_at)->format('d M Y') }}
                                            </div>
                                            <div style="color: var(--text-muted); font-size: 0.75rem;">
                                                {{ \Carbon\Carbon::parse($item->tgl_mulai ?? $item->created_at)->diffForHumans() }}
                                            </div>
                                        </td>
                                        <td class="pe-4">
                                            <div class="d-flex justify-content-end align-items-center mb-1">
                                                <span class="text-muted fw-bold"
                                                    style="font-size: 0.75rem;">{{ $progress }}%</span>
                                            </div>
                                            <div class="progress progress-sm">
                                                <div class="progress-bar {{ $barColor }}" role="progressbar"
                                                    style="width: {{ $progress }}%"
                                                    aria-valuenow="{{ $progress }}" aria-valuemin="0"
                                                    aria-valuemax="100"></div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-5">
                                            <div
                                                style="width: 60px; height: 60px; background: var(--bg-body); border-radius: 50%; display: flex; align-items:center; justify-content:center; margin: 0 auto 10px auto;">
                                                <i class="bx bx-check-shield fs-2 text-success"></i>
                                            </div>
                                            <div class="fw-bold text-main">Tidak Ada Proses Berjalan</div>
                                            <div style="font-size: 0.85rem;">Semua alat dalam kondisi siap pakai.</div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- 2. AKTIVITAS TERBARU (Real Data) --}}
            <div class="col-12 col-xl-4">
                <div class="insight-card">
                    <div class="insight-header">
                        <h6><i class="bx bx-pulse text-primary fs-5"></i> Aktivitas Terbaru</h6>
                    </div>

                    <ul class="timeline-wrapper">
                        {{-- Mengambil data asli dari $recentActivities Controller --}}
                        @forelse($recentActivities ?? [] as $activity)
                            @php
                                $tipe = $activity->tipe ?? 'system';
                                $iconMap = [
                                    'dokumen' => ['bg' => 'var(--info)', 'bx' => 'bx-file-blank'],
                                    'kalibrasi' => ['bg' => 'var(--warning)', 'bx' => 'bx-wrench'],
                                    'inventory' => ['bg' => 'var(--danger)', 'bx' => 'bx-package'],
                                    'system' => ['bg' => 'var(--success)', 'bx' => 'bx-check-shield'],
                                ];

                                $cfg = $iconMap[$tipe] ?? $iconMap['system'];

                                // Handling relasi user secara aman
                                $userName = 'System';
                                if (isset($activity->user) && isset($activity->user->name)) {
                                    $userName = $activity->user->name;
                                }
                            @endphp

                            <li class="timeline-item">
                                <div class="timeline-icon" style="background-color: {{ $cfg['bg'] }};">
                                    <i class="bx {{ $cfg['bx'] }}"></i>
                                </div>
                                <div class="timeline-content">
                                    <div class="fw-bold"
                                        style="color: var(--text-main); font-size: 0.9rem; line-height: 1.2; margin-bottom: 4px;">
                                        {{ $activity->judul ?? 'Aktivitas Tercatat' }}
                                    </div>
                                    <div style="color: var(--text-muted); font-size: 0.8rem; margin-bottom: 6px;">
                                        {!! $activity->deskripsi ?? 'Tidak ada detail spesifik.' !!}
                                    </div>
                                    <div class="d-flex align-items-center gap-2"
                                        style="font-size: 0.7rem; color: var(--text-muted); font-weight: 600;">
                                        <span
                                            style="background: var(--border-color); padding: 2px 6px; border-radius: 4px;"><i
                                                class="bx bx-user"></i> {{ $userName }}</span>
                                        <span><i class="bx bx-time-five"></i>
                                            {{ isset($activity->created_at) ? \Carbon\Carbon::parse($activity->created_at)->diffForHumans() : 'Baru saja' }}</span>
                                    </div>
                                </div>
                            </li>
                        @empty
                            <li class="text-center text-muted py-4 border-0" style="list-style: none;">
                                <i class="bx bx-ghost fs-2 mb-2"></i><br>
                                Belum ada catatan aktivitas terbaru.
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @php
        // Deklarasi data PHP murni agar aman dilempar ke JS
        $dataSparkA = $sparkA ?? [3, 5, 4, 6, 5, 7, 6];
        $dataSparkB = $sparkB ?? [2, 4, 3, 5, 4, 3, 4];
    @endphp

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Sparkline Chart Generator
            function spark(elId, data = [], color = '#3b82f6') {
                const el = document.getElementById(elId);
                if (!el) return;

                // Create minimal gradient
                const ctx = el.getContext('2d');
                let gradient = ctx.createLinearGradient(0, 0, 0, 35);
                gradient.addColorStop(0, color + '40'); // 25% opacity
                gradient.addColorStop(1, color + '00'); // 0% opacity

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: data.map((_, i) => i + 1),
                        datasets: [{
                            data: data,
                            borderColor: color,
                            backgroundColor: gradient,
                            fill: true,
                            tension: 0.4,
                            borderWidth: 2.5,
                            pointRadius: 0,
                            pointHoverRadius: 0
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
                                enabled: false
                            }
                        },
                        scales: {
                            x: {
                                display: false
                            },
                            y: {
                                display: false,
                                min: Math.min(...data) - 1,
                                max: Math.max(...data) + 1
                            }
                        },
                        interaction: {
                            mode: 'none'
                        }
                    }
                });
            }

            const sparkDataA = @json($dataSparkA);
            const sparkDataB = @json($dataSparkB);

            // Render Charts based on specific colors
            spark('sparkMaterials', sparkDataA, '#3b82f6'); // primary
            spark('sparkUsers', sparkDataB, '#10b981'); // success
            spark('sparkSched', sparkDataA, '#f59e0b'); // warning
            spark('sparkCalib', sparkDataB, '#0ea5e9'); // info
            spark('sparkDocs', sparkDataA, '#8b5cf6'); // secondary
        });
    </script>
@endpush

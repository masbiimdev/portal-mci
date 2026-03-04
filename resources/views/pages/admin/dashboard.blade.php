@extends('layouts.admin')
@section('title', 'Dashboard | Main')

@push('css')
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <style>
        :root {
            --bg-card: #ffffff;
            --muted: #6b7280;
            --accent: #5166ff;
            --success: #22c55e;
            --danger: #ef4444;
            --radius: 14px;
            --shadow-card: 0 12px 32px rgba(16, 24, 40, 0.11);
        }

        .container-xxl {
            padding-top: 1.25rem;
            padding-bottom: 1.25rem;
        }

        /* Dashboard Header - Perbaikan */
        .dashboard-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 1.75rem;
            background: linear-gradient(90deg, #f3f4fe 0, #e3e6ff 100%);
            border-radius: var(--radius);
            box-shadow: var(--shadow-card);
            padding: 1.5rem 2rem;
        }

        .greeting {
            display: flex;
            flex-direction: column;
            gap: 0.15rem;
        }

        .greeting h4 {
            margin: 0;
            font-size: 1.35rem;
            color: #2d3a71;
            font-weight: 700;
        }

        .greeting .sub {
            color: var(--muted);
            font-size: 0.95rem;
        }

        /* User Avatar Inovasi - Pop-up Hover */
        .user-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(81, 102, 255, 0.18);
            border: 2px solid #e0e7ff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 1.2rem;
            background: linear-gradient(135deg, #eff6ff, #e0e7ff);
            position: relative;
            cursor: pointer;
            transition: all 0.3s;
        }

        .user-avatar:hover {
            box-shadow: 0 8px 24px rgba(81, 102, 255, 0.25);
            transform: scale(1.08);
        }

        .user-popup-info {
            display: none;
            position: absolute;
            top: 56px;
            right: 0;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 10px 28px rgba(81, 102, 255, 0.19);
            padding: 1rem;
            min-width: 160px;
            z-index: 1000;
            text-align: left;
            border: 1px solid #e0e7ff;
        }

        .user-avatar:hover .user-popup-info {
            display: block;
            animation: slideDown 0.2s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-8px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .user-popup-info b {
            color: #2d3a71;
            display: block;
            margin-bottom: 4px;
        }

        .user-popup-info .role {
            font-size: 0.85rem;
            color: var(--muted);
        }

        /* Download Summary Button */
        .dashboard-download-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: linear-gradient(90deg, #5166ff, #889eff);
            color: #fff;
            border-radius: 10px;
            padding: 0.6rem 1.2rem;
            font-size: 0.95rem;
            font-weight: 600;
            border: none;
            box-shadow: 0 4px 12px rgba(81, 102, 255, 0.15);
            cursor: pointer;
            transition: all 0.2s;
            margin-bottom: 0.8rem;
        }

        .dashboard-download-btn:hover {
            background: linear-gradient(90deg, #3956d2, #5166ff);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(81, 102, 255, 0.22);
        }

        .dashboard-download-btn:active {
            transform: translateY(0);
        }

        /* Quick Card - Perbaikan & Inovasi */
        .quick-card {
            border-radius: var(--radius);
            transition: all 0.18s cubic-bezier(0.4, 0, 0.2, 1);
            background: linear-gradient(180deg, var(--bg-card), #f7fafe 95%);
            min-height: 120px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: var(--shadow-card);
            border: 1px solid rgba(241, 245, 249, 0.8);
            position: relative;
            overflow: hidden;
        }

        .quick-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.6s;
        }

        .quick-card:hover::before {
            left: 100%;
        }

        .quick-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 16px 40px rgba(81, 102, 255, 0.16);
            border-color: #e0e7ff;
        }

        .quick-card .icon {
            width: 64px;
            height: 64px;
            border-radius: 14px;
            font-size: 1.8rem;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, rgba(81, 102, 255, 0.12), rgba(34, 197, 94, 0.08)),
                linear-gradient(180deg, rgba(255, 255, 255, 0.4), transparent);
            margin-bottom: 0.5rem;
        }

        .quick-card .title {
            margin-top: 0.5rem;
            font-weight: 700;
            font-size: 1.05rem;
            color: #2d3a71;
        }

        .quick-card .meta {
            color: var(--muted);
            font-size: 0.82rem;
            margin-top: 0.2rem;
        }

        /* KPI Tiles - Perbaikan */
        .kpi {
            border-radius: 12px;
            padding: 1.2rem;
            background: linear-gradient(180deg, #fff, #f3f4fe 88%);
            box-shadow: var(--shadow-card);
            border: 1px solid rgba(241, 245, 249, 0.8);
            position: relative;
            overflow: hidden;
        }

        .kpi::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100px;
            height: 100px;
            background: radial-gradient(circle, rgba(81, 102, 255, 0.05), transparent);
            border-radius: 50%;
        }

        .kpi .kpi-head {
            display: flex;
            align-items: center;
            gap: 15px;
            position: relative;
            z-index: 1;
        }

        .kpi .kpi-icon {
            width: 56px;
            height: 56px;
            border-radius: 12px;
            font-size: 1.35rem;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .kpi .kpi-value {
            font-weight: 700;
            font-size: 1.45rem;
            color: #2d3a71;
        }

        .kpi .kpi-sub {
            color: var(--muted);
            font-size: 0.92rem;
            margin-top: 2px;
        }

        /* Statistics badges */
        .stat-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 0.35rem 0.75rem;
            border-radius: 999px;
            font-weight: 600;
            font-size: 0.8rem;
            background: #f1f5f9;
            color: #0f172a;
        }

        /* Responsive */
        @media (max-width: 767px) {
            .dashboard-header {
                padding: 1rem;
                flex-direction: column;
                text-align: center;
            }

            .greeting h4 {
                font-size: 1.15rem;
            }

            .quick-card {
                min-height: 100px;
            }

            .kpi {
                padding: 1rem;
            }

            .kpi .kpi-value {
                font-size: 1.2rem;
            }

            .dashboard-download-btn {
                font-size: 0.9rem;
                padding: 0.5rem 1rem;
            }
        }
    </style>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Dashboard Header dengan Download Button & User Avatar -->
        <div class="dashboard-header">
            <div class="greeting">
                <h4 class="fw-bold">🏠 Dashboard</h4>
                <div class="sub small-muted">
                    Selamat datang{{ Auth::user() ? ', ' . Auth::user()->name : '' }} — 
                    {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                </div>
            </div>

            <div class="d-flex align-items-center gap-3">
                {{-- <button class="dashboard-download-btn" onclick="window.print()" title="Download Summary">
                    <i class="bx bx-download"></i> Ringkasan
                </button> --}}

                
            </div>
        </div>

        <!-- QUICK ACCESS MENU -->
        <div class="row g-3">
            <!-- Pengumuman -->
            <div class="col-6 col-md-4 col-lg-2">
                <a href="{{ route('announcements.index') }}" class="text-decoration-none">
                    <div class="card quick-card h-100">
                        <div class="card-body d-flex flex-column align-items-center justify-content-center w-100">
                            <div class="icon bg-warning text-white"><i class="bx bx-news"></i></div>
                            <div class="title">Pengumuman</div>
                            <div class="meta">{{ $totalAnnon ?? 0 }} item</div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Schedule -->
            <div class="col-6 col-md-4 col-lg-2">
                <a href="{{ url('/activities/witness') }}" class="text-decoration-none">
                    <div class="card quick-card h-100">
                        <div class="card-body d-flex flex-column align-items-center justify-content-center w-100">
                            <div class="icon bg-primary text-white"><i class="bx bx-calendar"></i></div>
                            <div class="title">Schedule</div>
                            <div class="meta">{{ $totalSchedules ?? 0 }} jadwal</div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Inventory -->
            <div class="col-6 col-md-4 col-lg-2">
                <a href="{{ url('/portal/inventory') }}" class="text-decoration-none">
                    <div class="card quick-card h-100">
                        <div class="card-body d-flex flex-column align-items-center justify-content-center w-100">
                            <div class="icon bg-danger text-white"><i class="bx bx-box"></i></div>
                            <div class="title">Inventory</div>
                            <div class="meta">{{ $totalMaterial ?? 0 }} material</div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- INOVASI BARU: Kalibrasi -->
            <div class="col-6 col-md-4 col-lg-2">
                <a href="{{ url('/activities/kalibrasi') }}" class="text-decoration-none">
                    <div class="card quick-card h-100">
                        <div class="card-body d-flex flex-column align-items-center justify-content-center w-100">
                            <div class="icon bg-info text-white"><i class="bx bx-wrench"></i></div>
                            <div class="title">Kalibrasi</div>
                            <div class="meta">{{ $totalCalibrations ?? 0 }} alat</div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- INOVASI BARU: Document -->
            <div class="col-6 col-md-4 col-lg-2">
                <a href="{{ url('/portal/document') }}" class="text-decoration-none">
                    <div class="card quick-card h-100">
                        <div class="card-body d-flex flex-column align-items-center justify-content-center w-100">
                            <div class="icon bg-secondary text-white"><i class="bx bx-file"></i></div>
                            <div class="title">Dokumen</div>
                            <div class="meta">{{ $totalDocuments ?? 0 }} file</div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Users (Admin Only) -->
            @if (Auth::user()->role === 'SUP')
                <div class="col-6 col-md-4 col-lg-2">
                    <a href="{{ route('users.index') }}" class="text-decoration-none">
                        <div class="card quick-card h-100">
                            <div class="card-body d-flex flex-column align-items-center justify-content-center w-100">
                                <div class="icon bg-success text-white"><i class="bx bx-user"></i></div>
                                <div class="title">Users</div>
                                <div class="meta">{{ $totalUsers ?? 0 }} aktif</div>
                            </div>
                        </div>
                    </a>
                </div>
            @endif
        </div>

        <!-- KPI TILES -->
        <div class="row mt-4 g-3">
            <div class="col-6 col-md-4 col-lg-3">
                <div class="kpi p-3 h-100">
                    <div class="kpi-head">
                        <div class="kpi-icon bg-light text-primary"><i class="bx bx-archive"></i></div>
                        <div>
                            <div class="kpi-value">{{ $totalMaterial ?? '0' }}</div>
                            <div class="kpi-sub">Total Material</div>
                        </div>
                    </div>
                    <div class="mt-3 d-flex justify-content-between align-items-center">
                        <div class="stat-pill"><i class="bx bx-up-arrow text-success"></i> Active</div>
                        <canvas id="sparkMaterials" width="90" height="30"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-4 col-lg-3">
                <div class="kpi p-3 h-100">
                    <div class="kpi-head">
                        <div class="kpi-icon bg-light text-success"><i class="bx bx-user-check"></i></div>
                        <div>
                            <div class="kpi-value">{{ $totalUsers ?? '0' }}</div>
                            <div class="kpi-sub">User Aktif</div>
                        </div>
                    </div>
                    <div class="mt-3 d-flex justify-content-between align-items-center">
                        <div class="stat-pill"><i class="bx bx-check-double text-success"></i> Verified</div>
                        <canvas id="sparkUsers" width="90" height="30"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-4 col-lg-3">
                <div class="kpi p-3 h-100">
                    <div class="kpi-head">
                        <div class="kpi-icon bg-light text-warning"><i class="bx bx-calendar-event"></i></div>
                        <div>
                            <div class="kpi-value">{{ $totalSchedules ?? '0' }}</div>
                            <div class="kpi-sub">Total Jadwal</div>
                        </div>
                    </div>
                    <div class="mt-3 d-flex justify-content-between align-items-center">
                        <div class="stat-pill"><i class="bx bx-time-five text-warning"></i> Upcoming</div>
                        <canvas id="sparkSched" width="90" height="30"></canvas>
                    </div>
                </div>
            </div>

            <!-- INOVASI BARU: KPI Kalibrasi -->
            <div class="col-6 col-md-4 col-lg-3">
                <div class="kpi p-3 h-100">
                    <div class="kpi-head">
                        <div class="kpi-icon bg-light text-info"><i class="bx bx-wrench"></i></div>
                        <div>
                            <div class="kpi-value">{{ $totalCalibrations ?? '0' }}</div>
                            <div class="kpi-sub">Total Kalibrasi</div>
                        </div>
                    </div>
                    <div class="mt-3 d-flex justify-content-between align-items-center">
                        <div class="stat-pill"><i class="bx bx-check text-info"></i> Selesai</div>
                        <canvas id="sparkCalib" width="90" height="30"></canvas>
                    </div>
                </div>
            </div>

            <!-- INOVASI BARU: KPI Document -->
            <div class="col-6 col-md-4 col-lg-3">
                <div class="kpi p-3 h-100">
                    <div class="kpi-head">
                        <div class="kpi-icon bg-light text-secondary"><i class="bx bx-file-blank"></i></div>
                        <div>
                            <div class="kpi-value">{{ $totalDocuments ?? '0' }}</div>
                            <div class="kpi-sub">Total Dokumen</div>
                        </div>
                    </div>
                    <div class="mt-3 d-flex justify-content-between align-items-center">
                        <div class="stat-pill"><i class="bx bx-archive text-secondary"></i> Arsip</div>
                        <canvas id="sparkDocs" width="90" height="30"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Sparkline Chart Generator
            function spark(elId, data = [], color = 'rgba(81,102,255,0.9)') {
                const el = document.getElementById(elId);
                if (!el) return;

                new Chart(el.getContext('2d'), {
                    type: 'line',
                    data: {
                        labels: data.map((_, i) => i + 1),
                        datasets: [{
                            data: data,
                            borderColor: color,
                            backgroundColor: 'transparent',
                            tension: 0.35,
                            borderWidth: 1.8,
                            pointRadius: 0,
                            fill: false
                        }]
                    },
                    options: {
                        responsive: false,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: { enabled: false }
                        },
                        scales: {
                            x: { display: false },
                            y: { display: false }
                        }
                    }
                });
            }

            // Initialize Sparklines
            spark('sparkMaterials', {!! json_encode($sparkA ?? [3, 5, 4, 6, 5, 7, 6]) !!}, 'rgba(81,102,255,0.9)');
            spark('sparkUsers', {!! json_encode($sparkB ?? [2, 4, 3, 5, 4, 3, 4]) !!}, 'rgba(16,185,129,0.9)');
            spark('sparkSched', {!! json_encode($sparkA ?? [3, 5, 4, 6, 5, 7, 6]) !!}, 'rgba(250,184,60,0.9)');
            spark('sparkCalib', {!! json_encode($sparkB ?? [2, 4, 3, 5, 4, 3, 4]) !!}, 'rgba(6,182,212,0.9)');
            spark('sparkDocs', {!! json_encode($sparkA ?? [3, 5, 4, 6, 5, 7, 6]) !!}, 'rgba(108,99,255,0.85)');
        });
    </script>
@endpush
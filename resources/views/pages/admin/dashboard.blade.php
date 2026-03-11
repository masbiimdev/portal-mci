@extends('layouts.admin')
@section('title', 'Dashboard | Main')

@push('css')
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <style>
        :root {
            --bg-body: #f8fafc;
            --bg-card: #ffffff;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --primary: #4f46e5;
            --primary-light: #e0e7ff;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #0ea5e9;
            --secondary: #8b5cf6;
            --radius-lg: 16px;
            --radius-md: 12px;
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.05), 0 1px 2px rgba(0, 0, 0, 0.025);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            --shadow-hover: 0 10px 25px -5px rgba(0, 0, 0, 0.08), 0 8px 10px -6px rgba(0, 0, 0, 0.04);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .container-xxl {
            padding-top: 1.5rem;
            padding-bottom: 1.5rem;
        }

        /* ============== DASHBOARD HEADER ============== */
        .dashboard-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1.5rem;
            margin-bottom: 2rem;
            background: linear-gradient(135deg, #ffffff 0%, #f1f5f9 100%);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            padding: 1.75rem 2rem;
            border: 1px solid rgba(226, 232, 240, 0.8);
            position: relative;
            overflow: hidden;
        }

        .dashboard-header::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 300px;
            height: 100%;
            background: radial-gradient(circle at top right, var(--primary-light), transparent 70%);
            opacity: 0.6;
            pointer-events: none;
        }

        .greeting {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
            position: relative;
            z-index: 1;
        }

        .greeting h4 {
            margin: 0;
            font-size: 1.4rem;
            color: var(--text-main);
            font-weight: 800;
            letter-spacing: -0.01em;
        }

        .greeting .sub {
            color: var(--text-muted);
            font-size: 0.95rem;
            font-weight: 500;
        }

        /* ============== QUICK ACCESS CARDS ============== */
        .quick-card {
            border-radius: var(--radius-md);
            transition: var(--transition);
            background: var(--bg-card);
            min-height: 125px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: var(--shadow-sm);
            border: 1px solid rgba(226, 232, 240, 0.8);
            position: relative;
            overflow: hidden;
            text-align: center;
        }

        .quick-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-hover);
            border-color: var(--primary-light);
        }

        .quick-card .icon-wrapper {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            font-size: 1.6rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 0.75rem;
            transition: var(--transition);
        }

        .quick-card:hover .icon-wrapper {
            transform: scale(1.1);
        }

        .quick-card .title {
            font-weight: 700;
            font-size: 1rem;
            color: var(--text-main);
        }

        .quick-card .meta {
            color: var(--text-muted);
            font-size: 0.8rem;
            font-weight: 500;
            margin-top: 0.2rem;
        }

        .icon-warning {
            background: #fef3c7;
            color: #d97706;
        }

        .icon-primary {
            background: #e0e7ff;
            color: #4338ca;
        }

        .icon-danger {
            background: #fee2e2;
            color: #b91c1c;
        }

        .icon-info {
            background: #e0f2fe;
            color: #0369a1;
        }

        .icon-secondary {
            background: #f3e8ff;
            color: #7e22ce;
        }

        .icon-success {
            background: #dcfce7;
            color: #15803d;
        }

        /* ============== KPI TILES ============== */
        .kpi {
            border-radius: var(--radius-md);
            padding: 1.25rem;
            background: var(--bg-card);
            box-shadow: var(--shadow-sm);
            border: 1px solid rgba(226, 232, 240, 0.8);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: var(--transition);
        }

        .kpi:hover {
            box-shadow: var(--shadow-md);
        }

        .kpi .kpi-head {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .kpi .kpi-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            font-size: 1.4rem;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8fafc;
        }

        .kpi .kpi-value {
            font-weight: 800;
            font-size: 1.5rem;
            color: var(--text-main);
            line-height: 1.1;
        }

        .kpi .kpi-sub {
            color: var(--text-muted);
            font-size: 0.85rem;
            font-weight: 500;
            margin-top: 4px;
        }

        .stat-pill {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 0.25rem 0.6rem;
            border-radius: 999px;
            font-weight: 700;
            font-size: 0.75rem;
            background: #f1f5f9;
            color: var(--text-main);
        }

        .sparkline-wrapper {
            height: 35px;
            width: 90px;
        }

        /* ============== ACTIONABLE INSIGHTS (TABLE & TIMELINE) ============== */
        .insight-card {
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            border: 1px solid rgba(226, 232, 240, 0.8);
            background: var(--bg-card);
            height: 100%;
        }

        .insight-header {
            background: var(--bg-card);
            border-bottom: 1px solid #f1f5f9;
            padding: 1.25rem 1.5rem;
            border-radius: var(--radius-lg) var(--radius-lg) 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .insight-header h6 {
            margin: 0;
            font-weight: 800;
            color: var(--text-main);
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .table-custom th {
            background: #f8fafc;
            color: var(--text-muted);
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid #f1f5f9;
            padding: 1rem;
        }

        .table-custom td {
            padding: 1rem;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
        }

        .table-custom tr:last-child td {
            border-bottom: none;
        }

        /* Timeline Styles */
        .timeline-wrapper {
            position: relative;
            padding: 1.5rem;
            margin: 0;
            list-style: none;
        }

        .timeline-wrapper::before {
            content: '';
            position: absolute;
            left: 2.3rem;
            top: 1.5rem;
            bottom: 1.5rem;
            width: 2px;
            background: #e2e8f0;
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
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: 3px solid #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 0 0 1px #e2e8f0;
            color: #fff;
            flex-shrink: 0;
            margin-right: 1rem;
        }

        /* ============== RESPONSIVE ============== */
        @media (max-width: 768px) {
            .dashboard-header {
                padding: 1.25rem;
                flex-direction: column;
                text-align: center;
            }

            .dashboard-header::after {
                display: none;
            }

            .greeting h4 {
                font-size: 1.25rem;
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

        <div class="dashboard-header">
            <div class="greeting">
                <h4>👋 Halo, {{ optional(Auth::user())->name ?? 'Admin' }}!</h4>
                <div class="sub">
                    Berikut adalah ringkasan operasional pada
                    <span class="fw-bold">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>.
                </div>
            </div>
        </div>

        <h6 class="text-muted fw-bold mb-3 text-uppercase" style="font-size: 0.8rem; letter-spacing: 0.5px;">Akses Cepat</h6>
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-4 col-xl-2">
                <a href="{{ route('announcements.index') }}" class="text-decoration-none">
                    <div class="card quick-card h-100">
                        <div class="card-body p-3">
                            <div class="icon-wrapper icon-warning"><i class="bx bx-news"></i></div>
                            <div class="title">Pengumuman</div>
                            <div class="meta">{{ $totalAnnon ?? 0 }} item</div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-4 col-xl-2">
                <a href="{{ url('/activities/witness') }}" class="text-decoration-none">
                    <div class="card quick-card h-100">
                        <div class="card-body p-3">
                            <div class="icon-wrapper icon-primary"><i class="bx bx-calendar"></i></div>
                            <div class="title">Schedule</div>
                            <div class="meta">{{ $totalSchedules ?? 0 }} jadwal</div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-4 col-xl-2">
                <a href="{{ url('/portal/inventory') }}" class="text-decoration-none">
                    <div class="card quick-card h-100">
                        <div class="card-body p-3">
                            <div class="icon-wrapper icon-danger"><i class="bx bx-box"></i></div>
                            <div class="title">Inventory</div>
                            <div class="meta">{{ $totalMaterial ?? 0 }} material</div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-4 col-xl-2">
                <a href="{{ url('/activities/kalibrasi') }}" class="text-decoration-none">
                    <div class="card quick-card h-100">
                        <div class="card-body p-3">
                            <div class="icon-wrapper icon-info"><i class="bx bx-wrench"></i></div>
                            <div class="title">Kalibrasi</div>
                            <div class="meta">{{ $totalKalibrasi ?? 0 }} alat</div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-4 col-xl-2">
                <a href="{{ url('/portal/document') }}" class="text-decoration-none">
                    <div class="card quick-card h-100">
                        <div class="card-body p-3">
                            <div class="icon-wrapper icon-secondary"><i class="bx bx-file"></i></div>
                            <div class="title">Dokumen</div>
                            <div class="meta">{{ $totalDocuments ?? 0 }} file</div>
                        </div>
                    </div>
                </a>
            </div>
            @if (optional(Auth::user())->role === 'SUP')
                <div class="col-6 col-md-4 col-xl-2">
                    <a href="{{ route('users.index') }}" class="text-decoration-none">
                        <div class="card quick-card h-100">
                            <div class="card-body p-3">
                                <div class="icon-wrapper icon-success"><i class="bx bx-group"></i></div>
                                <div class="title">Users</div>
                                <div class="meta">{{ $totalUsers ?? 0 }} aktif</div>
                            </div>
                        </div>
                    </a>
                </div>
            @endif
        </div>

        <h6 class="text-muted fw-bold mb-3 mt-2 text-uppercase" style="font-size: 0.8rem; letter-spacing: 0.5px;">Statistik
            Sistem</h6>
        <div class="row g-3">
            <div class="col-12 col-sm-6 col-xl">
                <div class="kpi h-100">
                    <div class="kpi-head">
                        <div class="kpi-icon text-primary"><i class="bx bx-archive"></i></div>
                        <div>
                            <div class="kpi-value">{{ $totalMaterial ?? '0' }}</div>
                            <div class="kpi-sub">Total Material</div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-auto">
                        <div class="stat-pill text-success bg-success-subtle"><i class="bx bx-up-arrow-alt"></i> Active
                        </div>
                        <div class="sparkline-wrapper"><canvas id="sparkMaterials"></canvas></div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-xl">
                <div class="kpi h-100">
                    <div class="kpi-head">
                        <div class="kpi-icon text-success"><i class="bx bx-user-check"></i></div>
                        <div>
                            <div class="kpi-value">{{ $totalUsers ?? '0' }}</div>
                            <div class="kpi-sub">User Aktif</div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-auto">
                        <div class="stat-pill text-success bg-success-subtle"><i class="bx bx-check-double"></i> Verified
                        </div>
                        <div class="sparkline-wrapper"><canvas id="sparkUsers"></canvas></div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-xl">
                <div class="kpi h-100">
                    <div class="kpi-head">
                        <div class="kpi-icon text-warning"><i class="bx bx-calendar-event"></i></div>
                        <div>
                            <div class="kpi-value">{{ $totalSchedules ?? '0' }}</div>
                            <div class="kpi-sub">Total Jadwal</div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-auto">
                        <div class="stat-pill text-warning bg-warning-subtle"><i class="bx bx-time-five"></i> Upcoming
                        </div>
                        <div class="sparkline-wrapper"><canvas id="sparkSched"></canvas></div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-xl">
                <div class="kpi h-100">
                    <div class="kpi-head">
                        <div class="kpi-icon text-info"><i class="bx bx-wrench"></i></div>
                        <div>
                            <div class="kpi-value">{{ $totalKalibrasi ?? '0' }}</div>
                            <div class="kpi-sub">Total Kalibrasi</div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-auto">
                        <div class="stat-pill text-info bg-info-subtle"><i class="bx bx-check"></i> Selesai</div>
                        <div class="sparkline-wrapper"><canvas id="sparkCalib"></canvas></div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-xl">
                <div class="kpi h-100">
                    <div class="kpi-head">
                        <div class="kpi-icon text-secondary"><i class="bx bx-file-blank"></i></div>
                        <div>
                            <div class="kpi-value">{{ $totalDocuments ?? '0' }}</div>
                            <div class="kpi-sub">Total Dokumen</div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-auto">
                        <div class="stat-pill text-secondary bg-secondary-subtle"><i class="bx bx-archive"></i> Arsip
                        </div>
                        <div class="sparkline-wrapper"><canvas id="sparkDocs"></canvas></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4 g-4">

            <div class="col-12 col-xl-8">
                <div class="insight-card">
                    <div class="insight-header">
                        <h6><i class="bx bx-error-circle text-warning fs-5"></i> Kalibrasi Mendesak</h6>
                        <a href="{{ url('/activities/kalibrasi') }}" class="btn btn-sm text-primary fw-bold"
                            style="background: var(--primary-light); border-radius: 8px;">Lihat Semua</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 table-custom">
                            <thead>
                                <tr>
                                    <th class="ps-4">Nama Alat</th>
                                    <th>No. Seri</th>
                                    <th>Jatuh Tempo</th>
                                    <th>Status</th>
                                    <th class="pe-4 text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($dueCalibrations ?? [] as $item)
                                    @php
                                        // Menghitung sisa hari secara dinamis
                                        $tglUlang = \Carbon\Carbon::parse($item->tgl_kalibrasi_ulang);
                                        $sisaHari = \Carbon\Carbon::now()->diffInDays($tglUlang, false);

                                        // Menentukan warna badge
                                        $badgeColor =
                                            $sisaHari <= 7
                                                ? 'bg-danger-subtle text-danger'
                                                : 'bg-warning-subtle text-warning';

                                        // Teks sisa hari
                                        $teksHari =
                                            $sisaHari < 0
                                                ? 'Terlewat'
                                                : ($sisaHari == 0
                                                    ? 'Hari Ini'
                                                    : $sisaHari . ' Hari');
                                    @endphp
                                    <tr>
                                        <td class="ps-4 fw-bold" style="color: var(--text-main);">{{ $item->nama_alat }}
                                        </td>
                                        <td style="font-family: monospace; color: var(--text-muted);">
                                            {{ $item->no_seri ?? '-' }}</td>
                                        <td>
                                            <span class="badge {{ $badgeColor }} p-2 rounded-2 fw-bold">
                                                {{ $tglUlang->format('d M Y') }} ({{ $teksHari }})
                                            </span>
                                        </td>
                                        <td>
                                            <span
                                                class="badge bg-secondary rounded-2">{{ $item->status_kalibrasi ?? 'Menunggu' }}</span>
                                        </td>
                                        <td class="pe-4 text-end">
                                            <a href="{{ url('/activities/kalibrasi/proses/' . $item->id) }}"
                                                class="btn btn-sm btn-light border shadow-sm rounded-2">
                                                <i class="bx bx-check-shield"></i> Proses
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-5">
                                            <i class="bx bx-check-circle fs-2 text-success mb-2"></i><br>
                                            Tidak ada jadwal kalibrasi mendesak dalam 30 hari ke depan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-12 col-xl-4">
                <div class="insight-card">
                    <div class="insight-header">
                        <h6><i class="bx bx-history text-primary fs-5"></i> Aktivitas Terbaru</h6>
                    </div>
                    <ul class="timeline-wrapper">
                        @forelse($recentActivities ?? [] as $activity)
                            @php
                                // Dinamis Icon berdasarkan tipe aktivitas (Sesuaikan field tipe di DB Anda)
                                $icon = 'bx-info-circle';
                                $bgClass = 'bg-primary';

                                if (isset($activity->tipe)) {
                                    if ($activity->tipe == 'dokumen') {
                                        $icon = 'bx-file';
                                        $bgClass = 'bg-success';
                                    } elseif ($activity->tipe == 'kalibrasi') {
                                        $icon = 'bx-wrench';
                                        $bgClass = 'bg-info';
                                    } elseif ($activity->tipe == 'inventory') {
                                        $icon = 'bx-box';
                                        $bgClass = 'bg-danger';
                                    }
                                }
                            @endphp
                            <li class="timeline-item">
                                <div class="timeline-icon {{ $bgClass }}"><i class="bx {{ $icon }}"></i>
                                </div>
                                <div>
                                    <div class="fw-bold" style="color: var(--text-main); font-size: 0.95rem;">
                                        {{ $activity->judul ?? 'Pembaruan Sistem' }}
                                    </div>
                                    <div class="text-muted mb-1" style="font-size: 0.85rem;">
                                        <span class="fw-bold">{{ optional($activity->user)->name ?? 'User' }}</span>
                                        {!! $activity->deskripsi ?? 'Melakukan aktivitas pada sistem.' !!}
                                    </div>
                                    <div class="text-muted" style="font-size: 0.75rem;">
                                        <i class="bx bx-time-five me-1"></i>
                                        {{ isset($activity->created_at) ? $activity->created_at->diffForHumans() : 'Baru saja' }}
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
            // Sparkline Generator
            function spark(elId, data = [], color = '#4f46e5') {
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
                            tension: 0.4,
                            borderWidth: 2,
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

            // Parsing data ke format JSON secara aman
            const sparkDataA = @json($dataSparkA);
            const sparkDataB = @json($dataSparkB);

            // Render Charts
            spark('sparkMaterials', sparkDataA, '#4f46e5');
            spark('sparkUsers', sparkDataB, '#10b981');
            spark('sparkSched', sparkDataA, '#f59e0b');
            spark('sparkCalib', sparkDataB, '#0ea5e9');
            spark('sparkDocs', sparkDataA, '#8b5cf6');
        });
    </script>
@endpush

@extends('layouts.admin')
@section('title', 'Dashboard NCR Log')

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        /* --- GLOBAL BENTO VARIABLES --- */
        :root {
            --bento-bg: #f4f7fb;
            --bento-surface: #ffffff;
            --bento-radius: 20px;
            --bento-shadow: 0 4px 20px rgba(15, 23, 42, 0.03);
            --bento-shadow-hover: 0 10px 30px rgba(15, 23, 42, 0.08);
            --bento-border: 1px solid rgba(226, 232, 240, 0.8);

            --brand-primary: #4f46e5;
            --brand-danger: #ef4444;
            --brand-warning: #f59e0b;
            --brand-success: #10b981;

            --text-dark: #0f172a;
            --text-main: #334155;
            --text-muted: #64748b;
        }

        body {
            background-color: var(--bento-bg);
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--text-main);
        }

        /* --- BENTO GRID SYSTEM --- */
        .bento-grid {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .bento-box {
            background: var(--bento-surface);
            border-radius: var(--bento-radius);
            box-shadow: var(--bento-shadow);
            border: var(--bento-border);
            padding: 1.5rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .bento-box:hover {
            transform: translateY(-4px);
            box-shadow: var(--bento-shadow-hover);
        }

        .bento-span-12 {
            grid-column: span 12;
        }

        .bento-span-8 {
            grid-column: span 8;
        }

        .bento-span-7 {
            grid-column: span 7;
        }

        .bento-span-5 {
            grid-column: span 5;
        }

        .bento-span-4 {
            grid-column: span 4;
        }

        .bento-span-3 {
            grid-column: span 3;
        }

        @media (max-width: 992px) {

            .bento-span-8,
            .bento-span-7,
            .bento-span-5,
            .bento-span-4,
            .bento-span-3 {
                grid-column: span 6;
            }
        }

        @media (max-width: 576px) {

            .bento-span-8,
            .bento-span-7,
            .bento-span-5,
            .bento-span-4,
            .bento-span-3 {
                grid-column: span 12;
            }
        }

        /* --- HEADER BENTO --- */
        .bento-header {
            padding-bottom: 1rem;
            margin-bottom: 1rem;
            border-bottom: 1px dashed var(--bento-border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .bento-title {
            font-size: 1rem;
            font-weight: 800;
            color: var(--text-dark);
            margin: 0;
        }

        .bento-subtitle {
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--text-muted);
        }

        /* --- KPI STATS --- */
        .stat-wrapper {
            display: flex;
            align-items: center;
            gap: 1.25rem;
        }

        .stat-icon {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 800;
            color: var(--text-dark);
            line-height: 1.2;
        }

        .stat-label {
            font-size: 0.8rem;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .bg-soft-primary {
            background-color: #e0e7ff;
            color: var(--brand-primary);
        }

        .bg-soft-danger {
            background-color: #fee2e2;
            color: var(--brand-danger);
        }

        .bg-soft-warning {
            background-color: #fef3c7;
            color: var(--brand-warning);
        }

        .bg-soft-success {
            background-color: #d1fae5;
            color: var(--brand-success);
        }

        /* --- LIST URGENT --- */
        .urgent-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .urgent-item {
            background: #f8fafc;
            border: 1px solid var(--bento-border);
            border-radius: 14px;
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            transition: 0.2s;
            text-decoration: none;
            color: inherit;
        }

        .urgent-item:hover {
            background: white;
            border-color: var(--brand-danger);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.1);
            transform: translateX(4px);
        }

        .badge-soft {
            padding: 0.3rem 0.6rem;
            border-radius: 8px;
            font-size: 0.7rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
    </style>
@endpush

@section('content')

    {{-- ==== PROSES DATA DARI DATABASE ==== --}}
    @php
        // Pastikan controller mengirimkan $ncrs (koleksi data NCR dari DB)
        $ncrs = $ncrs ?? collect([]);

        // 1. KPI Metrics
        $totalNcr = $ncrs->count();
        $statusOpen = $ncrs->where('status', 'Open')->count();
        $statusMonitoring = $ncrs->where('status', 'Monitoring')->count();
        $statusClosed = $ncrs->where('status', 'Closed')->count();

        // 2. Data Grafik Scope
        $scopeData = [
            $ncrs->where('audit_scope', 'Internal')->count(),
            $ncrs->where('audit_scope', 'External')->count(),
            $ncrs->where('audit_scope', 'Supplier')->count(),
        ];

        // 3. Data Grafik Severity
        $severityData = [
            $ncrs->where('severity', 'Critical')->count(),
            $ncrs->where('severity', 'High')->count(),
            $ncrs->where('severity', 'Medium')->count(),
            $ncrs->where('severity', 'Low')->count(),
        ];

        // 4. Data Urgent Issues (Filter Open, urutkan dari yang terlama)
        $urgentIssues = $ncrs
            ->where('status', 'Open')
            ->whereIn('severity', ['Critical', 'High'])
            ->sortBy('issue_date')
            ->take(4); // Ambil 4 teratas

        // 5. Data Grafik Tren (Bulan berjalan di tahun ini)
        $barValues = array_fill(0, 12, 0); // Array 12 bulan isi 0
        foreach ($ncrs as $ncr) {
            $date = \Carbon\Carbon::parse($ncr->issue_date);
            if ($date->year == date('Y')) {
                $barValues[$date->month - 1]++;
            }
        }
        $barLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
    @endphp

    <div class="container-xxl flex-grow-1 container-p-y pb-5">

        <div class="d-flex justify-content-between align-items-center mb-4 px-2">
            <div>
                <h4 class="fw-bolder text-dark mb-1" style="font-size: 1.5rem; letter-spacing: -0.5px;">Executive Dashboard
                </h4>
                <span class="text-muted fw-bold" style="font-size: 0.85rem;">Analitik Pusat Non-Conformance Report</span>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('ncr.index') }}" class="btn btn-light fw-bold text-primary shadow-sm rounded-pill px-3">
                    <i class="bi bi-list-ul me-1"></i> Ke Daftar NCR
                </a>
            </div>
        </div>

        <div class="bento-grid">

            <div class="bento-box bento-span-3">
                <div class="stat-wrapper">
                    <div class="stat-icon bg-soft-primary"><i class="bi bi-folder2-open"></i></div>
                    <div>
                        <div class="stat-label">Total NCR</div>
                        <div class="stat-value">{{ $totalNcr }}</div>
                    </div>
                </div>
            </div>

            <div class="bento-box bento-span-3">
                <div class="stat-wrapper">
                    <div class="stat-icon bg-soft-danger"><i class="bi bi-fire"></i></div>
                    <div>
                        <div class="stat-label">Status Open</div>
                        <div class="stat-value text-danger">{{ $statusOpen }}</div>
                    </div>
                </div>
            </div>

            <div class="bento-box bento-span-3">
                <div class="stat-wrapper">
                    <div class="stat-icon bg-soft-warning"><i class="bi bi-search"></i></div>
                    <div>
                        <div class="stat-label">Monitoring</div>
                        <div class="stat-value text-warning">{{ $statusMonitoring }}</div>
                    </div>
                </div>
            </div>

            <div class="bento-box bento-span-3">
                <div class="stat-wrapper">
                    <div class="stat-icon bg-soft-success"><i class="bi bi-check2-circle"></i></div>
                    <div>
                        <div class="stat-label">Telah Selesai</div>
                        <div class="stat-value text-success">{{ $statusClosed }}</div>
                    </div>
                </div>
            </div>

            <div class="bento-box bento-span-8 p-4">
                <div class="bento-header">
                    <div>
                        <h6 class="bento-title">Tren Kualitas Tahun {{ date('Y') }}</h6>
                        <span class="bento-subtitle">Jumlah NCR yang diterbitkan per bulan</span>
                    </div>
                </div>
                <div style="position: relative; height: 260px; width: 100%;">
                    <canvas id="trendChart"></canvas>
                </div>
            </div>

            <div class="bento-box bento-span-4 p-4">
                <div class="bento-header justify-content-center border-0 mb-0">
                    <h6 class="bento-title text-center">Audit Scope</h6>
                </div>
                <div class="d-flex align-items-center justify-content-center"
                    style="position: relative; height: 230px; width: 100%;">
                    <canvas id="scopeChart"></canvas>
                </div>
            </div>

            <div class="bento-box bento-span-5 p-4">
                <div class="bento-header">
                    <div>
                        <h6 class="bento-title">Tingkat Keparahan (Severity)</h6>
                        <span class="bento-subtitle">Distribusi level bahaya temuan</span>
                    </div>
                </div>
                <div style="position: relative; height: 260px; width: 100%;">
                    <canvas id="severityChart"></canvas>
                </div>
            </div>

            <div class="bento-box bento-span-7 p-4">
                <div class="bento-header border-0 mb-2">
                    <div>
                        <h6 class="bento-title text-danger"><i class="bi bi-exclamation-triangle-fill me-2"></i>Urgent
                            Action Required</h6>
                        <span class="bento-subtitle">Daftar NCR Open (Kritis/Tinggi) yang belum diselesaikan</span>
                    </div>
                    <a href="{{ route('ncr.index') }}" class="btn btn-sm btn-light rounded-pill fw-bold text-primary">Lihat
                        Semua</a>
                </div>

                <div class="urgent-list">
                    @forelse ($urgentIssues as $urgent)
                        @php
                            $daysOpen = \Carbon\Carbon::parse($urgent->issue_date)->diffInDays(now());
                            $sevClass = $urgent->severity == 'Critical' ? 'bg-soft-danger' : 'bg-soft-warning';
                        @endphp
                        <a href="{{ route('ncr.show', $urgent->id ?? '#') }}" class="urgent-item">
                            <div class="me-3 w-100">
                                <div class="fw-bolder text-dark mb-1 d-flex align-items-center gap-2">
                                    {{ $urgent->no_ncr }}
                                    @if ($urgent->no_po)
                                        <span class="badge bg-light text-secondary border fw-bold"
                                            style="font-size: 0.65rem;">
                                            <i class="bi bi-receipt"></i> {{ $urgent->no_po }}
                                        </span>
                                    @endif
                                </div>
                                <div class="text-muted"
                                    style="font-size: 0.8rem; display:-webkit-box; -webkit-line-clamp:1; -webkit-box-orient:vertical; overflow:hidden;">
                                    {{ $urgent->issue }}</div>
                                @if ($urgent->report_reff)
                                    <div class="mt-1 text-primary fw-bold" style="font-size: 0.7rem;">
                                        <i class="bi bi-link-45deg"></i> {{ $urgent->report_reff }}
                                    </div>
                                @endif
                            </div>
                            <div class="d-flex flex-column align-items-end gap-2 flex-shrink-0">
                                <span class="badge-soft {{ $sevClass }}">{{ $urgent->severity }}</span>
                                <small class="text-danger fw-bolder"><i class="bi bi-clock-history"></i>
                                    {{ $daysOpen }} Hari</small>
                            </div>
                        </a>
                    @empty
                        <div class="text-center py-5">
                            <div class="bg-soft-success d-inline-flex p-3 rounded-circle mb-3">
                                <i class="bi bi-check-lg text-success fs-2"></i>
                            </div>
                            <h6 class="fw-bold text-dark">Luar Biasa!</h6>
                            <p class="text-muted small">Tidak ada NCR tingkat Kritis/Tinggi yang tertunda saat ini.</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";
            Chart.defaults.color = '#64748b';

            // 1. Line Chart (Tren Bulanan dari Database)
            const trendCtx = document.getElementById('trendChart').getContext('2d');
            const gradientBlue = trendCtx.createLinearGradient(0, 0, 0, 300);
            gradientBlue.addColorStop(0, 'rgba(79, 70, 229, 0.4)');
            gradientBlue.addColorStop(1, 'rgba(79, 70, 229, 0)');

            new Chart(trendCtx, {
                type: 'line',
                data: {
                    labels: @json($barLabels),
                    datasets: [{
                        label: 'NCR Diterbitkan',
                        data: @json($barValues),
                        borderColor: '#4f46e5',
                        backgroundColor: gradientBlue,
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#4f46e5',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6
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
                                borderDash: [4, 4],
                                color: '#f1f5f9'
                            },
                            ticks: {
                                stepSize: 1,
                                font: {
                                    weight: '700'
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    weight: '700'
                                }
                            }
                        }
                    }
                }
            });

            // 2. Doughnut Chart (Audit Scope)
            const scopeCtx = document.getElementById('scopeChart').getContext('2d');
            new Chart(scopeCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Internal', 'External', 'Supplier'],
                    datasets: [{
                        data: @json($scopeData),
                        backgroundColor: ['#4f46e5', '#0ea5e9', '#cbd5e1'],
                        borderWidth: 0,
                        hoverOffset: 6,
                        cutout: '75%'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true,
                                font: {
                                    weight: '700'
                                }
                            }
                        }
                    }
                }
            });

            // 3. Bar Chart Horizontal (Severity Matrix)
            const sevCtx = document.getElementById('severityChart').getContext('2d');
            new Chart(sevCtx, {
                type: 'bar',
                data: {
                    labels: ['Critical', 'High', 'Medium', 'Low'],
                    datasets: [{
                        label: 'Total NCR',
                        data: @json($severityData),
                        backgroundColor: ['#ef4444', '#f59e0b', '#4f46e5', '#10b981'],
                        borderRadius: 6,
                        barThickness: 25
                    }]
                },
                options: {
                    indexAxis: 'y', // Horizontal
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            grid: {
                                borderDash: [4, 4],
                                color: '#f1f5f9'
                            },
                            ticks: {
                                stepSize: 1,
                                font: {
                                    weight: '700'
                                }
                            }
                        },
                        y: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    weight: '700'
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
@endpush

@extends('layouts.admin')
@section('title', 'Analytics Dashboard | QC Calibration')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3f37c9;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --surface: #ffffff;
            --bg-body: #f8fafc;
            --radius: 20px;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-body);
        }

        /* Banner Analytics */
        .banner-analytics {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            border-radius: var(--radius);
            padding: 2.5rem;
            color: white;
            position: relative;
            overflow: hidden;
            box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.1);
        }

        .banner-analytics::after {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 350px;
            height: 350px;
            background: radial-gradient(circle, rgba(67, 97, 238, 0.2) 0%, transparent 70%);
            border-radius: 50%;
        }

        /* KPI Floating */
        .kpi-wrapper {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-top: -30px;
            padding: 0 1rem;
        }

        .kpi-card-premium {
            background: white;
            padding: 1.5rem;
            border-radius: 18px;
            border: 1px solid rgba(0, 0, 0, 0.03);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .kpi-card-premium:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }

        /* Chart Section */
        .chart-surface {
            background: white;
            border-radius: var(--radius);
            border: 1px solid #edf2f7;
            padding: 1.5rem;
            height: 100%;
        }

        /* Table Style */
        .modern-table {
            border-collapse: separate;
            border-spacing: 0 8px;
            width: 100% !important;
        }

        .modern-table thead th {
            background: transparent;
            border: none;
            font-size: 0.75rem;
            font-weight: 800;
            color: #94a3b8;
            text-transform: uppercase;
            padding: 0 15px;
        }

        .modern-table tbody tr {
            background: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
            transition: all 0.2s;
        }

        .modern-table tbody tr:hover {
            transform: scale(1.005);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.05);
        }

        .modern-table td {
            border: none !important;
            padding: 16px 15px;
            vertical-align: middle;
        }

        .modern-table td:first-child {
            border-radius: 12px 0 0 12px;
        }

        .modern-table td:last-child {
            border-radius: 0 12px 12px 0;
        }

        /* Status Tag */
        .status-tag {
            padding: 6px 14px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 0.7rem;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .tag-success {
            background: #ecfdf5;
            color: #059669;
        }

        .tag-warning {
            background: #fff7ed;
            color: #c2410c;
        }

        .tag-primary {
            background: #eff6ff;
            color: #1d4ed8;
        }

        .btn-premium-sm {
            background: #f1f5f9;
            color: var(--primary);
            border: none;
            font-weight: 800;
            font-size: 0.75rem;
            padding: 8px 16px;
            border-radius: 8px;
            transition: 0.2s;
        }

        .btn-premium-sm:hover {
            background: var(--primary);
            color: white;
        }
    </style>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="banner-analytics mb-5">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="fw-800 text-white mb-2">Calibration Intelligence Portal</h2>
                    <p class="opacity-75 mb-0 fs-5">Sistem mendeteksi <strong>{{ $dueSoon }} item</strong> memerlukan
                        perhatian dalam 15 hari ke depan.</p>
                </div>
                <div class="col-md-4 text-md-end d-none d-md-block">
                    <button class="btn btn-primary rounded-pill px-4 fw-bold shadow-lg">
                        <i class="bi bi-file-earmark-pdf me-2"></i> Ekspor Laporan Bulanan
                    </button>
                </div>
            </div>
        </div>

        <div class="kpi-wrapper mb-5">
            <div class="kpi-card-premium">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted small fw-bold">TOTAL ASSET</span>
                    <i class="bi bi-layers text-primary fs-5"></i>
                </div>
                <div class="h2 fw-800 mb-0">{{ number_format($totalTools) }}</div>
                <div class="small text-success fw-bold mt-2"><i class="bi bi-arrow-up-short"></i> Unit Terdaftar</div>
            </div>
            <div class="kpi-card-premium">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted small fw-bold">CERTIFIED OK</span>
                    <i class="bi bi-patch-check text-success fs-5"></i>
                </div>
                <div class="h2 fw-800 mb-0 text-success">{{ number_format($statusOk) }}</div>
                <div class="small text-muted fw-bold mt-2">Verified Status</div>
            </div>
            <div class="kpi-card-premium">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted small fw-bold">ON PROGRESS</span>
                    <i class="bi bi-arrow-repeat text-info fs-5"></i>
                </div>
                <div class="h2 fw-800 mb-0 text-info">{{ number_format($statusProses) }}</div>
                <div class="small text-muted fw-bold mt-2">Calibration Cycle</div>
            </div>
            <div class="kpi-card-premium">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted small fw-bold">CRITICAL DUE</span>
                    <i class="bi bi-exclamation-octagon text-warning fs-5"></i>
                </div>
                <div class="h2 fw-800 mb-0 text-warning">{{ number_format($dueSoon) }}</div>
                <div class="small text-danger fw-bold mt-2"><i class="bi bi-clock-history"></i>
                    < 15 Days Left</div>
                </div>
            </div>

            <div class="row g-4 mb-5">
                <div class="col-lg-7">
                    <div class="chart-surface shadow-sm">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="fw-800 mb-0">Tren Kalibrasi & Validasi</h5>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-light border rounded-pill px-3 fw-bold" type="button">Tahun
                                    {{ date('Y') }}</button>
                            </div>
                        </div>
                        <div style="height: 300px;">
                            <canvas id="mainDashboardChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="chart-surface shadow-sm">
                        <h5 class="fw-800 mb-4">Sebaran Kondisi Alat</h5>
                        <div style="height: 250px;">
                            <canvas id="statusDoughnutPremium"></canvas>
                        </div>
                        <div class="mt-4 d-flex justify-content-around">
                            <div class="text-center">
                                <div class="fw-800 text-success">{{ round(($statusOk / $totalTools) * 100) }}%</div>
                                <small class="text-muted small-8">Certified</small>
                            </div>
                            <div class="text-center">
                                <div class="fw-800 text-primary">{{ round(($statusProses / $totalTools) * 100) }}%</div>
                                <small class="text-muted small-8">Cycle</small>
                            </div>
                            <div class="text-center">
                                <div class="fw-800 text-warning">{{ round(($dueSoon / $totalTools) * 100) }}%</div>
                                <small class="text-muted small-8">Alert</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="d-flex justify-content-between align-items-end mb-3 px-2">
                        <h5 class="fw-800 mb-0"><i class="bi bi-fire text-danger me-2"></i>Urgent Priority</h5>
                        <a href="#" class="text-primary fw-bold small text-decoration-none">View All &rarr;</a>
                    </div>
                    <div class="table-responsive">
                        <table id="dueSoonTable" class="modern-table">
                            <thead>
                                <tr>
                                    <th>IDENTITAS ALAT</th>
                                    <th>JADWAL ULANG</th>
                                    <th class="text-center">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dueSoonList as $tool)
                                    <tr>
                                        <td>
                                            <div class="fw-bold text-dark">{{ $tool->nama_alat }}</div>
                                            <div class="text-muted extra-small">SN: {{ $tool->no_seri }}</div>
                                        </td>
                                        <td><span class="status-tag tag-warning"><i class="bi bi-clock"></i>
                                                {{ \Carbon\Carbon::parse($tool->tgl_kalibrasi_ulang)->format('d M Y') }}</span>
                                        </td>
                                        <td class="text-center"><button class="btn-premium-sm">PROCESS</button></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="d-flex justify-content-between align-items-end mb-3 px-2">
                        <h5 class="fw-800 mb-0"><i class="bi bi-arrow-repeat text-info me-2"></i>Active Calibration Cycle
                        </h5>
                        <a href="#" class="text-primary fw-bold small text-decoration-none">Monitor &rarr;</a>
                    </div>
                    <div class="table-responsive">
                        <table id="inProgressTable" class="modern-table">
                            <thead>
                                <tr>
                                    <th>IDENTITAS ALAT</th>
                                    <th>STATUS</th>
                                    <th class="text-center">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($inProgress as $t)
                                    <tr>
                                        <td>
                                            <div class="fw-bold text-dark">{{ $t->nama_alat }}</div>
                                            <div class="text-muted extra-small">SN: {{ $t->no_seri }}</div>
                                        </td>
                                        <td><span class="status-tag tag-primary"><i class="bi bi-gear-fill spin"></i>
                                                IN-PROGRESS</span></td>
                                        <td class="text-center"><button class="btn-premium-sm">DETAIL</button></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // Main Trend Chart
            const mainCtx = document.getElementById('mainDashboardChart').getContext('2d');
            new Chart(mainCtx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($barLabels) !!},
                    datasets: [{
                        label: 'Unit Kalibrasi',
                        data: {!! json_encode($barValues) !!},
                        borderColor: '#4361ee',
                        backgroundColor: 'rgba(67, 97, 238, 0.05)',
                        fill: true,
                        tension: 0.4,
                        pointRadius: 4,
                        pointBackgroundColor: '#fff',
                        pointBorderWidth: 2,
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
                                color: '#f1f5f9'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });

            // Doughnut Status
            const pieCtx = document.getElementById('statusDoughnutPremium').getContext('2d');
            new Chart(pieCtx, {
                type: 'doughnut',
                data: {
                    labels: ['OK', 'Proses', 'Due Soon'],
                    datasets: [{
                        data: [{{ $pieData['ok'] }}, {{ $pieData['proses'] }}, {{ $pieData['due'] }}],
                        backgroundColor: ['#10b981', '#4361ee', '#f59e0b'],
                        hoverOffset: 20,
                        borderWidth: 0,
                        cutout: '80%'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        </script>
    @endpush

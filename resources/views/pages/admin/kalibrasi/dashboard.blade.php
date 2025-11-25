@extends('layouts.admin')
@section('title', 'Dashboard Kalibrasi | QC Calibration')

@push('css')
    <!-- DataTables + Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        /* Layout tweaks */
        .card.h-100 {
            min-height: 160px;
        }

        .summary-card .value {
            font-size: 1.9rem;
            font-weight: 700;
        }

        .summary-card .label {
            font-size: 0.95rem;
            color: #6c757d;
        }

        /* Keep table cells tidy */
        table.dataTable td,
        table.dataTable th,
        .table-fixed td,
        .table-fixed th {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Chart containers */
        .chart-container {
            height: 250px;
            position: relative;
        }

        /* Responsive smaller cards on narrow screens */
        @media (max-width: 576px) {
            .summary-card .value {
                font-size: 1.5rem;
            }

            .chart-container {
                height: 200px;
            }
        }

        /* Compact DataTable styling */
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            margin-bottom: 0.5rem;
        }

        /* Table placeholder for empty results */
        .empty-placeholder {
            text-align: center;
            color: #6c757d;
            padding: 2rem 1rem;
        }
    </style>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">QC / Kalibrasi /</span> Dashboard
        </h4>

        <!-- Summary Cards -->
        <div class="row g-3 mb-4">
            <div class="col-lg-3 col-md-6">
                <div class="card summary-card text-center shadow-sm p-3 h-100">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="label">Total Item</div>
                        <i class="bi bi-box-seam fs-4 text-muted"></i>
                    </div>
                    <div class="value mt-2">{{ $totalTools }}</div>
                    <div class="small text-muted mt-1">Terdaftar</div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card summary-card text-center shadow-sm p-3 h-100">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="label">Status OK</div>
                        <i class="bi bi-check-circle-fill fs-4 text-success"></i>
                    </div>
                    <div class="value text-success mt-2">{{ $statusOk }}</div>
                    <div class="small text-muted mt-1">Siap pakai</div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card summary-card text-center shadow-sm p-3 h-100">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="label">Proses Kalibrasi</div>
                        <i class="bi bi-wrench-adjustable-circle fs-4 text-primary"></i>
                    </div>
                    <div class="value text-primary mt-2">{{ $statusProses }}</div>
                    <div class="small text-muted mt-1">Dalam pengerjaan</div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card summary-card text-center shadow-sm p-3 h-100">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="label">Penjadwalan (≤15 hari)</div>
                        <i class="bi bi-exclamation-triangle-fill fs-4 text-warning"></i>
                    </div>
                    <div class="value text-warning mt-2">{{ $dueSoon }}</div>
                    <div class="small text-muted mt-1">Perhatian</div>
                </div>
            </div>
        </div>

        <!-- Charts -->
        <div class="row g-3 mb-4">
            <!-- Doughnut Chart Status -->
            <div class="col-lg-4 col-md-6">
                <div class="card shadow-sm p-3 h-100">
                    <h6 class="mb-2">Status Kalibrasi</h6>
                    <div class="chart-container">
                        <canvas id="statusDoughnut" style="display:block; width:100%; height:100%;"></canvas>
                    </div>
                    <div class="mt-2 d-flex justify-content-around">
                        <small><span class="badge bg-success">OK</span> {{ $pieData['ok'] ?? 0 }}</small>
                        <small><span class="badge bg-primary">Proses</span> {{ $pieData['proses'] ?? 0 }}</small>
                        <small><span class="badge bg-warning text-dark">Penjadwalan</span>
                            {{ $pieData['due'] ?? 0 }}</small>
                    </div>
                </div>
            </div>

            <!-- Horizontal Bar Chart -->
            <div class="col-lg-4 col-md-6">
                <div class="card shadow-sm p-3 h-100">
                    <h6 class="mb-2">Kalibrasi per Bulan</h6>
                    <div class="chart-container">
                        <canvas id="barChartHorizontal" style="display:block; width:100%; height:100%;"></canvas>
                    </div>
                </div>
            </div>

            <!-- Line Chart -->
            <div class="col-lg-4 col-md-12">
                <div class="card shadow-sm p-3 h-100">
                    <h6 class="mb-2">Tren Item Akan Jatuh Tempo</h6>
                    <div class="chart-container">
                        <canvas id="lineChart" style="display:block; width:100%; height:100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Akan Jatuh Tempo -->
        <h5 class="mb-2">Akan Jatuh Tempo (≤15 hari)</h5>
        <div class="card shadow-sm p-3 mb-4 table-responsive">
            <table id="dueSoonTable" class="table table-bordered table-hover mb-0">
                <thead class="table-warning">
                    <tr>
                        <th>Nama Item</th>
                        <th>Merek</th>
                        <th>Seri</th>
                        <th>Tgl Kalibrasi Ulang</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dueSoonList as $tool)
                        <tr>
                            <td>{{ $tool->nama_alat }}</td>
                            <td>{{ $tool->merek }}</td>
                            <td>{{ $tool->no_seri }}</td>
                            <td>{{ \Carbon\Carbon::parse($tool->tgl_kalibrasi_ulang)->translatedFormat('d F Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Dalam Proses Kalibrasi -->
        <h5 class="mb-2">Dalam Proses Kalibrasi</h5>
        <div class="card shadow-sm p-3 mb-4 table-responsive">
            <table id="inProgressTable" class="table table-bordered table-hover mb-0">
                <thead class="table-primary">
                    <tr>
                        <th>Nama Item</th>
                        <th>Merek</th>
                        <th>Seri</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($inProgress as $t)
                        <tr>
                            <td>{{ $t->nama_alat }}</td>
                            <td>{{ $t->merek }}</td>
                            <td>{{ $t->no_seri }}</td>
                            <td>{{ $t->keterangan }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Semua Alat -->
        <h5 class="mb-2">Semua Item</h5>
        <div class="card shadow-sm p-3 table-responsive">
            <table id="toolsTable" class="table table-striped table-hover mb-0">
                <thead style="background-color: #f8f9fa; font-weight: 600;">
                    <tr>
                        <th>Nama</th>
                        <th>Merek</th>
                        <th>Seri</th>
                        <th>Status</th>
                        <th>Tgl Kalibrasi Ulang</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tools as $tool)
                        <tr>
                            <td>{{ $tool->nama_alat }}</td>
                            <td>{{ $tool->merek ?? '-' }}</td>
                            <td>{{ $tool->no_seri ?? '-' }}</td>
                            <td>{{ optional($tool->latestHistory)->status_kalibrasi ?? '-' }}</td>
                            <td>
                                {{ optional($tool->latestHistory)->tgl_kalibrasi_ulang
                                    ? \Carbon\Carbon::parse($tool->latestHistory->tgl_kalibrasi_ulang)->translatedFormat('d F Y')
                                    : '-' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-3">{{ $tools->links() }}</div>
        </div>

    </div>
@endsection

@push('js')
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        $(document).ready(function() {
            $('#dueSoonTable, #inProgressTable, #toolsTable').DataTable({
                responsive: true,
                autoWidth: false,
                pageLength: 10,
                lengthMenu: [5, 10, 25, 50],
            });
        });

        // Doughnut Chart Status
        new Chart(document.getElementById('statusDoughnut'), {
            type: 'doughnut',
            data: {
                labels: ['OK', 'Proses', 'Akan Jatuh Tempo'],
                datasets: [{
                    data: {!! json_encode([$pieData['ok'], $pieData['proses'], $pieData['due']]) !!},
                    backgroundColor: ['#28a745', '#007bff', '#ffc107'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // Horizontal Bar Chart
        new Chart(document.getElementById('barChartHorizontal'), {
            type: 'bar',
            data: {
                labels: {!! json_encode($barLabels) !!},
                datasets: [{
                    label: 'Jumlah Item',
                    data: {!! json_encode($barValues) !!},
                    backgroundColor: 'rgba(54,162,235,0.7)',
                    borderWidth: 1
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        beginAtZero: true,
                        precision: 0
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        // Line Chart Tren
        new Chart(document.getElementById('lineChart'), {
            type: 'line',
            data: {
                labels: {!! json_encode($barLabels) !!},
                datasets: [{
                    label: 'Item Akan Jatuh Tempo',
                    data: {!! json_encode($barValues) !!},
                    fill: false,
                    borderColor: '#007bff',
                    tension: 0.3,
                    pointBackgroundColor: '#007bff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        precision: 0
                    }
                }
            }
        });
    </script>
@endpush

@extends('layouts.admin')
@section('title', 'Dashboard Inventory | MCI')

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        /* Dashboard tweaks */
        .card-hero {
            border-left: 4px solid rgba(81,102,255,0.95);
            transition: transform .12s ease, box-shadow .12s ease;
        }
        .card-hero:hover { transform: translateY(-4px); box-shadow: 0 8px 30px rgba(6,8,15,0.06); }

        .stat-icon {
            width:56px;
            height:56px;
            border-radius:12px;
            display:inline-flex;
            align-items:center;
            justify-content:center;
            background:linear-gradient(135deg,#eef2ff,#f4f8ff);
            color: #3b82f6;
            font-size:1.5rem;
        }

        .low-stock-row {
            background: linear-gradient(90deg, rgba(255,243,205,0.45), rgba(255,255,255,0));
        }

        .table thead th {
            position: sticky;
            top: 0;
            backdrop-filter: blur(4px);
            z-index: 2;
        }

        .small-muted { color: #6b7280; font-size:.92rem; }

        .chip {
            display:inline-block;
            padding:.22rem .5rem;
            border-radius:999px;
            font-size:.78rem;
            background:#f1f5f9;
            color:#0f172a;
            margin-right:.25rem;
        }

        .search-input {
            max-width:420px;
        }

        .action-btns .btn {
            min-width:110px;
        }

        /* responsive tweaks for small screens */
        @media (max-width:575px) {
            .stat-icon { width:48px; height:48px; font-size:1.2rem; }
            .action-btns .btn { min-width:unset; padding-left:.6rem; padding-right:.6rem; }
        }
    </style>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        {{-- Header & Action --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
            <div>
                <h4 class="fw-bold mb-0">📦 Dashboard Inventory</h4>
                <div class="small-muted">Ringkasan stok, aktivitas terakhir, dan peringatan stok rendah.</div>
            </div>

            <div class="d-flex gap-2 action-btns">
                <a href="{{ route('material_in.create') }}" class="btn btn-success d-flex align-items-center gap-2">
                    <i class="bi bi-box-arrow-in-down"></i> Material In
                </a>
                <a href="{{ route('material_out.create') }}" class="btn btn-danger d-flex align-items-center gap-2">
                    <i class="bi bi-box-arrow-up"></i> Material Out
                </a>
                <a href="{{ route('materials.index') }}" class="btn btn-outline-secondary d-flex align-items-center gap-2">
                    <i class="bi bi-boxes"></i> Daftar Material
                </a>
            </div>
        </div>

        {{-- Statistik Utama --}}
        <div class="row g-3 mb-4">
            <div class="col-12 col-sm-6 col-md-3">
                <div class="card card-hero border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="stat-icon"><i class="bi bi-stack"></i></div>
                        <div>
                            <div class="small-muted">Total Material</div>
                            <h5 class="fw-bold mb-0 text-primary">{{ $totalMaterials }}</h5>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="card card-hero border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="stat-icon" style="color:#16a34a; background:linear-gradient(135deg,#ecfdf5,#f1fbf6)"><i class="bi bi-box-seam"></i></div>
                        <div>
                            <div class="small-muted">Total Stok</div>
                            <h5 class="fw-bold mb-0 text-success">{{ number_format($totalStock) }}</h5>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="card card-hero border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="stat-icon" style="color:#0ea5e9; background:linear-gradient(135deg,#eff8ff,#f4fbff)"><i class="bi bi-arrow-down-square"></i></div>
                        <div>
                            <div class="small-muted">Barang Masuk</div>
                            <h5 class="fw-bold mb-0 text-info">{{ number_format($totalIn) }}</h5>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="card card-hero border-0 shadow-sm h-100">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="stat-icon" style="color:#ef4444; background:linear-gradient(135deg,#fff5f5,#fff8f8)"><i class="bi bi-arrow-up-square"></i></div>
                        <div>
                            <div class="small-muted">Barang Keluar</div>
                            <h5 class="fw-bold mb-0 text-danger">{{ number_format($totalOut) }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Stok Minimum --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-warning fw-bold d-flex justify-content-between align-items-center">
                <span>⚠️ Stok Di Bawah Minimum</span>
                <div class="small-muted">Segera lakukan restock untuk material berwarna merah</div>
            </div>

            <div class="card-body p-0">
                @if ($lowStock->isEmpty())
                    <p class="text-center text-muted py-3 mb-0">Semua stok aman</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-warning">
                                <tr>
                                    <th class="w-15">Kode</th>
                                    <th>Material</th>
                                    <th class="text-end">Stok Terbaru</th>
                                    <th class="text-end">Minimum</th>
                                    <th>Posisi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($lowStock as $item)
                                    <tr class="low-stock-row">
                                        <td class="fw-semibold">{{ $item->material_code }}</td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <div class="fw-bold">
                                                    {{ $item->sparePart->spare_part_name ?? $item->material_name ?? '-' }}
                                                </div>
                                                <div class="small-muted">
                                                    {{ $item->valves->pluck('valve_name')->join(', ') ?: '-' }}
                                                </div>
                                            </div>
                                        </td>
                                        <td class="fw-bold text-danger text-end">{{ number_format($item->current_stock) }}</td>
                                        <td class="text-end">{{ number_format($item->stock_minimum) }}</td>
                                        <td>{{ optional($item->rack)->rack_code ?? '-' }}</td>
                                        {{-- <td class="text-center">
                                            <a href="{{ route('materials.show', $item->id) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye"></i> Lihat
                                            </a>
                                        </td> --}}
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        {{-- Riwayat Transaksi --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light d-flex justify-content-between align-items-center gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div>
                        <i class="bi bi-clock-history me-2"></i>
                        <span class="fw-bold">Riwayat Transaksi Material</span>
                    </div>
                    <div class="small-muted">Terbaru</div>
                </div>

                {{-- <div class="d-flex gap-2 align-items-center">
                    <input id="historySearch" class="form-control form-control-sm search-input" placeholder="Cari kode atau nama material..." aria-label="Search history">
                    <a href="#" class="btn btn-sm btn-outline-success" title="Export CSV">
                        <i class="bi bi-download"></i> Export
                    </a>
                </div> --}}
            </div>

            <div class="card-body p-0">
                @if ($history->isEmpty())
                    <p class="text-center text-muted py-3 mb-0">Belum ada transaksi</p>
                @else
                    <div class="table-responsive">
                        <table id="historyTable" class="table table-hover align-middle mb-0">
                            <thead class="table-secondary">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Jenis</th>
                                    <th>Material</th>
                                    <th class="text-end">Stok Awal</th>
                                    <th class="text-end">Jumlah</th>
                                    <th class="text-end">Stok Akhir</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($history as $item)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($item->date_in)->translatedFormat('d F Y') }}</td>
                                        <td>
                                            @if ($item->jenis === 'in')
                                                <span class="badge bg-success">
                                                    <i class="bi bi-box-arrow-in-down"></i> Barang Masuk
                                                </span>
                                            @else
                                                <span class="badge bg-danger">
                                                    <i class="bi bi-box-arrow-up"></i> Barang Keluar
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="fw-semibold">{{ $item->material->material_code ?? '-' }}</div>
                                            <div class="small-muted">
                                                @php
                                                    $valveNames = $item->material->valves->pluck('valve_name')->toArray();
                                                    $valveList = implode(', ', $valveNames);
                                                @endphp
                                                {{ $valveList ?: '-' }} | {{ $item->material->sparePart->spare_part_name ?? '-' }}
                                            </div>
                                        </td>
                                        <td class="text-end">{{ number_format($item->material->stock_awal ?? 0) }}</td>
                                        <td class="fw-bold text-end {{ $item->jenis === 'in' ? 'text-success' : 'text-danger' }}">
                                            {{ $item->jenis === 'in' ? '+' : '-' }}{{ number_format($item->qty) }}
                                        </td>
                                        <td class="text-end">{{ number_format($item->stock_after ?? 0) }}</td>
                                        <td>{{ $item->notes ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        {{-- Grafik --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light fw-bold">
                📈 Grafik Barang Masuk & Keluar (Per Bulan)
            </div>
            <div class="card-body">
                <canvas id="inventoryChart" height="120" aria-label="Grafik barang masuk dan keluar per bulan"></canvas>
            </div>
        </div>

    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // small client-side search for history table
        (function () {
            const search = document.getElementById('historySearch');
            const table = document.getElementById('historyTable');
            if (!search || !table) return;
            const rows = Array.from(table.tBodies[0].rows);

            search.addEventListener('input', function () {
                const q = this.value.trim().toLowerCase();
                rows.forEach(r => {
                    const text = r.innerText.toLowerCase();
                    r.style.display = text.indexOf(q) > -1 ? '' : 'none';
                });
            });
        })();

        // Chart
        (function () {
            const ctx = document.getElementById('inventoryChart');
            if (!ctx) return;
            const chartData = @json($monthlyData ?? []);
            const labels = chartData.map(i => i.month);
            const dataIn = chartData.map(i => i.in || 0);
            const dataOut = chartData.map(i => i.out || 0);

            const formatNumber = (v) => new Intl.NumberFormat().format(v);

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Barang Masuk',
                            data: dataIn,
                            backgroundColor: 'rgba(34,197,94,0.85)',
                            borderRadius: 6,
                        },
                        {
                            label: 'Barang Keluar',
                            data: dataOut,
                            backgroundColor: 'rgba(239,68,68,0.85)',
                            borderRadius: 6,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    scales: {
                        x: {
                            stacked: false,
                            grid: { display: false }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function (value) { return formatNumber(value); }
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function (ctx) {
                                    let label = ctx.dataset.label || '';
                                    if (label) label += ': ';
                                    label += formatNumber(ctx.parsed.y);
                                    return label;
                                }
                            }
                        },
                        legend: { position: 'bottom' }
                    }
                }
            });
        })();
    </script>
@endpush
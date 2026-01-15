@extends('layouts.admin')
@section('title', 'Dashboard Inventory | MCI')

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        /* General */
        :root{
            --accent-1: #5166ff;
            --accent-2: #06b6d4;
            --muted: #6b7280;
            --card-radius: 14px;
        }

        .card-hero {
            border-left: 4px solid var(--accent-1);
            border-radius: var(--card-radius);
            transition: transform .14s ease, box-shadow .14s ease;
        }

        .card-hero:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 40px rgba(6, 8, 15, 0.06);
        }

        .stat-icon {
            width: 56px;
            height: 56px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, rgba(81,102,255,0.08), rgba(81,102,255,0.02));
            color: var(--accent-1);
            font-size: 1.25rem;
        }

        .small-muted { color: var(--muted); font-size: .92rem; }

        .chip {
            display: inline-block;
            padding: .22rem .5rem;
            border-radius: 999px;
            font-size: .78rem;
            background: #f1f5f9;
            color: #0f172a;
            margin-right: .25rem;
        }

        /* Low stock highlight */
        .low-stock-row {
            background: linear-gradient(90deg, rgba(255, 243, 205, 0.45), rgba(255, 255, 255, 0));
        }

        /* Table header sticky + subtle glass effect */
        .table thead th {
            position: sticky;
            top: 0;
            backdrop-filter: blur(4px);
            z-index: 3;
            background: linear-gradient(180deg, rgba(255,255,255,0.96), rgba(255,255,255,0.92));
        }

        /* Compact accordion look */
        .accordion-button {
            padding: .5rem 1rem;
            border-radius: 8px;
        }

        /* badges */
        .badge-in {
            background: rgba(25, 135, 84, 0.09);
            color: #166534;
            border-radius: 8px;
            padding: 0.28rem .5rem;
            font-weight: 600;
        }

        .badge-out {
            background: rgba(220, 53, 69, 0.07);
            color: #7f1d1d;
            border-radius: 8px;
            padding: 0.28rem .5rem;
            font-weight: 600;
        }

        /* Responsive tweaks */
        @media (max-width: 575px) {
            .stat-icon { width: 48px; height: 48px; font-size: 1.1rem; }
            .action-btns .btn { min-width: unset; padding-left: .6rem; padding-right: .6rem; }
        }

        /* subtle hover for rows */
        .table-hover tbody tr:hover { background-color: rgba(6, 8, 15, 0.03); }

        /* helper: truncate long text */
        .text-truncate-td { max-width: 18ch; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }

        /* KPI sparkline placeholder */
        .kpi-spark { width: 72px; height: 28px; display:inline-block; }
    </style>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- HEADER -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
            <div>
                <h4 class="fw-bold mb-0">📦 Dashboard Inventory</h4>
                <div class="small-muted">Ringkasan stok, aktivitas terakhir, dan peringatan stok rendah — tampilan dibuat lebih informatif dan mudah dibaca.</div>
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
                {{-- <a href="{{ route('materials.export') }}" class="btn btn-outline-primary d-flex align-items-center gap-2">
                    <i class="bi bi-download"></i> Export CSV
                </a> --}}
            </div>
        </div>

        <!-- KPI SUMMARY -->
        <div class="row g-3 mb-4">
            <div class="col-12 col-sm-6 col-md-3">
                <div class="card card-hero border-0 shadow-sm h-100 p-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stat-icon"><i class="bi bi-stack"></i></div>
                        <div class="flex-grow-1">
                            <div class="small-muted">Total Material</div>
                            <div class="d-flex align-items-end justify-content-between">
                                <h5 class="fw-bold mb-0 text-primary">{{ $totalMaterials }}</h5>
                                <canvas class="kpi-spark" id="sparkTotalMaterial"></canvas>
                            </div>
                            <div class="small-muted mt-1">Unique items in catalog</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="card card-hero border-0 shadow-sm h-100 p-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stat-icon" style="color:#16a34a; background:linear-gradient(135deg,#ecfdf5,#f1fbf6)"><i class="bi bi-box-seam"></i></div>
                        <div class="flex-grow-1">
                            <div class="small-muted">Total Stok</div>
                            <div class="d-flex align-items-end justify-content-between">
                                <h5 class="fw-bold mb-0 text-success">{{ number_format($totalStock) }}</h5>
                                <canvas class="kpi-spark" id="sparkTotalStock"></canvas>
                            </div>
                            <div class="small-muted mt-1">Keseluruhan unit di gudang</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="card card-hero border-0 shadow-sm h-100 p-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stat-icon" style="color:#0ea5e9; background:linear-gradient(135deg,#eff8ff,#f4fbff)"><i class="bi bi-arrow-down-square"></i></div>
                        <div class="flex-grow-1">
                            <div class="small-muted">Masuk (Bulan)</div>
                            <div class="d-flex align-items-end justify-content-between">
                                <h5 class="fw-bold mb-0 text-info">{{ number_format($totalIn) }}</h5>
                                <canvas class="kpi-spark" id="sparkIn"></canvas>
                            </div>
                            <div class="small-muted mt-1">Rekapan barang masuk bulan ini</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="card card-hero border-0 shadow-sm h-100 p-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stat-icon" style="color:#ef4444; background:linear-gradient(135deg,#fff5f5,#fff8f8)"><i class="bi bi-arrow-up-square"></i></div>
                        <div class="flex-grow-1">
                            <div class="small-muted">Keluar (Bulan)</div>
                            <div class="d-flex align-items-end justify-content-between">
                                <h5 class="fw-bold mb-0 text-danger">{{ number_format($totalOut) }}</h5>
                                <canvas class="kpi-spark" id="sparkOut"></canvas>
                            </div>
                            <div class="small-muted mt-1">Rekapan barang keluar bulan ini</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- LOW STOCK & QUICK ACTIONS -->
        <div class="row g-3 mb-4">
            <div class="col-lg-6">
                <div class="card shadow-sm h-100">
                    <div class="card-header d-flex justify-content-between align-items-center bg-light">
                        <div class="fw-bold">⚠️ Stok Rendah</div>
                        <div class="small-muted">Daftar item di bawah threshold</div>
                    </div>

                    <div class="card-body p-0">
                        @if($lowStock->isEmpty())
                            <div class="p-4 text-center small-muted">Semua material berada di atas batas minimum.</div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>Material</th>
                                            <th class="text-center" style="width:120px">Stok</th>
                                            <th class="text-end" style="width:220px">Progress</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($lowStock as $m)
                                            @php
                                                $pct = $m->min_stock > 0 ? min(100, round(($m->stock / $m->min_stock) * 100)) : 0;
                                            @endphp
                                            <tr class="{{ $m->stock <= $m->min_stock ? 'low-stock-row' : '' }}">
                                                <td>
                                                    <div class="fw-semibold">{{ $m->material_code ?? $m->spare_part_name }}</div>
                                                    <div class="small-muted">{{ Str::limit($m->description ?? $m->spare_part_name, 50) }}</div>
                                                </td>
                                                <td class="text-center fw-bold">{{ number_format($m->stock) }}</td>
                                                <td class="text-end">
                                                    <div class="d-flex align-items-center gap-2 justify-content-end">
                                                        <div class="small-muted me-2 text-nowrap">{{ $pct }}%</div>
                                                        <div class="progress w-50" style="height:8px; border-radius:6px;">
                                                            <div class="progress-bar @if($pct<=30) bg-danger @elseif($pct<=60) bg-warning @else bg-success @endif" role="progressbar" style="width:{{ $pct }}%"></div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="p-3 border-top text-end">
                                <a href="{{ route('materials.low') }}" class="btn btn-outline-primary btn-sm">Lihat semua</a>
                                <a href="{{ route('materials.restock') }}" class="btn btn-primary btn-sm">Buat PO Restock</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Recent Activity + Filters -->
            <div class="col-lg-6">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-light d-flex align-items-center justify-content-between">
                        <div>
                            <i class="bi bi-clock-history me-2"></i>
                            <span class="fw-bold">Riwayat Transaksi Terbaru</span>
                            <div class="small-muted">Kelompok per tanggal — klik untuk buka detail</div>
                        </div>

                        <div class="d-flex gap-2 align-items-center">
                            <input id="historySearch" type="search" class="form-control form-control-sm" placeholder="🔎 Cari (spare / kode / keterangan)" style="min-width:220px">
                            <button class="btn btn-sm btn-outline-secondary" id="expandAll">Buka Semua</button>
                            <button class="btn btn-sm btn-outline-secondary" id="collapseAll">Tutup Semua</button>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        @if ($history->isEmpty())
                            <div class="text-center text-muted py-4 mb-0">
                                <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                Belum ada transaksi
                            </div>
                        @else
                            @php
                                $groupedHistory = $history->groupBy(function ($item) {
                                    return \Carbon\Carbon::parse($item->date_in)->translatedFormat('d F Y');
                                });
                                $accordionId = 'historyAccordion';
                            @endphp

                            <div class="accordion" id="{{ $accordionId }}">
                                @foreach ($groupedHistory as $date => $items)
                                    @php
                                        $totalIn = $items->where('jenis', 'in')->sum('qty');
                                        $totalOut = $items->where('jenis', 'out')->sum('qty');
                                        $safeId = 'grp-' . \Illuminate\Support\Str::slug($date);
                                    @endphp

                                    <div class="accordion-item border-0">
                                        <h2 class="accordion-header" id="heading-{{ $safeId }}">
                                            <button class="accordion-button collapsed bg-white d-flex align-items-center justify-content-between" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapse-{{ $safeId }}" aria-expanded="false" aria-controls="collapse-{{ $safeId }}">
                                                <div class="fw-semibold"><i class="bi bi-calendar-event me-2"></i> {{ $date }}</div>
                                                <div class="small-muted">
                                                    <span class="me-3"><strong class="text-success">+{{ number_format($totalIn) }}</strong> in</span>
                                                    <span class="me-3"><strong class="text-danger">-{{ number_format($totalOut) }}</strong> out</span>
                                                    <span class="text-muted">({{ $items->count() }} transaksi)</span>
                                                </div>
                                            </button>
                                        </h2>

                                        <div id="collapse-{{ $safeId }}" class="accordion-collapse collapse" aria-labelledby="heading-{{ $safeId }}" data-bs-parent="#{{ $accordionId }}">
                                            <div class="accordion-body p-0">
                                                <div class="table-responsive">
                                                    <table class="table table-sm table-hover align-middle mb-0 history-table">
                                                        <thead class="text-muted small">
                                                            <tr>
                                                                <th style="width:75px">Jam</th>
                                                                <th style="width:90px">Jenis</th>
                                                                <th>Material / Spare</th>
                                                                <th class="text-end" style="width:100px">Stok Awal</th>
                                                                <th class="text-end" style="width:100px">Perubahan</th>
                                                                <th class="text-end" style="width:100px">Stok Akhir</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($items as $item)
                                                                @php
                                                                    $time = \Carbon\Carbon::parse($item->date_in)->format('H:i');
                                                                    $isIn = $item->jenis === 'in';
                                                                    $valveList = optional($item->material->valves)->pluck('valve_name')->join(', ');
                                                                    $spareName = optional($item->material->sparePart)->spare_part_name ?? ($item->material->material_code ?? '-');
                                                                @endphp
                                                                <tr>
                                                                    <td class="text-nowrap small text-secondary">{{ $time }}</td>
                                                                    <td>
                                                                        <span class="{{ $isIn ? 'badge-in' : 'badge-out' }}">
                                                                            <i class="bi {{ $isIn ? 'bi-arrow-down-circle' : 'bi-arrow-up-circle' }} me-1"></i>{{ strtoupper($item->jenis) }}
                                                                        </span>
                                                                    </td>
                                                                    <td>
                                                                        <div class="fw-semibold small">{{ $spareName }}</div>
                                                                        <div class="small-muted small text-truncate-td" title="{{ $valveList }}">{{ $valveList }}</div>
                                                                    </td>
                                                                    <td class="text-end">{{ number_format($item->material->stock_awal ?? 0) }}</td>
                                                                    <td class="text-end fw-bold {{ $isIn ? 'text-success' : 'text-danger' }}">{{ $isIn ? '+' : '-' }}{{ number_format($item->qty) }}</td>
                                                                    <td class="text-end fw-semibold">{{ number_format($item->stock_after ?? 0) }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>

        <!-- MONTHLY CHART -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light fw-bold">📊 Grafik Bulanan — Barang Masuk & Keluar</div>
            <div class="card-body">
                <canvas id="monthlyChart" height="110" aria-label="Grafik barang masuk dan keluar per bulan"></canvas>
            </div>
        </div>

    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @php
        // Prepare small spark arrays safely to avoid Blade/PHP parsing issues
        $sparkIn = [0,0,0,0,0];
        $sparkOut = [0,0,0,0,0];

        if (!empty($monthlyData) && (is_array($monthlyData) || $monthlyData instanceof \Illuminate\Support\Collection)) {
            $coll = collect($monthlyData);
            $inArr = $coll->pluck('in')->all();
            $outArr = $coll->pluck('out')->all();

            $sIn = array_values(array_slice($inArr, -8));
            $sOut = array_values(array_slice($outArr, -8));

            if (!empty($sIn)) $sparkIn = $sIn;
            if (!empty($sOut)) $sparkOut = $sOut;
        }
        // Use same sparklines for total/material placeholders (adjust as needed)
        $sparkTotalMaterial = $sparkIn;
        $sparkTotalStock = $sparkOut;
    @endphp

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Tooltip init (Bootstrap)
            var tt = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tt.forEach(function (el) { if (typeof bootstrap !== 'undefined') new bootstrap.Tooltip(el); });

            // Expand / Collapse All for history accordion
            const expandBtn = document.getElementById('expandAll');
            const collapseBtn = document.getElementById('collapseAll');
            const accordion = document.getElementById('{{ $accordionId ?? "historyAccordion" }}');
            const collapses = accordion ? accordion.querySelectorAll('.accordion-collapse') : [];

            expandBtn?.addEventListener('click', () => {
                collapses.forEach(c => { if (!c.classList.contains('show') && typeof bootstrap !== 'undefined') new bootstrap.Collapse(c, { toggle: true }); });
            });
            collapseBtn?.addEventListener('click', () => {
                collapses.forEach(c => { if (c.classList.contains('show') && typeof bootstrap !== 'undefined') new bootstrap.Collapse(c, { toggle: true }); });
            });

            // Small client-side search (fuzzy substring)
            const search = document.getElementById('historySearch');
            if (search) {
                search.addEventListener('input', function () {
                    const q = this.value.trim().toLowerCase();
                    const tables = accordion ? accordion.querySelectorAll('.history-table') : [];
                    tables.forEach(tbl => {
                        Array.from(tbl.tBodies[0].rows).forEach(r => {
                            const text = r.innerText.toLowerCase();
                            r.style.display = text.indexOf(q) > -1 ? '' : 'none';
                        });
                    });
                });
            }

            // KPI sparklines (tiny line charts) - using Chart.js lightweight config
            function createSpark(id, data = [], color = 'rgba(81,102,255,0.9)') {
                const el = document.getElementById(id);
                if (!el) return;
                new Chart(el.getContext('2d'), {
                    type: 'line',
                    data: { labels: data.map((_,i) => i+1), datasets: [{ data, borderColor: color, backgroundColor: 'transparent', tension: 0.3, borderWidth: 1.5, pointRadius: 0 }] },
                    options: { responsive: false, maintainAspectRatio: false, scales: { x: { display: false }, y: { display: false } }, plugins: { legend: { display: false }, tooltip: { enabled: false } } }
                });
            }

            // create sparklines (using safe PHP-prepared arrays)
            createSpark('sparkTotalMaterial', @json($sparkTotalMaterial), 'rgba(81,102,255,0.9)');
            createSpark('sparkTotalStock', @json($sparkTotalStock), 'rgba(16,185,129,0.9)');
            createSpark('sparkIn', @json($sparkIn), 'rgba(34,197,94,0.9)');
            createSpark('sparkOut', @json($sparkOut), 'rgba(239,68,68,0.9)');

            // MONTHLY CHART
            (function () {
                const ctx = document.getElementById('monthlyChart');
                if (!ctx) return;
                const chartData = @json($monthlyData ?? []);
                const labels = chartData.map(i => i.month);
                const dataIn = chartData.map(i => i.in || 0);
                const dataOut = chartData.map(i => i.out || 0);

                const formatNumber = (v) => new Intl.NumberFormat().format(v);

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels,
                        datasets: [
                            { label: 'Masuk', data: dataIn, backgroundColor: 'rgba(34,197,94,0.85)', borderRadius: 6 },
                            { label: 'Keluar', data: dataOut, backgroundColor: 'rgba(239,68,68,0.85)', borderRadius: 6 }
                        ]
                    },
                    options: {
                        responsive: true,
                        interaction: { mode: 'index', intersect: false },
                        scales: {
                            x: { grid: { display: false } },
                            y: {
                                beginAtZero: true,
                                ticks: { callback: v => formatNumber(v) }
                            }
                        },
                        plugins: {
                            legend: { position: 'bottom' },
                            tooltip: {
                                callbacks: {
                                    label: function (ctx) {
                                        let label = ctx.dataset.label || '';
                                        if (label) label += ': ';
                                        label += formatNumber(ctx.parsed.y);
                                        return label;
                                    }
                                }
                            }
                        }
                    }
                });
            })();
        });
    </script>
@endpush
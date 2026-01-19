@extends('layouts.admin')
@section('title', 'Dashboard Inventory | MCI')

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        :root {
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
            background: linear-gradient(135deg, rgba(81, 102, 255, 0.08), rgba(81, 102, 255, 0.02));
            color: var(--accent-1);
            font-size: 1.25rem;
        }

        .small-muted {
            color: var(--muted);
            font-size: .92rem;
        }

        .chip {
            display: inline-block;
            padding: .22rem .5rem;
            border-radius: 999px;
            font-size: .78rem;
            background: #f1f5f9;
            color: #0f172a;
            margin-right: .25rem;
        }

        .low-stock-row {
            background: linear-gradient(90deg, rgba(255, 243, 205, 0.45), rgba(255, 255, 255, 0));
        }

        .table thead th {
            position: sticky;
            top: 0;
            backdrop-filter: blur(4px);
            z-index: 3;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.96), rgba(255, 255, 255, 0.92));
        }

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

        .history-day {
            border-radius: 12px;
            margin-bottom: 0.8rem;
            overflow: hidden;
            box-shadow: 0 6px 18px rgba(6, 8, 15, 0.04);
            background: #fff;
        }

        .history-day .hd-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            padding: .85rem 1rem;
            border-bottom: 1px solid rgba(15, 23, 42, 0.04);
        }

        .hd-summary {
            color: var(--muted);
            font-size: .92rem;
        }

        .text-truncate-td {
            max-width: 28ch;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        @media (max-width: 767px) {
            .stat-icon {
                width: 48px;
                height: 48px;
                font-size: 1.1rem;
            }

            .kpi-spark {
                width: 56px;
                height: 24px;
            }
        }

        .table-hover tbody tr:hover {
            background-color: rgba(6, 8, 15, 0.03);
        }

        .muted-quiet {
            color: #94a3b8;
            font-size: .92rem;
        }
    </style>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- HEADER -->
        <div
            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
            <div>
                <h4 class="fw-bold mb-0">📦 Dashboard Inventory</h4>
                <div class="small-muted">Ringkasan stok, aktivitas terakhir, dan peringatan stok rendah — tampilan lebih rapi
                    dan mudah dibaca.</div>
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
                        <div class="stat-icon" style="color:#16a34a; background:linear-gradient(135deg,#ecfdf5,#f1fbf6)"><i
                                class="bi bi-box-seam"></i></div>
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
                        <div class="stat-icon" style="color:#0ea5e9; background:linear-gradient(135deg,#eff8ff,#f4fbff)"><i
                                class="bi bi-arrow-down-square"></i></div>
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
                        <div class="stat-icon" style="color:#ef4444; background:linear-gradient(135deg,#fff5f5,#fff8f8)"><i
                                class="bi bi-arrow-up-square"></i></div>
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
        <!-- ENHANCED MONTHLY CHART -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <div class="fw-bold">📊 Grafik Bulanan — Barang Masuk, Keluar & Net</div>
                <div class="d-flex gap-2 align-items-center">
                    <button id="downloadChart" class="btn btn-outline-secondary btn-sm">Download PNG</button>
                </div>
            </div>

            <div class="card-body">
                <canvas id="monthlyChart" height="140" aria-label="Grafik barang masuk dan keluar per bulan"></canvas>
            </div>
        </div>

        <!-- LOW STOCK -->
        <div class="row g-3 mb-4">
            <div class="col-lg-12">
                <div class="card shadow-sm h-100">
                    <div class="card-header d-flex justify-content-between align-items-center bg-light">
                        <div class="fw-bold">⚠️ Stok Rendah</div>
                        <div class="small-muted">Daftar item di bawah threshold</div>
                    </div>

                    <div class="card-body p-0">
                        @if ($lowStock->isEmpty())
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
                                        @foreach ($lowStock as $m)
                                            @php
                                                $pct =
                                                    $m->min_stock > 0
                                                        ? min(100, round(($m->stock / $m->min_stock) * 100))
                                                        : 0;
                                            @endphp
                                            <tr class="{{ $m->stock <= $m->min_stock ? 'low-stock-row' : '' }}">
                                                <td>
                                                    <div class="fw-semibold">{{ $m->material_code ?? $m->spare_part_name }}
                                                    </div>
                                                    <div class="small-muted">
                                                        {{ Str::limit($m->description ?? $m->spare_part_name, 60) }}</div>
                                                </td>
                                                <td class="text-center fw-bold">{{ number_format($m->stock) }}</td>
                                                <td class="text-end">
                                                    <div class="d-flex align-items-center gap-2 justify-content-end">
                                                        <div class="small-muted me-2 text-nowrap">{{ $pct }}%
                                                        </div>
                                                        <div class="progress w-50" style="height:8px; border-radius:6px;">
                                                            <div class="progress-bar @if ($pct <= 30) bg-danger @elseif($pct <= 60) bg-warning @else bg-success @endif"
                                                                role="progressbar" style="width:{{ $pct }}%">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="p-3 border-top d-flex justify-content-between align-items-center">
                                <div class="muted-quiet">Menampilkan {{ $lowStock->count() }} item dengan stok rendah
                                </div>
                                <div>
                                    <a href="{{ route('materials.low') }}" class="btn btn-outline-primary btn-sm">Lihat
                                        semua</a>
                                    <a href="{{ route('materials.restock') }}" class="btn btn-primary btn-sm">Buat PO
                                        Restock</a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- RECENT ACTIVITY (filter Masuk/Keluar dihapus) -->
        <div class="row g-3 mb-4">
            <div class="col-lg-12">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-light d-flex align-items-center justify-content-between flex-wrap">
                        <div>
                            <i class="bi bi-clock-history me-2"></i>
                            <span class="fw-bold">Riwayat Transaksi Terbaru</span>
                            <div class="small-muted">Terbaru pertama — setiap tanggal tampil sebagai blok terbuka</div>
                        </div>

                        <div class="d-flex gap-2 align-items-center mt-2 mt-md-0">
                            <div class="input-group input-group-sm" style="min-width:240px;">
                                <span class="input-group-text">🔎</span>
                                <input id="historySearch" type="search" class="form-control form-control-sm"
                                    placeholder="Cari (spare / kode / keterangan)">
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-3">
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
                            @endphp

                            <div id="historyList">
                                @foreach ($groupedHistory as $date => $items)
                                    @php
                                        $totalIn = $items->where('jenis', 'in')->sum('qty');
                                        $totalOut = $items->where('jenis', 'out')->sum('qty');
                                        $safeId = 'grp-' . \Illuminate\Support\Str::slug($date);
                                    @endphp

                                    <div class="history-day" data-date-group="{{ $safeId }}">
                                        <div class="hd-header">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="fw-semibold"><i class="bi bi-calendar-event me-2"></i>
                                                    {{ $date }}</div>
                                                <div class="hd-summary">
                                                    <span class="me-3"><strong
                                                            class="text-success">+{{ number_format($totalIn) }}</strong>
                                                        in</span>
                                                    <span class="me-3"><strong
                                                            class="text-danger">-{{ number_format($totalOut) }}</strong>
                                                        out</span>
                                                    <span class="text-muted">({{ $items->count() }} transaksi)</span>
                                                </div>
                                            </div>

                                            <div class="d-flex align-items-center gap-2">
                                                <div class="muted-quiet me-2">Tampilan: semua transaksi tanggal ini</div>
                                            </div>
                                        </div>

                                        <div class="p-0" id="body-{{ $safeId }}">
                                            <div class="table-responsive">
                                                <table class="table table-sm table-hover align-middle mb-0 history-table"
                                                    data-group="{{ $safeId }}">
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
                                                                $time = \Carbon\Carbon::parse($item->date_in)->format(
                                                                    'H:i',
                                                                );
                                                                $isIn = $item->jenis === 'in';
                                                                $valveList = optional($item->material->valves)
                                                                    ->pluck('valve_name')
                                                                    ->join(', ');
                                                                $spareName =
                                                                    optional($item->material->sparePart)
                                                                        ->spare_part_name ??
                                                                    ($item->material->material_code ?? '-');
                                                            @endphp
                                                            <tr data-kind="{{ $isIn ? 'in' : 'out' }}">
                                                                <td class="text-nowrap small text-secondary">
                                                                    {{ $time }}</td>
                                                                <td>
                                                                    <span class="{{ $isIn ? 'badge-in' : 'badge-out' }}">
                                                                        <i
                                                                            class="bi {{ $isIn ? 'bi-arrow-down-circle' : 'bi-arrow-up-circle' }} me-1"></i>{{ strtoupper($item->jenis) }}
                                                                    </span>
                                                                </td>
                                                                <td>
                                                                    <div class="fw-semibold small">{{ $spareName }}
                                                                    </div>
                                                                    <div class="small-muted small text-truncate-td"
                                                                        title="{{ $valveList }}">{{ $valveList }}
                                                                    </div>
                                                                </td>
                                                                <td class="text-end">
                                                                    {{ number_format($item->material->stock_awal ?? 0) }}
                                                                </td>
                                                                <td
                                                                    class="text-end fw-bold {{ $isIn ? 'text-success' : 'text-danger' }}">
                                                                    {{ $isIn ? '+' : '-' }}{{ number_format($item->qty) }}
                                                                </td>
                                                                <td class="text-end fw-semibold">
                                                                    {{ number_format($item->stock_after ?? 0) }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
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

    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @php
        $sparkIn = [0, 0, 0, 0, 0];
        $sparkOut = [0, 0, 0, 0, 0];

        if (
            !empty($monthlyData) &&
            (is_array($monthlyData) || $monthlyData instanceof \Illuminate\Support\Collection)
        ) {
            $coll = collect($monthlyData);
            $inArr = $coll->pluck('in')->all();
            $outArr = $coll->pluck('out')->all();

            $sIn = array_values(array_slice($inArr, -8));
            $sOut = array_values(array_slice($outArr, -8));

            if (!empty($sIn)) {
                $sparkIn = $sIn;
            }
            if (!empty($sOut)) {
                $sparkOut = $sOut;
            }
        }
        $sparkTotalMaterial = $sparkIn;
        $sparkTotalStock = $sparkOut;
    @endphp

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Sparklines
            function createSpark(id, data = [], color = 'rgba(81,102,255,0.9)') {
                const el = document.getElementById(id);
                if (!el) return;
                new Chart(el.getContext('2d'), {
                    type: 'line',
                    data: {
                        labels: data.map((_, i) => i + 1),
                        datasets: [{
                            data,
                            borderColor: color,
                            backgroundColor: 'transparent',
                            tension: 0.35,
                            borderWidth: 1.6,
                            pointRadius: 0
                        }]
                    },
                    options: {
                        responsive: false,
                        maintainAspectRatio: false,
                        scales: {
                            x: {
                                display: false
                            },
                            y: {
                                display: false
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                enabled: false
                            }
                        }
                    }
                });
            }

            createSpark('sparkTotalMaterial', @json($sparkTotalMaterial), 'rgba(81,102,255,0.9)');
            createSpark('sparkTotalStock', @json($sparkTotalStock), 'rgba(16,185,129,0.9)');
            createSpark('sparkIn', @json($sparkIn), 'rgba(34,197,94,0.9)');
            createSpark('sparkOut', @json($sparkOut), 'rgba(239,68,68,0.9)');

            // Monthly enhanced chart
            (function() {
                const ctx = document.getElementById('monthlyChart');
                if (!ctx) return;
                const chartData = @json($monthlyData ?? []);
                const labels = chartData.map(i => i.month);
                const dataIn = chartData.map(i => i.in || 0);
                const dataOut = chartData.map(i => i.out || 0);
                const dataNet = chartData.map(i => (i.in || 0) - (i.out || 0));

                const gradientBlue = ctx.getContext('2d').createLinearGradient(0, 0, 0, 200);
                gradientBlue.addColorStop(0, 'rgba(81,102,255,0.18)');
                gradientBlue.addColorStop(1, 'rgba(81,102,255,0.02)');

                const formatNumber = (v) => new Intl.NumberFormat().format(v);

                new Chart(ctx.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels,
                        datasets: [{
                                type: 'bar',
                                label: 'Masuk',
                                data: dataIn,
                                backgroundColor: 'rgba(34,197,94,0.85)',
                                borderRadius: 8,
                                barThickness: 'flex',
                                maxBarThickness: 28,
                            },
                            {
                                type: 'bar',
                                label: 'Keluar',
                                data: dataOut,
                                backgroundColor: 'rgba(239,68,68,0.85)',
                                borderRadius: 8,
                                barThickness: 'flex',
                                maxBarThickness: 28,
                            },
                            {
                                type: 'line',
                                label: 'Net (Masuk−Keluar)',
                                data: dataNet,
                                borderColor: 'rgba(81,102,255,0.95)',
                                backgroundColor: gradientBlue,
                                tension: 0.35,
                                fill: true,
                                pointRadius: 3,
                                pointHoverRadius: 5,
                                borderWidth: 2,
                                yAxisID: 'y',
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: {
                            mode: 'index',
                            intersect: false
                        },
                        stacked: false,
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    maxRotation: 0,
                                    autoSkip: true,
                                    maxTicksLimit: 12
                                }
                            },
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: value => formatNumber(value)
                                },
                                grid: {
                                    color: 'rgba(15,23,42,0.06)'
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    usePointStyle: true,
                                    pointStyle: 'rectRounded'
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    title: (ctx) => ctx[0]?.label || '',
                                    label: (ctx) => {
                                        const lbl = ctx.dataset.label || '';
                                        return lbl + ': ' + formatNumber(ctx.parsed.y ?? ctx
                                        .parsed);
                                    },
                                    afterBody: (ctx) => {
                                        if (ctx[0] && (ctx[0].dataset.type === 'bar' || ctx[0]
                                                .dataset.type === undefined)) {
                                            const idx = ctx[0].dataIndex;
                                            const inVal = dataIn[idx] || 0;
                                            const outVal = dataOut[idx] || 0;
                                            const tot = inVal + outVal;
                                            if (tot > 0) {
                                                return `Komposisi: Masuk ${Math.round((inVal / tot) * 100)}% • Keluar ${Math.round((outVal / tot) * 100)}%`;
                                            }
                                        }
                                        return '';
                                    }
                                }
                            }
                        },
                        animation: {
                            duration: 700,
                            easing: 'cubicBezier(.2,.8,.2,1)'
                        },
                        layout: {
                            padding: {
                                top: 6,
                                bottom: 6
                            }
                        }
                    }
                });

                document.getElementById('downloadChart')?.addEventListener('click', function() {
                    const link = document.createElement('a');
                    link.href = ctx.toDataURL('image/png', 1);
                    link.download = 'grafik-bulanan-inventory.png';
                    link.click();
                });
            })();

            // History: hanya pencarian client-side (filter Masuk/Keluar dihapus)
            const searchInput = document.getElementById('historySearch');
            const historyList = document.getElementById('historyList');

            function applySearch() {
                const q = (searchInput?.value || '').trim().toLowerCase();
                const dayCards = historyList ? historyList.querySelectorAll('.history-day') : [];

                dayCards.forEach(card => {
                    const group = card.querySelector('table.history-table');
                    const rows = group ? Array.from(group.tBodies[0].rows) : [];
                    let anyVisible = false;

                    rows.forEach(r => {
                        const rowText = r.innerText.toLowerCase();
                        const matchesSearch = q === '' ? true : rowText.indexOf(q) > -1;
                        r.style.display = matchesSearch ? '' : 'none';
                        if (matchesSearch) anyVisible = true;
                    });

                    card.style.display = anyVisible ? '' : 'none';
                });
            }

            searchInput?.addEventListener('input', () => applySearch());

            // Initial apply (in case search has default value)
            applySearch();
        });
    </script>
@endpush

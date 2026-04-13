@extends('layouts.admin')
@section('title', 'Dashboard Inventory | MCI')

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=JetBrains+Mono:wght@500;700;800&display=swap"
        rel="stylesheet">

    <style>
        /* ========== ULTRA PREMIUM BENTO SYSTEM ========== */
        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --primary-soft: #eff6ff;
            --success: #10b981;
            --success-light: #dcfce7;
            --warning: #f59e0b;
            --warning-light: #fef3c7;
            --danger: #ef4444;
            --danger-light: #fee2e2;
            --info: #0ea5e9;
            --info-light: #e0f2fe;

            --bg-body: #f8fafc;
            --surface: rgba(255, 255, 255, 0.9);
            --text-main: #0f172a;
            --text-muted: #64748b;
            --border-color: rgba(226, 232, 240, 0.8);

            --radius-bento: 2rem;
            /* Extreme rounded for Bento */
            --radius-md: 1rem;
            --radius-sm: 0.75rem;

            --shadow-bento: 0 10px 40px -10px rgba(0, 0, 0, 0.05);
            --shadow-hover: 0 20px 40px -10px rgba(37, 99, 235, 0.1);
            --inner-glow: inset 0 1px 0 0 rgba(255, 255, 255, 1);

            --transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-main);
            /* Premium Mesh/Dot Pattern */
            background-image: radial-gradient(#cbd5e1 1.2px, transparent 1.2px);
            background-size: 32px 32px;
            -webkit-font-smoothing: antialiased;
        }

        .container-p-y {
            padding-top: 2.5rem !important;
            padding-bottom: 2.5rem !important;
        }

        /* ============== BENTO GRID LAYOUT ============== */
        .bento-grid {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .bento-card {
            background: var(--surface);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: var(--radius-bento);
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-bento), var(--inner-glow);
            padding: 1.75rem;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .bento-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-hover), var(--inner-glow);
            border-color: rgba(255, 255, 255, 0.9);
        }

        /* Span Helpers */
        .col-span-3 {
            grid-column: span 3;
        }

        .col-span-4 {
            grid-column: span 4;
        }

        .col-span-8 {
            grid-column: span 8;
        }

        .col-span-12 {
            grid-column: span 12;
        }

        /* ============== PAGE HEADER ============== */
        .page-title h2 {
            font-weight: 900;
            color: var(--text-main);
            letter-spacing: -0.04em;
            font-size: 2.2rem;
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 0.5rem;
        }

        .page-title .subtitle {
            color: var(--text-muted);
            font-size: 1rem;
            font-weight: 500;
        }

        /* ============== KPI CARDS ============== */
        .kpi-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
        }

        .kpi-icon {
            width: 48px;
            height: 48px;
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            box-shadow: inset 0 2px 4px rgba(255, 255, 255, 0.3);
        }

        .icon-primary {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        }

        .icon-success {
            background: linear-gradient(135deg, #10b981, #047857);
        }

        .icon-info {
            background: linear-gradient(135deg, #0ea5e9, #0369a1);
        }

        .icon-danger {
            background: linear-gradient(135deg, #ef4444, #b91c1c);
        }

        .kpi-title {
            font-size: 0.7rem;
            font-weight: 800;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }

        .kpi-value {
            font-size: 2.2rem;
            font-weight: 900;
            color: var(--text-main);
            letter-spacing: -0.03em;
            line-height: 1;
            margin: 0.5rem 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .kpi-spark-container {
            height: 40px;
            width: 100%;
            margin-top: auto;
        }

        /* ============== ACTION TILE (QUICK ACTIONS) ============== */
        .action-tile {
            background: linear-gradient(135deg, #0f172a, #1e293b);
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .action-tile::after {
            content: '\F1B2';
            /* Box icon code */
            font-family: "bootstrap-icons";
            position: absolute;
            right: -20px;
            bottom: -30px;
            font-size: 12rem;
            opacity: 0.05;
            pointer-events: none;
        }

        .btn-bento {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 0.8rem;
            border-radius: 1rem;
            font-weight: 700;
            font-size: 0.9rem;
            text-decoration: none;
            transition: var(--transition);
            border: none;
            z-index: 2;
        }

        .btn-bento-success {
            background: rgba(16, 185, 129, 0.15);
            color: #34d399;
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .btn-bento-success:hover {
            background: #10b981;
            color: white;
        }

        .btn-bento-danger {
            background: rgba(239, 68, 68, 0.15);
            color: #f87171;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .btn-bento-danger:hover {
            background: #ef4444;
            color: white;
        }

        .btn-bento-white {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
        }

        .btn-bento-white:hover {
            background: white;
            color: #0f172a;
        }

        /* ============== CHART & HISTORY ============== */
        .bento-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .bento-title {
            font-size: 1.1rem;
            font-weight: 900;
            color: var(--text-main);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Search Input */
        .search-pill {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #f1f5f9;
            border-radius: 999px;
            padding: 0.6rem 1.2rem;
            transition: var(--transition);
            border: 1px solid transparent;
        }

        .search-pill:focus-within {
            background: white;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px var(--primary-soft);
        }

        .search-pill input {
            border: none;
            background: transparent;
            outline: none;
            font-size: 0.9rem;
            font-weight: 600;
            width: 200px;
        }

        /* Table Resets */
        .table-responsive {
            border-radius: var(--radius-md);
            overflow: hidden;
            border: 1px solid var(--border-color);
        }

        .table {
            margin-bottom: 0;
        }

        .table th {
            background: #f8fafc;
            font-size: 0.7rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-muted);
            padding: 1.2rem 1.5rem;
            border-bottom: 1px solid var(--border-color);
        }

        .table td {
            padding: 1.2rem 1.5rem;
            vertical-align: middle;
            font-size: 0.9rem;
            font-weight: 600;
            border-bottom: 1px solid #f1f5f9;
        }

        /* History Day Group */
        .history-day {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 1.5rem;
            margin-bottom: 1.5rem;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.02);
        }

        .hd-header {
            background: #f8fafc;
            padding: 1.2rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--border-color);
        }

        .hd-date {
            font-weight: 800;
            color: var(--text-main);
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Badges & Stock Boxes */
        .badge-soft {
            padding: 6px 12px;
            border-radius: 10px;
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge-in {
            background: var(--success-light);
            color: #059669;
        }

        .badge-out {
            background: var(--danger-light);
            color: #dc2626;
        }

        .stock-box {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 6px 12px;
            border-radius: 10px;
            font-family: 'JetBrains Mono', monospace;
            font-weight: 800;
            font-size: 0.9rem;
            min-width: 65px;
        }

        .stock-box.before {
            background: #f1f5f9;
            color: #475569;
        }

        .stock-box.change.in {
            background: var(--success-light);
            color: #059669;
        }

        .stock-box.change.out {
            background: var(--danger-light);
            color: #dc2626;
        }

        .stock-box.after {
            background: var(--primary-soft);
            color: var(--primary-dark);
            font-size: 1rem;
            border: 1px solid #bfdbfe;
        }

        /* Responsive Breakpoints */
        @media (max-width: 1024px) {
            .col-span-3 {
                grid-column: span 6;
            }

            .col-span-4 {
                grid-column: span 12;
            }

            .col-span-8 {
                grid-column: span 12;
            }
        }

        @media (max-width: 768px) {

            .col-span-3,
            .col-span-4,
            .col-span-8,
            .col-span-12 {
                grid-column: span 12;
            }

            .page-title h2 {
                font-size: 1.75rem;
            }

            .hd-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .search-pill {
                width: 100%;
            }

            .search-pill input {
                width: 100%;
            }
        }
    </style>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="mb-5">
            <div class="page-title">
                <h2><i class="bi bi-box-seam text-primary"></i> Dashboard Inventory</h2>
                <div class="subtitle">Pantau stok material, visualisasi mutasi barang, dan kelola aktivitas gudang secara
                    *real-time*.</div>
            </div>
        </div>

        <div class="bento-grid">

            <div class="bento-card col-span-3 d-flex flex-column">
                <div class="kpi-header">
                    <div class="kpi-title">Total Material</div>
                    <div class="kpi-icon icon-primary"><i class="bi bi-boxes"></i></div>
                </div>
                <h5 class="kpi-value">{{ number_format($totalMaterials ?? 0) }}</h5>
                <div class="kpi-spark-container"><canvas id="sparkTotalMaterial"></canvas></div>
            </div>

            <div class="bento-card col-span-3 d-flex flex-column">
                <div class="kpi-header">
                    <div class="kpi-title">Total Stok Fisik</div>
                    <div class="kpi-icon icon-success"><i class="bi bi-layers"></i></div>
                </div>
                <h5 class="kpi-value text-success">{{ number_format($totalStock ?? 0) }}</h5>
                <div class="kpi-spark-container"><canvas id="sparkTotalStock"></canvas></div>
            </div>

            <div class="bento-card col-span-3 d-flex flex-column">
                <div class="kpi-header">
                    <div class="kpi-title">Masuk (Bulan Ini)</div>
                    <div class="kpi-icon icon-info"><i class="bi bi-arrow-down-left-square"></i></div>
                </div>
                <h5 class="kpi-value text-info">{{ number_format($totalIn ?? 0) }}</h5>
                <div class="kpi-spark-container"><canvas id="sparkIn"></canvas></div>
            </div>

            <div class="bento-card col-span-3 d-flex flex-column">
                <div class="kpi-header">
                    <div class="kpi-title">Keluar (Bulan Ini)</div>
                    <div class="kpi-icon icon-danger"><i class="bi bi-arrow-up-right-square"></i></div>
                </div>
                <h5 class="kpi-value text-danger">{{ number_format($totalOut ?? 0) }}</h5>
                <div class="kpi-spark-container"><canvas id="sparkOut"></canvas></div>
            </div>

            <div class="bento-card col-span-8">
                <div class="bento-header">
                    <h5 class="bento-title"><i class="bi bi-bar-chart-line text-primary"></i> Grafik Alur Mutasi Bulanan
                    </h5>
                    <button id="downloadChart" class="btn btn-light btn-sm fw-bold rounded-pill border shadow-sm px-3">
                        <i class="bi bi-download me-1"></i> Unduh PDF
                    </button>
                </div>
                <div style="position: relative; height: 320px; width: 100%;">
                    <canvas id="monthlyChart"></canvas>
                </div>
            </div>

            <div class="bento-card action-tile col-span-4">
                <div>
                    <h5 class="bento-title text-white mb-2"><i class="bi bi-lightning-charge-fill text-warning"></i> Quick
                        Actions</h5>
                    <p class="text-white-50" style="font-size: 0.85rem;">Akses cepat untuk pencatatan transaksi dan master
                        data.</p>
                </div>
                <div class="d-flex flex-column gap-3 mt-4">
                    <a href="{{ route('material_in.create') }}" class="btn-bento btn-bento-success">
                        <i class="bi bi-box-arrow-in-down fs-5"></i> Input Barang Masuk
                    </a>
                    <a href="{{ route('material_out.create') }}" class="btn-bento btn-bento-danger">
                        <i class="bi bi-box-arrow-up fs-5"></i> Input Barang Keluar
                    </a>
                    <a href="{{ route('materials.index') }}" class="btn-bento btn-bento-white">
                        <i class="bi bi-database fs-5"></i> Kelola Master Data
                    </a>
                </div>
            </div>

            <div class="bento-card col-span-12">
                <div class="bento-header">
                    <h5 class="bento-title"><i class="bi bi-clock-history text-primary"></i> Riwayat Transaksi Stok</h5>
                    <div class="search-pill shadow-sm">
                        <i class="bi bi-search"></i>
                        <input id="historySearch" type="search" placeholder="Cari nama material/part...">
                    </div>
                </div>

                <div class="mt-3">
                    @if ($history->isEmpty())
                        <div class="text-center text-muted py-5 mb-0 bg-light rounded-4">
                            <i class="bi bi-inbox text-secondary" style="font-size: 3.5rem; opacity:0.3;"></i>
                            <h6 class="mt-3 fw-bolder">Belum Ada Transaksi</h6>
                            <p class="small">Lakukan penerimaan atau pengeluaran barang untuk melihat riwayat mutasi.</p>
                        </div>
                    @else
                        @php
                            // Grouping by Date (Aman untuk PHP 7.4)
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
                                        <div class="hd-date">
                                            <div
                                                style="width:36px; height:36px; background:white; border-radius:10px; display:flex; align-items:center; justify-content:center; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                                                <i class="bi bi-calendar-event text-primary"></i></div>
                                            {{ $date }}
                                        </div>
                                        <div class="d-flex gap-2">
                                            <span class="badge-soft badge-in"><i class="bi bi-plus"></i>
                                                {{ number_format($totalIn) }} Masuk</span>
                                            <span class="badge-soft badge-out"><i class="bi bi-dash"></i>
                                                {{ number_format($totalOut) }} Keluar</span>
                                        </div>
                                    </div>

                                    <div class="table-responsive border-0 rounded-0">
                                        <table class="table table-hover mb-0 history-table"
                                            data-group="{{ $safeId }}">
                                            <thead>
                                                <tr>
                                                    <th width="8%">Jam</th>
                                                    <th width="12%">Aksi</th>
                                                    <th width="35%">Item / Spare Part</th>
                                                    <th width="15%" class="text-center">Stok Awal</th>
                                                    <th width="15%" class="text-center">Mutasi</th>
                                                    <th width="15%" class="text-center">Stok Akhir</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($items as $item)
                                                    @php
                                                        $time = \Carbon\Carbon::parse($item->date_in)->format('H:i');
                                                        $isIn = strtolower($item->jenis) === 'in';

                                                        $valveList = optional($item->material->valves)
                                                            ->pluck('valve_name')
                                                            ->join(', ');
                                                        $spareName =
                                                            optional($item->material->sparePart)->spare_part_name ??
                                                            ($item->material->material_code ?? '-');

                                                        $qty = isset($item->qty) ? (int) $item->qty : 0;

                                                        // LOGIKA PENCARIAN STOK SEBELUMNYA (PHP 7.4 SAFE)
                                                        if (isset($item->stock_before)) {
                                                            $stockBefore = (int) $item->stock_before;
                                                            $stockAfter = isset($item->stock_after)
                                                                ? (int) $item->stock_after
                                                                : ($isIn
                                                                    ? $stockBefore + $qty
                                                                    : $stockBefore - $qty);
                                                        } elseif (isset($item->stock_after)) {
                                                            $stockAfter = (int) $item->stock_after;
                                                            $stockBefore = $isIn
                                                                ? $stockAfter - $qty
                                                                : $stockAfter + $qty;
                                                        } else {
                                                            $stockBefore = 0;
                                                            $stockAfter = $qty;
                                                        }

                                                        $stockBefore = max(0, $stockBefore);
                                                        $stockAfter = max(0, $stockAfter);
                                                    @endphp

                                                    <tr>
                                                        <td class="text-muted fw-bold"
                                                            style="font-family: 'JetBrains Mono', monospace;">
                                                            {{ $time }}</td>
                                                        <td>
                                                            <span
                                                                class="badge-soft {{ $isIn ? 'badge-in' : 'badge-out' }}">
                                                                <i
                                                                    class="bi {{ $isIn ? 'bi-box-arrow-in-down' : 'bi-box-arrow-up' }}"></i>
                                                                {{ strtoupper($item->jenis) }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <div class="fw-bolder text-dark">{{ $spareName }}</div>
                                                            <div class="text-muted"
                                                                style="font-size: 0.75rem; max-width: 300px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"
                                                                title="{{ $valveList }}">
                                                                <i class="bi bi-tag me-1"></i>
                                                                {{ $valveList ?: 'Tidak ada referensi valve' }}
                                                            </div>
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="stock-box before" title="Stok Sebelum Transaksi">
                                                                {{ number_format($stockBefore) }}</div>
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="stock-box change {{ $isIn ? 'in' : 'out' }}"
                                                                title="Jumlah Perubahan">
                                                                {{ $isIn ? '+' : '-' }}{{ number_format($qty) }}</div>
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="stock-box after" title="Stok Setelah Transaksi">
                                                                {{ number_format($stockAfter) }}</div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @php
        // Persiapan Data Chart & Sparkline
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
            Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";

            // 1. Fungsi Pembuat Sparkline untuk Bento Card
            function createSpark(id, data = [], color = 'rgba(37,99,235,0.9)', fill = false) {
                const el = document.getElementById(id);
                if (!el) return;

                const ctx = el.getContext('2d');
                let gradient = 'transparent';

                if (fill) {
                    gradient = ctx.createLinearGradient(0, 0, 0, 40);
                    gradient.addColorStop(0, color.replace('1)', '0.2)'));
                    gradient.addColorStop(1, 'rgba(255,255,255,0)');
                }

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: data.map((_, i) => i + 1),
                        datasets: [{
                            data,
                            borderColor: color,
                            backgroundColor: gradient,
                            tension: 0.4,
                            borderWidth: 2.5,
                            pointRadius: 0,
                            fill: fill
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        layout: {
                            padding: {
                                top: 5,
                                bottom: 5
                            }
                        },
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

            createSpark('sparkTotalMaterial', @json($sparkTotalMaterial), '#2563eb', true);
            createSpark('sparkTotalStock', @json($sparkTotalStock), '#10b981', true);
            createSpark('sparkIn', @json($sparkIn), '#0ea5e9', true);
            createSpark('sparkOut', @json($sparkOut), '#ef4444', true);

            // 2. Main Monthly Chart
            const ctx = document.getElementById('monthlyChart');
            if (ctx) {
                const chartData = @json($monthlyData ?? []);
                const labels = chartData.map(i => i.month);
                const dataIn = chartData.map(i => i.in || 0);
                const dataOut = chartData.map(i => i.out || 0);
                const dataNet = chartData.map(i => (i.in || 0) - (i.out || 0));

                const gradientBlue = ctx.getContext('2d').createLinearGradient(0, 0, 0, 300);
                gradientBlue.addColorStop(0, 'rgba(37, 99, 235, 0.15)');
                gradientBlue.addColorStop(1, 'rgba(37, 99, 235, 0)');

                const formatNumber = (v) => new Intl.NumberFormat('id-ID').format(v);

                const myChart = new Chart(ctx.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels,
                        datasets: [{
                                type: 'bar',
                                label: 'Barang Masuk',
                                data: dataIn,
                                backgroundColor: '#10b981',
                                borderRadius: 8,
                                barThickness: 'flex',
                                maxBarThickness: 24
                            },
                            {
                                type: 'bar',
                                label: 'Barang Keluar',
                                data: dataOut,
                                backgroundColor: '#ef4444',
                                borderRadius: 8,
                                barThickness: 'flex',
                                maxBarThickness: 24
                            },
                            {
                                type: 'line',
                                label: 'Net (Selisih)',
                                data: dataNet,
                                borderColor: '#2563eb',
                                backgroundColor: gradientBlue,
                                tension: 0.4,
                                fill: true,
                                pointRadius: 5,
                                pointBackgroundColor: '#ffffff',
                                pointBorderColor: '#2563eb',
                                pointBorderWidth: 2,
                                borderWidth: 3
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
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    font: {
                                        weight: 700,
                                        size: 11
                                    },
                                    color: '#64748b'
                                }
                            },
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: '#f1f5f9',
                                    borderDash: [5, 5]
                                },
                                border: {
                                    display: false
                                },
                                ticks: {
                                    font: {
                                        weight: 600
                                    },
                                    color: '#94a3b8',
                                    callback: value => formatNumber(value)
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                position: 'top',
                                align: 'end',
                                labels: {
                                    usePointStyle: true,
                                    boxWidth: 10,
                                    font: {
                                        weight: 700
                                    }
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(15, 23, 42, 0.95)',
                                titleFont: {
                                    size: 13,
                                    weight: 800
                                },
                                bodyFont: {
                                    size: 12,
                                    weight: 600
                                },
                                padding: 12,
                                cornerRadius: 12,
                                callbacks: {
                                    label: (context) => {
                                        let label = context.dataset.label || '';
                                        if (label) label += ': ';
                                        if (context.parsed.y !== null) label += formatNumber(context
                                            .parsed.y);
                                        return label;
                                    }
                                }
                            }
                        }
                    }
                });

                document.getElementById('downloadChart')?.addEventListener('click', function() {
                    const link = document.createElement('a');
                    link.href = myChart.toBase64Image('image/png', 1);
                    link.download = 'Grafik_Mutasi_Inventory.png';
                    link.click();
                });
            }

            // 3. Smart Search History (Client-side)
            const searchInput = document.getElementById('historySearch');
            const historyList = document.getElementById('historyList');

            searchInput?.addEventListener('input', function() {
                const q = this.value.trim().toLowerCase();
                const dayCards = historyList ? historyList.querySelectorAll('.history-day') : [];

                dayCards.forEach(card => {
                    const group = card.querySelector('table.history-table');
                    const rows = group ? Array.from(group.tBodies[0].rows) : [];
                    let anyVisible = false;

                    rows.forEach(r => {
                        const rowText = r.innerText.toLowerCase();
                        const matches = q === '' || rowText.includes(q);
                        r.style.display = matches ? '' : 'none';
                        if (matches) anyVisible = true;
                    });

                    // Hide full card if no rows match inside it
                    card.style.display = anyVisible ? '' : 'none';
                });
            });
        });
    </script>
@endpush

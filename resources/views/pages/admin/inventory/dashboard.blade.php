@extends('layouts.admin')
@section('title', 'Dashboard Inventory | MCI')

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700;800&display=swap"
        rel="stylesheet">
    <style>
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
            --surface: #ffffff;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 16px;
            --shadow-sm: 0 1px 2px rgba(15, 23, 42, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(15, 23, 42, 0.05), 0 2px 4px -2px rgba(15, 23, 42, 0.05);
            --shadow-hover: 0 12px 25px -5px rgba(37, 99, 235, 0.1);
            --transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-main);
            -webkit-font-smoothing: antialiased;
        }

        .container-p-y {
            padding-top: 2rem !important;
            padding-bottom: 2rem !important;
        }

        /* ============== PAGE HEADER ============== */
        .page-title h4 {
            font-weight: 800;
            color: var(--text-main);
            letter-spacing: -0.02em;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .page-title .small-muted {
            color: var(--text-muted);
            font-size: 0.95rem;
            margin-top: 4px;
            font-weight: 500;
        }

        .action-btns .btn {
            border-radius: 999px;
            font-weight: 700;
            font-size: 0.85rem;
            padding: 0.5rem 1.25rem;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
            border: none;
        }

        .btn-success {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
        }

        .btn-danger {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
        }

        .btn-outline-secondary {
            background: var(--surface);
            color: var(--text-main);
            border: 1px solid var(--border-color);
        }

        .action-btns .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.08);
        }

        /* ============== KPI CARDS ============== */
        .card-hero {
            background: var(--surface);
            border-radius: var(--radius-lg);
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .card-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
        }

        .card-hero.total::before {
            background: var(--primary);
        }

        .card-hero.stock::before {
            background: var(--success);
        }

        .card-hero.in::before {
            background: var(--info);
        }

        .card-hero.out::before {
            background: var(--danger);
        }

        .card-hero:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-hover);
            border-color: #bfdbfe;
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            flex-shrink: 0;
        }

        .card-hero.total .stat-icon {
            background: #eff6ff;
            color: var(--primary);
        }

        .card-hero.stock .stat-icon {
            background: var(--success-light);
            color: var(--success);
        }

        .card-hero.in .stat-icon {
            background: var(--info-light);
            color: var(--info);
        }

        .card-hero.out .stat-icon {
            background: var(--danger-light);
            color: var(--danger);
        }

        .kpi-title {
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .kpi-value {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--text-main);
            line-height: 1;
            margin: 0;
            font-family: 'JetBrains Mono', monospace;
        }

        .kpi-desc {
            font-size: 0.75rem;
            color: var(--text-muted);
            margin-top: 4px;
        }

        .kpi-spark {
            width: 60px;
            height: 30px;
        }

        /* ============== CARDS & TABLES ============== */
        .modern-card {
            background: var(--surface);
            border-radius: var(--radius-lg);
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-sm);
            margin-bottom: 1.5rem;
            overflow: hidden;
        }

        .modern-card-header {
            background: #ffffff;
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .modern-card-title {
            font-size: 1.05rem;
            font-weight: 800;
            color: var(--text-main);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .modern-card-subtitle {
            font-size: 0.85rem;
            color: var(--text-muted);
            font-weight: 500;
            margin-top: 2px;
        }

        /* Table Resets */
        .table {
            margin-bottom: 0;
        }

        .table th {
            background: #f8fafc;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-muted);
            border-bottom: 1px solid var(--border-color);
            padding: 1rem 1.25rem;
            border-top: none;
        }

        .table td {
            padding: 1rem 1.25rem;
            vertical-align: middle;
            font-size: 0.9rem;
            color: var(--text-main);
            border-bottom: 1px solid #f1f5f9;
        }

        .table tbody tr {
            transition: background 0.2s;
        }

        .table tbody tr:hover {
            background: #f8fafc;
        }

        /* Badges */
        .badge-soft {
            padding: 0.35rem 0.75rem;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .badge-in {
            background: var(--success-light);
            color: #059669;
        }

        .badge-out {
            background: var(--danger-light);
            color: #dc2626;
        }

        /* Stock Info Boxes */
        .stock-box {
            display: inline-block;
            padding: 0.4rem 0.8rem;
            border-radius: 8px;
            font-family: 'JetBrains Mono', monospace;
            font-weight: 800;
            font-size: 0.9rem;
            min-width: 65px;
            text-align: center;
        }

        .stock-box.before {
            background: #f1f5f9;
            color: #475569;
            border: 1px solid #cbd5e1;
        }

        .stock-box.change.in {
            background: var(--success-light);
            color: #059669;
            border: 1px solid #a7f3d0;
        }

        .stock-box.change.out {
            background: var(--danger-light);
            color: #dc2626;
            border: 1px solid #fecaca;
        }

        .stock-box.after {
            background: var(--primary-soft);
            color: var(--primary-dark);
            border: 1px solid #bfdbfe;
            font-size: 0.95rem;
        }

        /* Custom Progress Bar */
        .progress-custom {
            height: 8px;
            border-radius: 999px;
            background: var(--border-color);
            overflow: hidden;
            width: 100px;
        }

        .progress-custom .progress-bar {
            border-radius: 999px;
        }

        .low-stock-row td {
            background: #fffbeb !important;
        }

        .low-stock-row:hover td {
            background: #fef3c7 !important;
        }

        /* ============== HISTORY TIMELINE ============== */
        .history-day {
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            margin-bottom: 1.5rem;
            background: var(--surface);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.02);
            overflow: hidden;
        }

        .hd-header {
            background: #f8fafc;
            padding: 1rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--border-color);
        }

        .hd-date {
            font-weight: 800;
            color: var(--text-main);
            font-size: 0.95rem;
        }

        /* ============== SEARCH INPUT ============== */
        .search-input-wrapper {
            display: flex;
            align-items: center;
            gap: 8px;
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 999px;
            padding: 6px 16px;
            transition: var(--transition);
        }

        .search-input-wrapper:focus-within {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .search-input-wrapper input {
            border: none;
            outline: none;
            background: transparent;
            font-size: 0.85rem;
            width: 220px;
        }

        @media (max-width: 768px) {
            .page-title h4 {
                font-size: 1.5rem;
            }

            .action-btns {
                flex-wrap: wrap;
                width: 100%;
            }

            .action-btns .btn {
                flex: 1;
                justify-content: center;
            }

            .modern-card-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .search-input-wrapper,
            .search-input-wrapper input {
                width: 100%;
            }
        }
    </style>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <div
            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
            <div class="page-title">
                <h4 class="mb-0">📦 Dashboard Inventory</h4>
                <div class="small-muted">Ringkasan stok, visualisasi mutasi barang, dan peringatan batas minimum.</div>
            </div>

            <div class="d-flex gap-2 action-btns">
                <a href="{{ route('material_in.create') }}" class="btn btn-success d-flex align-items-center gap-2">
                    <i class="bi bi-box-arrow-in-down"></i> Material Masuk
                </a>
                <a href="{{ route('material_out.create') }}" class="btn btn-danger d-flex align-items-center gap-2">
                    <i class="bi bi-box-arrow-up"></i> Material Keluar
                </a>
                <a href="{{ route('materials.index') }}" class="btn btn-outline-secondary d-flex align-items-center gap-2">
                    <i class="bi bi-boxes"></i> Master Data
                </a>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-12 col-sm-6 col-md-3">
                <div class="card-hero total h-100 p-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stat-icon"><i class="bi bi-stack"></i></div>
                        <div class="flex-grow-1">
                            <div class="kpi-title">Total Material</div>
                            <div class="d-flex align-items-end justify-content-between">
                                <h5 class="kpi-value">{{ number_format($totalMaterials ?? 0) }}</h5>
                                <canvas class="kpi-spark" id="sparkTotalMaterial"></canvas>
                            </div>
                            <div class="kpi-desc">Item unik terdaftar</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="card-hero stock h-100 p-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stat-icon"><i class="bi bi-box-seam"></i></div>
                        <div class="flex-grow-1">
                            <div class="kpi-title">Total Stok Fisik</div>
                            <div class="d-flex align-items-end justify-content-between">
                                <h5 class="kpi-value text-success">{{ number_format($totalStock ?? 0) }}</h5>
                                <canvas class="kpi-spark" id="sparkTotalStock"></canvas>
                            </div>
                            <div class="kpi-desc">Seluruh unit di gudang</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="card-hero in h-100 p-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stat-icon"><i class="bi bi-arrow-down-square"></i></div>
                        <div class="flex-grow-1">
                            <div class="kpi-title">Masuk (Bulan Ini)</div>
                            <div class="d-flex align-items-end justify-content-between">
                                <h5 class="kpi-value text-info">{{ number_format($totalIn ?? 0) }}</h5>
                                <canvas class="kpi-spark" id="sparkIn"></canvas>
                            </div>
                            <div class="kpi-desc">Penambahan unit baru</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="card-hero out h-100 p-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="stat-icon"><i class="bi bi-arrow-up-square"></i></div>
                        <div class="flex-grow-1">
                            <div class="kpi-title">Keluar (Bulan Ini)</div>
                            <div class="d-flex align-items-end justify-content-between">
                                <h5 class="kpi-value text-danger">{{ number_format($totalOut ?? 0) }}</h5>
                                <canvas class="kpi-spark" id="sparkOut"></canvas>
                            </div>
                            <div class="kpi-desc">Unit yang telah dipakai</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modern-card">
            <div class="modern-card-header">
                <div>
                    <h5 class="modern-card-title">📊 Grafik Alur Barang Bulanan</h5>
                    <div class="modern-card-subtitle">Perbandingan barang masuk, keluar, dan selisih bersih.</div>
                </div>
                <button id="downloadChart" class="btn btn-outline-secondary btn-sm"
                    style="border-radius:8px; font-weight:600;">
                    <i class="bi bi-download me-1"></i> Unduh Laporan
                </button>
            </div>
            <div class="card-body p-4">
                <canvas id="monthlyChart" height="100"></canvas>
            </div>
        </div>

        {{-- <div class="modern-card border-warning">
            <div class="modern-card-header" style="background: #fffbeb; border-bottom-color: #fde68a;">
                <div>
                    <h5 class="modern-card-title text-warning" style="color: #d97706 !important;">
                        <i class="bi bi-exclamation-triangle-fill"></i> Peringatan Stok Rendah
                    </h5>
                    <div class="modern-card-subtitle" style="color: #92400e;">Item yang jumlah fisiknya mendekati atau di
                        bawah batas minimum.</div>
                </div>
            </div>

            <div class="card-body p-0">
                @if ($lowStock->isEmpty())
                    <div class="p-5 text-center text-muted">
                        <div
                            style="width: 80px; height: 80px; background: #dcfce7; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem auto;">
                            <i class="bi bi-check-circle-fill text-success" style="font-size: 2.5rem;"></i>
                        </div>
                        <h6 class="fw-bold text-dark">Kondisi Stok Aman</h6>
                        <p class="mb-0 font-size-sm">Semua material saat ini berada di atas batas minimum persediaan.</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th width="45%">Item Material / Spare Part</th>
                                    <th class="text-center" width="15%">Batas Min</th>
                                    <th class="text-center" width="15%">Sisa Stok</th>
                                    <th class="text-end" width="25%">Kapasitas</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($lowStock as $m)
                                    @php
                                        $pct =
                                            $m->min_stock > 0 ? min(100, round(($m->stock / $m->min_stock) * 100)) : 0;
                                        $isCritical = $m->stock <= $m->min_stock / 2;
                                        $barColor = $isCritical ? 'bg-danger' : 'bg-warning';
                                        $textColor = $isCritical ? 'text-danger' : 'text-warning';
                                    @endphp
                                    <tr class="low-stock-row">
                                        <td>
                                            <div class="fw-bold text-dark">{{ $m->material_code ?? $m->spare_part_name }}
                                            </div>
                                            <div class="text-muted" style="font-size: 0.8rem;">
                                                {{ Str::limit($m->description ?? $m->spare_part_name, 70) }}</div>
                                        </td>
                                        <td class="text-center text-muted fw-semibold">{{ number_format($m->min_stock) }}
                                        </td>
                                        <td class="text-center">
                                            <span
                                                class="fs-6 fw-bolder {{ $textColor }}">{{ number_format($m->stock) }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-3 justify-content-end">
                                                <div class="fw-bold {{ $textColor }}" style="font-size:0.8rem;">
                                                    {{ $pct }}%</div>
                                                <div class="progress-custom">
                                                    <div class="progress-bar {{ $barColor }}" role="progressbar"
                                                        style="width:{{ $pct }}%"></div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="p-3 border-top d-flex justify-content-between align-items-center bg-light">
                        <div class="text-muted" style="font-size: 0.85rem; font-weight:600;">Menampilkan
                            {{ $lowStock->count() }} item kritis.</div>
                        <a href="{{ route('materials.restock') ?? '#' }}"
                            class="btn btn-warning btn-sm rounded-pill fw-bold px-4" style="color: #92400e;">Buat PO
                            Restock</a>
                    </div>
                @endif
            </div>
        </div> --}}

        <div class="modern-card">
            <div class="modern-card-header">
                <div>
                    <h5 class="modern-card-title"><i class="bi bi-clock-history text-primary"></i> Riwayat Transaksi Stok
                    </h5>
                    <div class="modern-card-subtitle">Lacak perubahan stok sebelum dan sesudah transaksi secara jelas.
                    </div>
                </div>
                <div class="search-input-wrapper">
                    <i class="bi bi-search text-muted"></i>
                    <input id="historySearch" type="search" placeholder="Cari material/sparepart...">
                </div>
            </div>

            <div class="card-body p-4 bg-light">
                @if ($history->isEmpty())
                    <div class="text-center text-muted py-5 mb-0">
                        <i class="bi bi-inbox" style="font-size: 3rem; opacity:0.5;"></i>
                        <h6 class="mt-3 fw-bold">Belum ada transaksi</h6>
                        <p class="small">Lakukan penerimaan atau pengeluaran barang untuk melihat riwayat mutasi.</p>
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
                                    <div class="hd-date"><i
                                            class="bi bi-calendar2-day-fill text-primary me-2"></i>{{ $date }}
                                    </div>
                                    <div>
                                        <span
                                            class="badge bg-success-subtle text-success border border-success-subtle me-2 px-2 py-1 rounded-pill">+{{ number_format($totalIn) }}
                                            Masuk</span>
                                        <span
                                            class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1 rounded-pill">-{{ number_format($totalOut) }}
                                            Keluar</span>
                                    </div>
                                </div>

                                <div class="table-responsive bg-white">
                                    <table class="table table-hover mb-0 history-table" data-group="{{ $safeId }}">
                                        <thead>
                                            <tr>
                                                <th width="8%">Jam</th>
                                                <th width="12%">Aksi</th>
                                                <th width="35%">Item / Spare Part</th>
                                                <th width="15%" class="text-center">Stok Sebelumnya</th>
                                                <th width="15%" class="text-center">Mutasi (Qty)</th>
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

                                                    // LOGIKA PENCARIAN STOK SEBELUMNYA
                                                    // Jika ada kolom 'stock_before' atau 'stok_awal' di database, pakai itu
                                                    if (isset($item->stock_before)) {
                                                        $stockBefore = (int) $item->stock_before;
                                                        $stockAfter = isset($item->stock_after)
                                                            ? (int) $item->stock_after
                                                            : ($isIn
                                                                ? $stockBefore + $qty
                                                                : $stockBefore - $qty);
                                                    }
                                                    // Jika cuma ada 'stock_after', hitung mundur
                                                    elseif (isset($item->stock_after)) {
                                                        $stockAfter = (int) $item->stock_after;
                                                        $stockBefore = $isIn ? $stockAfter - $qty : $stockAfter + $qty;
                                                    }
                                                    // Fallback murni
                                                    else {
                                                        $stockBefore = 0;
                                                        $stockAfter = $qty;
                                                    }

                                                    // Mencegah nilai negatif jika ada anomali database
                                                    $stockBefore = max(0, $stockBefore);
                                                    $stockAfter = max(0, $stockAfter);
                                                @endphp

                                                <tr>
                                                    <td class="text-muted fw-bold"
                                                        style="font-family: 'JetBrains Mono', monospace;">
                                                        {{ $time }}</td>
                                                    <td>
                                                        <span class="badge-soft {{ $isIn ? 'badge-in' : 'badge-out' }}">
                                                            <i
                                                                class="bi {{ $isIn ? 'bi-box-arrow-in-down' : 'bi-box-arrow-up' }}"></i>
                                                            {{ strtoupper($item->jenis) }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="fw-bold text-dark">{{ $spareName }}</div>
                                                        <div class="text-muted"
                                                            style="font-size: 0.75rem; max-width: 300px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"
                                                            title="{{ $valveList }}">
                                                            {{ $valveList ?: 'Tidak ada referensi valve' }}</div>
                                                    </td>

                                                    {{-- KOLOM STOK TERPISAH DENGAN BADGE --}}
                                                    <td class="text-center">
                                                        <div class="stock-box before" title="Stok Sebelum Transaksi">
                                                            {{ number_format($stockBefore) }}
                                                        </div>
                                                    </td>

                                                    <td class="text-center">
                                                        <div class="stock-box change {{ $isIn ? 'in' : 'out' }}"
                                                            title="Jumlah Perubahan">
                                                            {{ $isIn ? '+' : '-' }}{{ number_format($qty) }}
                                                        </div>
                                                    </td>

                                                    <td class="text-center">
                                                        <div class="stock-box after" title="Stok Setelah Transaksi">
                                                            {{ number_format($stockAfter) }}
                                                        </div>
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
            Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";

            // 1. Sparklines for KPI Cards
            function createSpark(id, data = [], color = 'rgba(37,99,235,0.9)') {
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
                            tension: 0.4,
                            borderWidth: 2,
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

            createSpark('sparkTotalMaterial', @json($sparkTotalMaterial), '#2563eb');
            createSpark('sparkTotalStock', @json($sparkTotalStock), '#10b981');
            createSpark('sparkIn', @json($sparkIn), '#0ea5e9');
            createSpark('sparkOut', @json($sparkOut), '#ef4444');

            // 2. Main Monthly Chart
            const ctx = document.getElementById('monthlyChart');
            if (ctx) {
                const chartData = @json($monthlyData ?? []);
                const labels = chartData.map(i => i.month);
                const dataIn = chartData.map(i => i.in || 0);
                const dataOut = chartData.map(i => i.out || 0);
                const dataNet = chartData.map(i => (i.in || 0) - (i.out || 0));

                const gradientBlue = ctx.getContext('2d').createLinearGradient(0, 0, 0, 200);
                gradientBlue.addColorStop(0, 'rgba(37, 99, 235, 0.2)');
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
                                borderRadius: 6,
                                barThickness: 'flex',
                                maxBarThickness: 20
                            },
                            {
                                type: 'bar',
                                label: 'Barang Keluar',
                                data: dataOut,
                                backgroundColor: '#ef4444',
                                borderRadius: 6,
                                barThickness: 'flex',
                                maxBarThickness: 20
                            },
                            {
                                type: 'line',
                                label: 'Net (Selisih)',
                                data: dataNet,
                                borderColor: '#2563eb',
                                backgroundColor: gradientBlue,
                                tension: 0.4,
                                fill: true,
                                pointRadius: 4,
                                pointBackgroundColor: '#fff',
                                pointBorderColor: '#2563eb',
                                pointBorderWidth: 2,
                                borderWidth: 2
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
                                        weight: 600
                                    }
                                }
                            },
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: '#e2e8f0',
                                    borderDash: [5, 5]
                                },
                                ticks: {
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
                                    boxWidth: 8,
                                    font: {
                                        weight: 600
                                    }
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(15, 23, 42, 0.9)',
                                padding: 10,
                                cornerRadius: 8,
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
                    link.download = 'Laporan_Mutasi_Bulanan.png';
                    link.click();
                });
            }

            // 3. Smart Search History Client-side
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

                    card.style.display = anyVisible ? '' : 'none';
                });
            });
        });
    </script>
@endpush

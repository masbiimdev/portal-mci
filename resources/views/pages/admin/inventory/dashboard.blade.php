@extends('layouts.admin')
@section('title', 'Dashboard Inventory | MCI')

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        /* Dashboard tweaks */
        .card-hero {
            border-left: 4px solid rgba(81, 102, 255, 0.95);
            transition: transform .12s ease, box-shadow .12s ease;
        }

        .card-hero:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 30px rgba(6, 8, 15, 0.06);
        }

        .stat-icon {
            width: 56px;
            height: 56px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #eef2ff, #f4f8ff);
            color: #3b82f6;
            font-size: 1.5rem;
        }

        .low-stock-row {
            background: linear-gradient(90deg, rgba(255, 243, 205, 0.45), rgba(255, 255, 255, 0));
        }

        .table thead th {
            position: sticky;
            top: 0;
            backdrop-filter: blur(4px);
            z-index: 2;
        }

        .small-muted {
            color: #6b7280;
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

        .search-input {
            max-width: 420px;
        }

        .action-btns .btn {
            min-width: 110px;
        }

        /* responsive tweaks for small screens */
        @media (max-width:575px) {
            .stat-icon {
                width: 48px;
                height: 48px;
                font-size: 1.2rem;
            }

            .action-btns .btn {
                min-width: unset;
                padding-left: .6rem;
                padding-right: .6rem;
            }
        }
    </style>
    <style>
        /* Soft badge backgrounds (works well with Bootstrap) */
        .bg-soft-success {
            background-color: rgba(25, 135, 84, 0.08);
        }

        .bg-soft-danger {
            background-color: rgba(220, 53, 69, 0.08);
        }

        /* Improve the accordion button look (less tall) */
        .accordion-button {
            padding: .5rem 1rem;
        }

        /* Truncate long texts nicely */
        .text-truncate {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* Table row hover subtle */
        .table-hover tbody tr:hover {
            background-color: rgba(0, 0, 0, 0.02);
        }
    </style>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        {{-- Header & Action --}}
        <div
            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
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
                        <div class="stat-icon" style="color:#16a34a; background:linear-gradient(135deg,#ecfdf5,#f1fbf6)"><i
                                class="bi bi-box-seam"></i></div>
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
                        <div class="stat-icon" style="color:#0ea5e9; background:linear-gradient(135deg,#eff8ff,#f4fbff)"><i
                                class="bi bi-arrow-down-square"></i></div>
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
                        <div class="stat-icon" style="color:#ef4444; background:linear-gradient(135deg,#fff5f5,#fff8f8)"><i
                                class="bi bi-arrow-up-square"></i></div>
                        <div>
                            <div class="small-muted">Barang Keluar</div>
                            <h5 class="fw-bold mb-0 text-danger">{{ number_format($totalOut) }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Stok Minimum --}}
        

        {{-- Riwayat Transaksi --}}
        {{-- Riwayat Transaksi Material (diperbagus) --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light d-flex align-items-center justify-content-between">
                <div>
                    <i class="bi bi-clock-history me-2"></i>
                    <span class="fw-bold">Riwayat Transaksi Material</span>
                </div>

                {{-- Tombol collapse semua (opsional) --}}
                <div class="ms-3">
                    <button class="btn btn-sm btn-outline-secondary me-1" id="expandAll">Buka Semua</button>
                    <button class="btn btn-sm btn-outline-secondary" id="collapseAll">Tutup Semua</button>
                </div>
            </div>

            <div class="card-body p-0">
                @if ($history->isEmpty())
                    <div class="text-center text-muted py-5 mb-0">
                        <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                        <div class="h6 mb-1">Belum ada transaksi</div>
                        <div class="small">Silakan tambah transaksi untuk melihat riwayat.</div>
                    </div>
                @else
                    @php
                        // Sebaiknya grouping dilakukan di controller, tapi fallback di sini bila belum:
                        $groupedHistory = isset($groupedHistory)
                            ? $groupedHistory
                            : $history->groupBy(function ($item) {
                                return \Carbon\Carbon::parse($item->date_in)->translatedFormat('d F Y');
                            });
                        $accordionId = 'historyAccordion';
                    @endphp

                    <div class="accordion" id="{{ $accordionId }}">
                        @foreach ($groupedHistory as $date => $items)
                            @php
                                // Hitung ringkasan per-tanggal
                                $totalIn = $items->where('jenis', 'in')->sum('qty');
                                $totalOut = $items->where('jenis', 'out')->sum('qty');
                                $net = $totalIn - $totalOut;
                                $safeId = 'grp-' . \Illuminate\Support\Str::slug($date);
                            @endphp

                            <div class="accordion-item border-0">
                                <h2 class="accordion-header" id="heading-{{ $safeId }}">
                                    <button class="accordion-button collapsed bg-light px-3 py-2" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapse-{{ $safeId }}"
                                        aria-expanded="false" aria-controls="collapse-{{ $safeId }}">
                                        <div class="d-flex w-100 align-items-center justify-content-between">
                                            <div class="fw-semibold">
                                                <i class="bi bi-calendar-event me-2"></i> {{ $date }}
                                            </div>

                                            <div class="small text-muted d-flex gap-3 align-items-center">
                                                <div><span
                                                        class="text-success fw-bold">+{{ number_format($totalIn) }}</span>
                                                    in</div>
                                                <div><span
                                                        class="text-danger fw-bold">-{{ number_format($totalOut) }}</span>
                                                    out</div>
                                                <div>Net: <span
                                                        class="fw-semibold">{{ $net >= 0 ? '+' : '' }}{{ number_format($net) }}</span>
                                                </div>
                                                <div class="text-muted">({{ $items->count() }} transaksi)</div>
                                            </div>
                                        </div>
                                    </button>
                                </h2>

                                <div id="collapse-{{ $safeId }}" class="accordion-collapse collapse"
                                    aria-labelledby="heading-{{ $safeId }}" data-bs-parent="#{{ $accordionId }}">
                                    <div class="accordion-body p-0">
                                        <div class="table-responsive">
                                            <table class="table table-sm table-hover align-middle mb-0">
                                                <thead class="text-muted small">
                                                    <tr>
                                                        <th style="width:85px">Jam</th>
                                                        <th style="width:110px">Jenis</th>
                                                        <th>Material</th>
                                                        <th class="text-end" style="width:110px">Stok Awal</th>
                                                        <th class="text-end" style="width:110px">Perubahan</th>
                                                        <th class="text-end" style="width:110px">Stok Akhir</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    @foreach ($items as $item)
                                                        @php
                                                            $time = \Carbon\Carbon::parse($item->date_in)->format(
                                                                'H:i',
                                                            );
                                                            $jenis = $item->jenis === 'in' ? 'in' : 'out';
                                                            $changeSign = $jenis === 'in' ? '+' : '-';
                                                            $changeClass =
                                                                $jenis === 'in' ? 'text-success' : 'text-danger';
                                                            $valveList = optional($item->material->valves)
                                                                ->pluck('valve_name')
                                                                ->join(', ');
                                                            $spareName = optional($item->material->sparePart)
                                                                ->spare_part_name;
                                                            $materialCode = $item->material->material_code ?? '-';
                                                            $stockAwal = $item->material->stock_awal ?? 0;
                                                            $stockAfter = $item->stock_after ?? 0;
                                                            $notes = $item->notes ?: '-';
                                                        @endphp

                                                        <tr>
                                                            {{-- Jam --}}
                                                            <td class="text-nowrap small text-secondary">
                                                                {{ $time }}
                                                            </td>

                                                            {{-- Jenis --}}
                                                            <td>
                                                                <span
                                                                    class="badge {{ $jenis === 'in' ? 'bg-soft-success text-success' : 'bg-soft-danger text-danger' }} d-inline-flex align-items-center py-1 px-2"
                                                                    style="border-radius:0.5rem;">
                                                                    <i
                                                                        class="bi {{ $jenis === 'in' ? 'bi-arrow-down-circle-fill me-1' : 'bi-arrow-up-circle-fill me-1' }}"></i>
                                                                    <span
                                                                        class="fw-semibold">{{ strtoupper($jenis) }}</span>
                                                                </span>
                                                            </td>

                                                            {{-- Material --}}
                                                            <td>
                                                                <div class="fw-semibold small">
                                                                    {{ $spareName }}
                                                                </div>
                                                                <div class="small text-muted text-truncate"
                                                                    style="max-width:36ch;">
                                                                    {!! $valveList !!}
                                                                </div>
                                                            </td>

                                                            {{-- Stok Awal --}}
                                                            <td class="text-end small text-secondary">
                                                                {{ number_format($stockAwal) }}
                                                            </td>

                                                            {{-- Perubahan --}}
                                                            <td class="fw-bold text-end {{ $changeClass }}">
                                                                {{ $changeSign }}{{ number_format($item->qty) }}
                                                            </td>

                                                            {{-- Stok Akhir --}}
                                                            <td class="text-end fw-semibold small">
                                                                {{ number_format($stockAfter) }}
                                                            </td>

                                                            {{-- Keterangan --}}
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div> {{-- .table-responsive --}}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div> {{-- .accordion --}}
                @endif
            </div>
        </div>


        {{-- Grafik --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light fw-bold">
                📈 Grafik Barang Masuk & Keluar (Per Bulan)
            </div>
            <div class="card-body">
                <canvas id="inventoryChart" height="120"
                    aria-label="Grafik barang masuk dan keluar per bulan"></canvas>
            </div>
        </div>

    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // small client-side search for history table
        (function() {
            const search = document.getElementById('historySearch');
            const table = document.getElementById('historyTable');
            if (!search || !table) return;
            const rows = Array.from(table.tBodies[0].rows);

            search.addEventListener('input', function() {
                const q = this.value.trim().toLowerCase();
                rows.forEach(r => {
                    const text = r.innerText.toLowerCase();
                    r.style.display = text.indexOf(q) > -1 ? '' : 'none';
                });
            });
        })();

        // Chart
        (function() {
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
                    datasets: [{
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
                            grid: {
                                display: false
                            }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return formatNumber(value);
                                }
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(ctx) {
                                    let label = ctx.dataset.label || '';
                                    if (label) label += ': ';
                                    label += formatNumber(ctx.parsed.y);
                                    return label;
                                }
                            }
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        })();
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tooltip
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.forEach(function(el) {
                new bootstrap.Tooltip(el);
            });

            // Expand / Collapse All
            const expandBtn = document.getElementById('expandAll');
            const collapseBtn = document.getElementById('collapseAll');
            const collapses = document.querySelectorAll('#{{ $accordionId }} .accordion-collapse');

            expandBtn?.addEventListener('click', () => {
                collapses.forEach(c => {
                    if (!c.classList.contains('show')) {
                        new bootstrap.Collapse(c, {
                            toggle: true
                        });
                    }
                });
            });
            collapseBtn?.addEventListener('click', () => {
                collapses.forEach(c => {
                    if (c.classList.contains('show')) {
                        new bootstrap.Collapse(c, {
                            toggle: true
                        });
                    }
                });
            });
        });
    </script>
@endpush

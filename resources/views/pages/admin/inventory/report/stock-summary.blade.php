@extends('layouts.admin')

@section('title', 'Stock Summary Report | MCI')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <style>
        /* Styling Area Filter */
        .filter-section {
            background-color: #f8f9fa;
            border: 1px dashed #d9dee3;
            border-radius: 0.5rem;
            padding: 1.25rem;
            margin-bottom: 1.5rem;
        }

        /* Styling Tabel */
        .table-custom> :not(caption)>*>* {
            padding: 0.85rem 1rem;
            vertical-align: middle;
            font-size: 0.875rem;
            /* 14px */
            white-space: nowrap;
            /* Mencegah teks turun ke bawah */
        }

        /* Header Tabel Custom Biru Dongker */
        #stockSummaryTable thead th {
            background-color: #003366 !important;
            color: #ffffff !important;
            font-weight: 600;
            text-align: center;
            border-bottom: none;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        /* Warna khusus untuk baris yang stoknya di bawah minimum */
        table.dataTable tbody tr.row-warning td {
            background-color: #fff5eb !important;
            /* Orange pastel/soft */
            color: #b05a00 !important;
        }

        /* Hover state untuk baris warning */
        table.dataTable tbody tr.row-warning:hover td {
            background-color: #ffe8d1 !important;
        }

        /* Memperbaiki z-index tabel agar tidak menutupi dropdown DataTables */
        .dataTables_wrapper .row {
            align-items: center;
            margin-bottom: 0.5rem;
        }
    </style>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
            <div>
                <h4 class="fw-bold mb-1">
                    <i class="bx bx-file-blank fs-3 align-middle text-primary me-2"></i>Report Kontrol Barang (KB)
                </h4>
                <p class="text-muted mb-0">Ringkasan pergerakan stok, opname, dan status material bulanan.</p>
            </div>

            <div class="d-flex gap-2">
                <button id="exportExcel" class="btn btn-success shadow-sm text-white">
                    <i class="bx bx-spreadsheet me-1"></i> Export Excel
                </button>
                <button id="exportPDF" class="btn btn-danger shadow-sm text-white">
                    <i class="bx bxs-file-pdf me-1"></i> Export PDF
                </button>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body">

                {{-- SECTION FILTER --}}
                <div class="filter-section">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-3">
                            <label class="form-label fw-semibold text-muted small">Periode Bulan</label>
                            <select id="filterMonth" class="form-select">
                                <option value="">-- Semua Bulan --</option>
                                @foreach (range(1, 12) as $m)
                                    <option value="{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}"
                                        {{ request('bulan') == str_pad($m, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                                        {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold text-muted small">Tahun</label>
                            <select id="filterYear" class="form-select">
                                <option value="">-- Semua Tahun --</option>
                                @foreach (range(date('Y') - 5, date('Y')) as $y)
                                    <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>
                                        {{ $y }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 d-flex gap-2">
                            <button id="applyFilter" class="btn btn-primary text-white px-4">
                                <i class="bx bx-filter-alt me-1"></i> Terapkan
                            </button>
                            @if (request()->has('bulan') || request()->has('tahun'))
                                <button id="resetFilter" class="btn btn-outline-secondary px-3" data-bs-toggle="tooltip"
                                    title="Reset Filter">
                                    <i class="bx bx-reset"></i> Reset
                                </button>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- SECTION TABLE --}}
                <div class="card-datatable table-responsive">
                    <table id="stockSummaryTable" class="table table-hover table-bordered table-custom w-100">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Heat/Lot No</th>
                                <th>No Drawing</th>
                                <th>Valve</th>
                                <th>Spare Part</th>
                                <th>Dimensi</th>
                                <th class="text-end">Stock Awal</th>
                                <th class="text-end">Masuk</th>
                                <th class="text-end">Keluar</th>
                                <th class="text-end">Stock Akhir</th>
                                <th class="text-end">Stock Opname</th>
                                <th class="text-end">Selisih</th>
                                <th>Warning</th>
                                <th class="text-end">Stock Min.</th>
                                <th class="text-end">Balance</th>
                                <th>Posisi Barang</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($materials as $index => $row)
                                @php
                                    $material = $row['material'];
                                    // Pengecekan stok minimum
                                    $underMin = ($row['stock_akhir'] ?? 0) < ($material->stock_minimum ?? 0);

                                    // Format Valve Name
                                    $codes = $material->valves->pluck('valve_name');
                                    if ($codes->isNotEmpty()) {
                                        $grouped = $codes->groupBy(function ($code) {
                                            return substr($code, 0, strrpos($code, '.'));
                                        });
                                        $formattedGroups = $grouped->map(function ($items, $prefix) {
                                            $suffixes = $items->map(function ($c) {
                                                return substr($c, strrpos($c, '.') + 1);
                                            });
                                            return $prefix . '.' . $suffixes->join(',');
                                        });
                                        $valveFormatted = $formattedGroups->join(' ');
                                    } else {
                                        $valveFormatted = '-';
                                    }
                                @endphp

                                <tr class="{{ $underMin ? 'row-warning' : '' }}">
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td><span class="fw-semibold text-primary">{{ $material->heat_lot_no ?? '-' }}</span>
                                    </td>
                                    <td>{{ $material->no_drawing ?? '-' }}</td>
                                    <td>{{ $valveFormatted }}</td>
                                    <td>{{ $material->sparePart->spare_part_name ?? '-' }}</td>
                                    <td>{{ $material->dimensi ?? '-' }}</td>

                                    <td class="text-end">{{ $material->stock_awal ?? 0 }}</td>
                                    <td class="text-end text-success fw-semibold">
                                        {{ $row['qty_in'] > 0 ? '+' . $row['qty_in'] : 0 }}</td>
                                    <td class="text-end text-danger fw-semibold">
                                        {{ $row['qty_out'] > 0 ? '-' . $row['qty_out'] : 0 }}</td>
                                    <td class="text-end fw-bold {{ $underMin ? 'text-danger' : 'text-dark' }}">
                                        {{ $row['stock_akhir'] ?? 0 }}</td>
                                    <td class="text-end text-info fw-semibold">{{ $row['opname'] ?? '-' }}</td>
                                    <td class="text-end">{{ $row['selisih'] ?? '-' }}</td>

                                    <td>
                                        @if ($underMin)
                                            <i class="bx bx-error-circle text-danger me-1"></i>
                                            {{ $row['warning'] ?? 'Low Stock' }}
                                        @else
                                            {{ $row['warning'] ?? '-' }}
                                        @endif
                                    </td>
                                    <td class="text-end text-muted">{{ $material->stock_minimum ?? 0 }}</td>
                                    <td class="text-end">{{ $row['balance'] ?? 0 }}</td>
                                    <td>
                                        @if ($material->rack)
                                            <span class="badge bg-label-secondary"><i
                                                    class="bx bx-server me-1"></i>{{ $material->rack->rack_name }}</span>
                                        @else
                                            -
                                        @endif
                                    </td>
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
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            // Inisialisasi Tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });

            // Inisialisasi DataTables
            $('#stockSummaryTable').DataTable({
                scrollX: true, // WAJIB untuk tabel dengan banyak kolom agar bisa digeser horizontal
                paging: true,
                pageLength: 25,
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "Semua"]
                ],
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json',
                    emptyTable: "Tidak ada data untuk periode ini",
                },
                columnDefs: [{
                        orderable: false,
                        targets: [0]
                    } // Kolom No tidak usah di-sort
                ]
            });

            // Logika Apply Filter
            $('#applyFilter').on('click', function() {
                let bulan = $('#filterMonth').val();
                let tahun = $('#filterYear').val();

                let query = '';
                if (bulan) query += `bulan=${bulan}`;
                if (tahun) query += (query ? '&' : '') + `tahun=${tahun}`;

                // Tampilkan loading saat filter ditekan
                Swal.fire({
                    title: 'Memuat Data...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                window.location.href = query ? `?${query}` : window.location.pathname;
            });

            // Logika Reset Filter
            $('#resetFilter').on('click', function() {
                window.location.href = window.location.pathname;
            });

            // Logika Export
            function exportFile(type) {
                let bulan = $('#filterMonth').val();
                let tahun = $('#filterYear').val();

                if (!bulan || !tahun) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Filter Belum Lengkap!',
                        text: 'Silakan pilih bulan dan tahun terlebih dahulu untuk mendownload laporan.',
                        confirmButtonColor: '#003366',
                        confirmButtonText: 'Mengerti',
                        customClass: {
                            popup: 'rounded-4'
                        }
                    });
                    return;
                }

                const url = `/report/stock-summary/${type}?bulan=${bulan}&tahun=${tahun}`;
                window.open(url, '_blank');
            }

            $('#exportExcel').click(() => exportFile('excel'));
            $('#exportPDF').click(() => exportFile('pdf'));
        });
    </script>
@endpush

@extends('layouts.admin')

@section('title', 'Stock Summary Report')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <style>
        #stockSummaryTable thead th {
            background-color: #003366 !important;
            color: #fff !important;
            font-weight: 600;
            text-align: center;
            vertical-align: middle !important;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        #stockSummaryTable td {
            vertical-align: middle;
            font-size: 13px;
        }

        .row-warning {
            background-color: #fff2e6 !important;
        }
    </style>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold mb-4">Report Kontrol Barang (KB)</h4>

        <div class="card p-3 shadow-sm">

            {{-- FILTER --}}
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
                <div class="d-flex gap-2">
                    <select id="filterMonth" class="form-select form-select-sm">
                        <option value="">Semua Bulan</option>
                        @foreach (range(1, 12) as $m)
                            <option value="{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}"
                                {{ request('bulan') == str_pad($m, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                                {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                            </option>
                        @endforeach
                    </select>

                    <select id="filterYear" class="form-select form-select-sm">
                        <option value="">Semua Tahun</option>
                        @foreach (range(date('Y') - 5, date('Y')) as $y)
                            <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>
                                {{ $y }}</option>
                        @endforeach
                    </select>

                    <button id="applyFilter" class="btn btn-primary btn-sm">Terapkan</button>
                    <button id="resetFilter" class="btn btn-outline-secondary btn-sm">Reset</button>
                </div>

                {{-- EXPORT --}}
                <div class="d-flex gap-2">
                    <button id="exportExcel" class="btn btn-success btn-sm">
                        <i class="bx bx-spreadsheet"></i> Excel
                    </button>
                    <button id="exportPDF" class="btn btn-danger btn-sm">
                        <i class="bx bx-file"></i> PDF
                    </button>
                </div>
            </div>

            {{-- TABLE --}}
            <div class="table-responsive">
                <table id="stockSummaryTable" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Heat/Lot No</th>
                            <th>No Drawing</th>
                            <th>Valve</th>
                            <th>Spare Part</th>
                            <th>Dimensi</th>
                            <th>Stock Awal</th>
                            <th>Masuk</th>
                            <th>Keluar</th>
                            <th>Stock Akhir</th>
                            <th>Stock Opname</th>
                            <th>Selisih</th>
                            <th>Warning</th>
                            <th>Stock Minimum</th>
                            <th>Balance</th>
                            <th>Posisi Barang</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($materials as $index => $row)
                            @php
                                $material = $row['material'];
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
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $material->heat_lot_no ?? '-' }}</td>
                                <td>{{ $material->no_drawing ?? '-' }}</td>
                                <td>{{ $valveFormatted }}</td>
                                <td>{{ $material->sparePart->spare_part_name ?? '-' }}</td>
                                <td>{{ $material->dimensi ?? '-' }}</td>
                                <td>{{ $material->stock_awal ?? 0 }}</td>
                                <td>{{ $row['qty_in'] ?? 0 }}</td>
                                <td>{{ $row['qty_out'] ?? 0 }}</td>
                                <td>{{ $row['stock_akhir'] ?? 0 }}</td>
                                <td>{{ $row['opname'] ?? '-' }}</td>
                                <td>{{ $row['selisih'] ?? '-' }}</td>
                                <td>{{ $row['warning'] ?? '-' }}</td>
                                <td>{{ $material->stock_minimum ?? 0 }}</td>
                                <td>{{ $row['balance'] ?? 0 }}</td>
                                <td>{{ $material->rack->rack_name ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="15" class="text-center">Tidak ada data untuk periode ini</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $('#stockSummaryTable').DataTable({
                responsive: true,
                paging: true,
                language: {
                    emptyTable: "Tidak ada data",
                    zeroRecords: "Tidak ada data sesuai filter"
                }
            });

            // Apply Filter (reload page with params)
            $('#applyFilter').on('click', function() {
                let bulan = $('#filterMonth').val();
                let tahun = $('#filterYear').val();

                let query = '';
                if (bulan) query += `bulan=${bulan}`;
                if (tahun) query += (query ? '&' : '') + `tahun=${tahun}`;

                window.location.href = query ? `?${query}` : window.location.pathname;
            });

            // Reset Filter
            $('#resetFilter').on('click', function() {
                window.location.href = window.location.pathname;
            });

            // Export buttons
            function exportFile(type) {
                let bulan = $('#filterMonth').val();
                let tahun = $('#filterYear').val();

                if (!bulan || !tahun) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Filter Belum Lengkap!',
                        text: 'Silakan pilih bulan dan tahun terlebih dahulu sebelum export.',
                        confirmButtonColor: '#003366',
                        confirmButtonText: 'OK'
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

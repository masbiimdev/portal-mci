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
                            <option value="{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}">
                                {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                            </option>
                        @endforeach
                    </select>

                    <select id="filterYear" class="form-select form-select-sm">
                        <option value="">Semua Tahun</option>
                        @foreach (range(date('Y') - 5, date('Y')) as $y)
                            <option value="{{ $y }}">{{ $y }}</option>
                        @endforeach
                    </select>

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
                            <th class="d-none">Bulan</th> {{-- HIDDEN --}}
                            <th class="d-none">Tahun</th> {{-- HIDDEN --}}
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($materials as $index => $row)
                            @php
                                $material = $row['material'];
                                $underMin = ($row['stock_akhir'] ?? 0) < ($material->stock_minimum ?? 0);

                                // === Format Valve Name ===
                                $codes = $material->valves->pluck('valve_name');

                                if ($codes->count() > 0) {
                                    $first = $codes->first();
                                    $prefix = substr($first, 0, strrpos($first, '.'));

                                    $allSamePrefix = $codes->every(fn($code) => strpos($code, $prefix) === 0);

                                    if ($allSamePrefix) {
                                        $codes = $codes->map(fn($code) => substr($code, strrpos($code, '.') + 1));
                                        $valveFormatted = $prefix . '.' . $codes->join(', ');
                                    } else {
                                        $valveFormatted = $codes->join(', ');
                                    }
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

                                {{-- Hidden filter data --}}
                                <td class="d-none">{{ $row['bulan'] ?? date('m') }}</td>
                                <td class="d-none">{{ $row['tahun'] ?? date('Y') }}</td>
                            </tr>
                        @endforeach
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
            var table = $('#stockSummaryTable').DataTable({
                responsive: true,
                language: {
                    emptyTable: "Tidak ada data",
                    zeroRecords: "Tidak ada data sesuai filter"
                },
                columnDefs: [{
                    targets: [16, 17],
                    visible: false
                }]
            });

            function applyFilters() {
                var bulan = $('#filterMonth').val();
                var tahun = $('#filterYear').val();

                table.column(16).search(bulan ? '^' + bulan + '$' : '', true, false);
                table.column(17).search(tahun ? '^' + tahun + '$' : '', true, false);
                table.draw();
            }

            $('#filterMonth, #filterYear').on('change', applyFilters);

            $('#resetFilter').on('click', function() {
                $('#filterMonth, #filterYear').val('');
                table.column(16).search('');
                table.column(17).search('');
                table.draw();
            });

            function exportFile(type) {
                var bulan = $('#filterMonth').val();
                var tahun = $('#filterYear').val();

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

                window.location.href = `/report/stock-summary/${type}?bulan=${bulan}&tahun=${tahun}`;
            }

            $('#exportExcel').click(() => exportFile('excel'));
            $('#exportPDF').click(() => exportFile('pdf'));
        });
    </script>
@endpush

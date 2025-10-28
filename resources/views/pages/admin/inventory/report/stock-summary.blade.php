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

        .text-number {
            text-align: right !important;
            font-weight: 600;
        }

        .row-warning {
            background-color: #fff2e6 !important;
        }

        .badge-warning-custom {
            background-color: #e65c00;
            color: #fff;
            padding: 3px 6px;
            border-radius: 4px;
            font-size: 11px;
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
                            <th class="d-none">Bulan</th>
                            <th class="d-none">Tahun</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($materials as $index => $row)
                            @php
                                $material = $row['material'];
                                $bulan = \Carbon\Carbon::parse($row['tanggal'] ?? now())->format('m');
                                $tahun = \Carbon\Carbon::parse($row['tanggal'] ?? now())->format('Y');
                                $underMin = ($row['stock_akhir'] ?? 0) < ($material->stock_minimum ?? 0);
                            @endphp
                            <tr class="{{ $underMin ? 'row-warning' : '' }}">
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $material->heat_lot_no ?? '-' }}</td>
                                <td>{{ $material->no_drawing ?? '-' }}</td>
                                <td>{{ $material->valves->pluck('valve_name')->join(', ') ?: '-' }}</td>
                                <td>{{ $material->sparePart->spare_part_name ?? '-' }}</td>
                                <td>{{ $material->dimensi ?? '-' }}</td>
                                <td class="text-number">{{ $material->stock_awal ?? 0 }}</td>
                                <td class="text-number">{{ $row['qty_in'] ?? 0 }}</td>
                                <td class="text-number">{{ $row['qty_out'] ?? 0 }}</td>
                                <td class="text-number">{{ $row['stock_akhir'] ?? 0 }}</td>
                                <td class="text-number">{{ $row['opname'] ?? '-' }}</td>
                                <td class="text-number">{{ $row['selisih'] ?? '-' }}</td>
                                <td>
                                    @if ($row['warning'])
                                        {{ $row['warning'] }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="text-number">{{ $material->stock_minimum ?? 0 }}</td>
                                <td class="text-number">{{ $row['balance'] ?? 0 }}</td>
                                <td>{{ $material->rack->rack_name ?? '-' }}</td>
                                <td class="d-none">{{ $bulan }}</td>
                                <td class="d-none">{{ $tahun }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="18" class="text-center">Tidak ada data</td>
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
    {{-- ✅ Tambahkan SweetAlert2 --}}
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

            // ✅ Export Button (harus filter dulu)
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

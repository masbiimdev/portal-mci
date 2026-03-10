@extends('layouts.admin')

@section('title', 'Stock Movement Log | MCI')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <style>
        .filter-section {
            background-color: #f8f9fa;
            border: 1px dashed #d9dee3;
            border-radius: 0.5rem;
            padding: 1.25rem;
            margin-bottom: 1.5rem;
        }

        .table-custom> :not(caption)>*>* {
            padding: 1rem 1.25rem;
            vertical-align: middle;
        }

        /* Style untuk Material Info agar rapi */
        .mat-code {
            font-weight: 700;
            color: #696cff;
            display: block;
        }

        .mat-desc {
            font-size: 0.8rem;
            color: #a1acb8;
        }
    </style>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
            <div>
                <h4 class="fw-bold mb-1">
                    <i class="bx bx-transfer-alt fs-3 align-middle text-primary me-2"></i>Log Pergerakan Stok
                </h4>
                <p class="text-muted mb-0">Pantau semua aktivitas barang masuk dan keluar di gudang secara real-time.</p>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body">

                {{-- FILTER SECTION --}}
                <div class="filter-section">
                    <form method="GET" action="{{ route('report.stock-movement') }}" id="filterForm"
                        class="row g-3 align-items-end">
                        <div class="col-md-3">
                            <label class="form-label fw-semibold text-muted small">Tanggal Mulai</label>
                            <input type="date" name="start_date" id="start_date" class="form-control"
                                value="{{ request('start_date') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold text-muted small">Tanggal Akhir</label>
                            <input type="date" name="end_date" id="end_date" class="form-control"
                                value="{{ request('end_date') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold text-muted small">Jenis Transaksi</label>
                            <select name="type" id="type" class="form-select">
                                <option value="">Semua Transaksi</option>
                                <option value="IN" {{ request('type') == 'IN' ? 'selected' : '' }}>Barang Masuk (IN)
                                </option>
                                <option value="OUT" {{ request('type') == 'OUT' ? 'selected' : '' }}>Barang Keluar (OUT)
                                </option>
                            </select>
                        </div>
                        <div class="col-md-3 d-flex gap-2">
                            <button type="submit" class="btn btn-primary text-white flex-grow-1">
                                <i class="bx bx-filter-alt me-1"></i> Filter
                            </button>
                            @if (request()->anyFilled(['start_date', 'end_date', 'type']))
                                <a href="{{ route('report.stock-movement') }}" class="btn btn-outline-secondary"
                                    data-bs-toggle="tooltip" title="Reset Filter">
                                    <i class="bx bx-reset"></i>
                                </a>
                            @endif
                        </div>
                    </form>
                </div>

                {{-- TABLE SECTION --}}
                <div class="card-datatable table-responsive">
                    <table id="movementTable" class="table table-hover border-top w-100 table-custom">
                        <thead class="table-light">
                            <tr>
                                <th>Waktu Transaksi</th>
                                <th>Jenis</th>
                                <th>Info Material</th>
                                <th class="text-end">Kuantitas</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($movements as $mov)
                                @php
                                    $material = $mov['material'];
                                    $valveNames = implode(', ', $material->valves->pluck('valve_name')->toArray());
                                @endphp
                                <tr>
                                    <td>
                                        <span
                                            class="d-block fw-semibold text-dark">{{ \Carbon\Carbon::parse($mov['tanggal'])->format('d M Y') }}</span>
                                        <small class="text-muted"><i class="bx bx-time-five"></i>
                                            {{ \Carbon\Carbon::parse($mov['tanggal'])->format('H:i') }} WIB</small>
                                    </td>

                                    <td>
                                        @if ($mov['jenis'] == 'IN')
                                            <span class="badge bg-success text-white px-3 rounded-pill"><i
                                                    class="bx bx-down-arrow-alt me-1"></i> IN</span>
                                        @else
                                            <span class="badge bg-danger text-white px-3 rounded-pill"><i
                                                    class="bx bx-up-arrow-alt me-1"></i> OUT</span>
                                        @endif
                                    </td>

                                    <td>
                                        <span class="mat-code">{{ $material->material_code ?? '-' }}</span>
                                        <span class="mat-desc">
                                            {{ $valveNames ?: 'Tanpa Valve' }} |
                                            {{ $material->sparePart->spare_part_name ?? 'Tanpa Spare Part' }}
                                        </span>
                                    </td>

                                    <td
                                        class="text-end fw-bold fs-6 {{ $mov['jenis'] == 'IN' ? 'text-success' : 'text-danger' }}">
                                        {{ $mov['jenis'] == 'IN' ? '+' : '-' }}
                                        {{ number_format($mov['qty'], 0, ',', '.') }}
                                    </td>

                                    <td>
                                        <span class="d-block">{{ $mov['keterangan'] }}</span>
                                        <small class="text-muted">Oleh: {{ $mov['operator'] }}</small>
                                    </td>
                                </tr>
                            @empty
                            @endforelse
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
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            // Inisialisasi Tooltip
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });

            // Inisialisasi DataTables
            $('#movementTable').DataTable({
                responsive: true,
                pageLength: 25,
                lengthMenu: [
                    [10, 25, 50, 100],
                    [10, 25, 50, 100]
                ],
                order: [], // Dikosongkan agar mengikuti urutan asli dari Controller (terbaru di atas)
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json',
                    emptyTable: "Belum ada pergerakan stok yang tercatat."
                },
                columnDefs: [{
                    className: "text-nowrap",
                    targets: [0, 1, 3]
                }]
            });
        });
    </script>
@endpush

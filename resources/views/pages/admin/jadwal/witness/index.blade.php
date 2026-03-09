@extends('layouts.admin')
@section('title', 'Jadwal Witness | MCI')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8f9fa;
        }

        /* Card & Header */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }

        .card-title {
            font-weight: 700;
            color: #334155;
        }

        /* Modern Table */
        #activitiesTable {
            border: none !important;
            margin-top: 15px !important;
        }

        #activitiesTable thead th {
            background-color: #f1f5f9;
            color: #475569;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            border: none;
            padding: 15px;
        }

        #activitiesTable tbody td {
            padding: 12px 15px;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
            font-size: 0.85rem;
        }

        /* Status Pills */
        .badge-soft {
            padding: 6px 12px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 0.75rem;
            border: 1px solid transparent;
        }

        .badge-pending {
            background: #fff7ed;
            color: #c2410c;
            border-color: #ffedd5;
        }

        .badge-ongoing {
            background: #eff6ff;
            color: #1d4ed8;
            border-color: #dbeafe;
        }

        .badge-reschedule {
            background: #fef2f2;
            color: #dc2626;
            border-color: #fee2e2;
        }

        .badge-done {
            background: #f0fdf4;
            color: #166534;
            border-color: #dcfce7;
        }

        /* Custom List in Cell */
        .item-list {
            list-style: none;
            padding: 0;
            margin: 0;
            font-size: 0.8rem;
        }

        .item-list li {
            border-bottom: 1px dashed #e2e8f0;
            padding: 2px 0;
        }

        .item-list li:last-child {
            border: none;
        }

        /* Filter Section */
        .filter-section {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 25px;
        }

        /* Buttons */
        .btn-primary {
            background-color: #4f46e5;
            border: none;
            box-shadow: 0 4px 10px rgba(79, 70, 229, 0.25);
        }

        .btn-primary:hover {
            background-color: #4338ca;
            transform: translateY(-1px);
        }
    </style>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Activities /</span> Jadwal Witness
        </h4>

        {{-- 🔍 Filter Section --}}
        <div class="filter-section shadow-sm">
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label fw-bold small text-muted">CUSTOMER</label>
                    <select id="filterCustomer" class="form-select border-light-subtle shadow-none">
                        <option value="">Semua Customer</option>
                        @foreach ($activities->pluck('customer')->unique() as $cust)
                            <option value="{{ $cust }}">{{ $cust }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-bold small text-muted">STATUS</label>
                    <select id="filterStatus" class="form-select border-light-subtle shadow-none">
                        <option value="">Semua Status</option>
                        @foreach (['Pending', 'On Going', 'Reschedule', 'Done'] as $st)
                            <option value="{{ $st }}">{{ $st }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold small text-muted">RENTANG TANGGAL</label>
                    <div class="input-group">
                        <input type="date" id="filterStart" class="form-control border-light-subtle shadow-none" />
                        <span class="input-group-text bg-light border-light-subtle">s/d</span>
                        <input type="date" id="filterEnd" class="form-control border-light-subtle shadow-none" />
                    </div>
                </div>
                <div class="col-md-3">
                    <button id="resetFilter" class="btn btn-outline-secondary w-100 fw-bold">
                        <i class="bx bx-reset"></i> Reset Filter
                    </button>
                </div>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center bg-transparent border-bottom">
                <h5 class="mb-0 card-title">Daftar Kegiatan Kalibrasi / Witness</h5>
                <a href="{{ route('activities.create') }}" class="btn btn-primary">
                    <i class="bx bx-plus-circle me-1"></i> Tambah Kegiatan
                </a>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table id="activitiesTable" class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>Tanggal</th>
                                <th>Kegiatan</th>
                                <th>Customer</th>
                                <th>PO Number</th>
                                <th>Part Details</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $statusClasses = [
                                    'Pending' => 'badge-pending',
                                    'On Going' => 'badge-ongoing',
                                    'Reschedule' => 'badge-reschedule',
                                    'Done' => 'badge-done',
                                ];
                            @endphp

                            @foreach ($activities as $activity)
                                @php $items = json_decode($activity->items, true) ?? []; @endphp
                                <tr>
                                    <td>
                                        <span class="fw-bold text-primary">{{ strtoupper($activity->type) }}</span>
                                    </td>
                                    <td data-start="{{ $activity->start_date }}" data-end="{{ $activity->end_date }}">
                                        <div class="d-flex flex-column">
                                            <span
                                                class="fw-semibold text-dark">{{ \Carbon\Carbon::parse($activity->start_date)->format('d M Y') }}</span>
                                            <small class="text-muted">s/d
                                                {{ \Carbon\Carbon::parse($activity->end_date)->format('d M Y') }}</small>
                                        </div>
                                    </td>
                                    <td><span class="text-dark fw-medium">{{ $activity->kegiatan }}</span></td>
                                    <td>{{ $activity->customer }}</td>
                                    <td><code class="text-primary">{{ $activity->po ?? '-' }}</code></td>
                                    <td>
                                        @if (count($items))
                                            <ul class="item-list">
                                                @foreach ($items as $item)
                                                    <li>
                                                        <strong>{{ $item['qty'] ?? '0' }}</strong>
                                                        {{ $item['part_name'] ?? '-' }}
                                                        <small class="text-muted">({{ $item['material'] ?? '-' }})</small>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="badge-soft {{ $statusClasses[$activity->status] ?? 'bg-secondary' }}">
                                            {{ $activity->status }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2 justify-content-center">
                                            <a href="{{ route('activities.edit', $activity->id) }}"
                                                class="btn btn-sm btn-icon btn-outline-primary" title="Edit">
                                                <i class="bx bx-edit-alt"></i>
                                            </a>
                                            <form action="{{ route('activities.destroy', $activity->id) }}" method="POST"
                                                class="delete-form m-0">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-icon btn-outline-danger"
                                                    title="Hapus">
                                                    <i class="bx bx-trash"></i>
                                                </button>
                                            </form>
                                        </div>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            const table = $('#activitiesTable').DataTable({
                responsive: true,
                autoWidth: false,
                pageLength: 10,
                dom: '<"p-3 d-flex justify-content-between align-items-center"l f>t<"p-3 d-flex justify-content-between"i p>',
                language: {
                    search: "",
                    searchPlaceholder: "Cari kegiatan...",
                }
            });

            // Re-style search input
            $('.dataTables_filter input').addClass('form-control shadow-none border-light-subtle');

            function applyFilters() {
                const cust = $('#filterCustomer').val().toLowerCase();
                const status = $('#filterStatus').val().toLowerCase();
                const startDate = $('#filterStart').val();
                const endDate = $('#filterEnd').val();

                table.rows().every(function() {
                    const data = this.data();
                    const $row = $(this.node());
                    const dateCell = $row.find('td[data-start]');
                    const rowStart = dateCell.data('start');
                    const rowEnd = dateCell.data('end');

                    const matchCust = !cust || data[3].toLowerCase().includes(cust);
                    // Status is in index 6 now
                    const matchStatus = !status || data[6].toLowerCase().includes(status);

                    let matchDate = true;
                    if (startDate || endDate) {
                        const startCheck = !startDate || new Date(rowStart) >= new Date(startDate);
                        const endCheck = !endDate || new Date(rowEnd) <= new Date(endDate);
                        matchDate = startCheck && endCheck;
                    }

                    if (matchCust && matchStatus && matchDate) {
                        $row.show();
                    } else {
                        $row.hide();
                    }
                });
            }

            $('#filterCustomer, #filterStatus, #filterStart, #filterEnd').on('change keyup', applyFilters);

            $('#resetFilter').on('click', function() {
                $('#filterCustomer, #filterStatus, #filterStart, #filterEnd').val('');
                table.rows().show();
            });

            $('.delete-form').on('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Hapus data?',
                    text: "Tindakan ini tidak dapat dibatalkan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) this.submit();
                });
            });
        });
    </script>
@endpush

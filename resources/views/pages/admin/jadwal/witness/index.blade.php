@extends('layouts.admin')
@section('title')
    Jadwal Witness | MCI
@endsection

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <style>
        table.dataTable td,
        table.dataTable th {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .filter-section {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }
    </style>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Activities /</span> List
        </h4>

        <div class="card p-3">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="card-title">Daftar Kegiatan</h4>
                <a href="{{ route('activities.create') }}" class="btn btn-primary">+ Tambah</a>
            </div>

            {{-- 🔍 Filter Section --}}
            <div class="filter-section">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label for="filterCustomer" class="form-label fw-semibold">Customer</label>
                        <select id="filterCustomer" class="form-select">
                            <option value="">Semua</option>
                            @foreach ($activities->pluck('customer')->unique() as $cust)
                                <option value="{{ $cust }}">{{ $cust }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="filterStatus" class="form-label fw-semibold">Status</label>
                        <select id="filterStatus" class="form-select">
                            <option value="">Semua</option>
                            @foreach ($activities->pluck('status')->unique() as $status)
                                <option value="{{ $status }}">{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Tanggal</label>
                        <div class="d-flex gap-2">
                            <input type="date" id="filterStart" class="form-control" />
                            <input type="date" id="filterEnd" class="form-control" />
                        </div>
                    </div>
                </div>
                <div class="mt-3 text-end">
                    <button id="resetFilter" class="btn btn-secondary btn-sm">Reset Filter</button>
                </div>
            </div>

            {{-- 📋 Tabel --}}
            <div class="table-responsive">
                <table id="activitiesTable" class="table table-striped table-bordered table-hover">
                    <thead style="background-color: #f8f9fa; color: #212529; font-weight: 600;">
                        <tr>
                            <th class="text-center">Type</th>
                            <th class="text-center">Range Tanggal</th>
                            <th class="text-center">Kegiatan</th>
                            <th class="text-center">Customer</th>
                            <th class="text-center">PO</th>
                            <th class="text-center">Part Name</th>
                            <th class="text-center">QTY</th>
                            <th class="text-center">Heat No</th>
                            <th class="text-center">Material</th>
                            <th class="text-center">Remarks</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $statusColors = [
                                'Pending' => 'warning',
                                'On Going' => 'primary',
                                'Reschedule' => 'danger',
                                'Done' => 'success',
                            ];
                        @endphp

                        @foreach ($activities as $activity)
                            @php $items = json_decode($activity->items, true) ?? []; @endphp
                            <tr>
                                <td>{{ ucfirst($activity->type) }}</td>
                                <td data-start="{{ $activity->start_date }}" data-end="{{ $activity->end_date }}">
                                    {{ \Carbon\Carbon::parse($activity->start_date)->format('d M Y') }} -
                                    {{ \Carbon\Carbon::parse($activity->end_date)->format('d M Y') }}
                                </td>
                                <td>{{ $activity->kegiatan }}</td>
                                <td>{{ $activity->customer }}</td>
                                <td>{{ $activity->po ?? '-' }}</td>
                                <td>
                                    @if (count($items))
                                        <ul class="mb-0">
                                            @foreach ($items as $item)
                                                <li>{{ $item['part_name'] ?? '-' }}</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if (count($items))
                                        <ul class="mb-0">
                                            @foreach ($items as $item)
                                                <li>{{ $item['qty'] ?? '-' }}</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    @if (count($items))
                                        <ul class="mb-0">
                                            @foreach ($items as $item)
                                                <li>{{ $item['heat_no'] ?? '-' }}</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        {{ $activity->heat_no ?? '-' }}
                                    @endif
                                </td>
                                <td>
                                    @if (count($items))
                                        <ul class="mb-0">
                                            @foreach ($items as $item)
                                                <li>{{ $item['material'] ?? '-' }}</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        {{ $activity->material ?? '-' }}
                                    @endif
                                </td>
                                <td>{{ $activity->remarks ?? '-' }}</td>
                                <td>
                                    <span class="badge bg-{{ $statusColors[$activity->status] ?? 'secondary' }}">
                                        {{ $activity->status }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex gap-1 justify-content-center">
                                        <a href="{{ route('activities.edit', $activity->id) }}"
                                            class="btn btn-sm btn-primary">Edit</a>
                                        <form action="{{ route('activities.destroy', $activity->id) }}" method="POST"
                                            class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
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
                lengthMenu: [5, 10, 25, 50],
                columnDefs: [{ orderable: false, targets: 11 }]
            });

            // 🔍 Filter Function
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

                    const matchType = !type || data[0].toLowerCase().includes(type);
                    const matchCust = !cust || data[3].toLowerCase().includes(cust);
                    const matchStatus = !status || data[10].toLowerCase().includes(status);

                    let matchDate = true;
                    if (startDate || endDate) {
                        const startCheck = !startDate || new Date(rowStart) >= new Date(startDate);
                        const endCheck = !endDate || new Date(rowEnd) <= new Date(endDate);
                        matchDate = startCheck && endCheck;
                    }

                    if (matchType && matchCust && matchStatus && matchDate) {
                        $row.show();
                    } else {
                        $row.hide();
                    }
                });
            }

            $('#filterType, #filterCustomer, #filterStatus, #filterStart, #filterEnd').on('change keyup', applyFilters);

            $('#resetFilter').on('click', function() {
                $('#filterType, #filterCustomer, #filterStatus, #filterStart, #filterEnd').val('');
                table.rows().show();
            });

            // 🗑️ Konfirmasi Delete
            $('#activitiesTable tbody').on('submit', '.delete-form', function(e) {
                e.preventDefault();
                const form = this;

                Swal.fire({
                    title: 'Apakah kamu yakin?',
                    text: "Data yang dihapus tidak bisa dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) form.submit();
                });
            });

            // ✅ Notifikasi sukses
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    timer: 2500,
                    showConfirmButton: false
                });
            @endif
        });
    </script>
@endpush

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
            /* biar konten tidak wrap */
            overflow: hidden;
            /* sembunyikan overflow */
            text-overflow: ellipsis;
            /* ganti konten panjang dengan ... */
        }
    </style>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Activities /</span>
            List
        </h4>

        <div class="card p-3">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="card-title">Daftar Kegiatan</h4>
                <a href="{{ route('activities.create') }}" class="btn btn-primary">+</a>
            </div>

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
                            @php
                                $items = json_decode($activity->items, true) ?? [];
                            @endphp
                            <tr>
                                <td>{{ ucfirst($activity->type) }}</td>
                                <td>{{ \Carbon\Carbon::parse($activity->start_date)->format('d M Y') }} -
                                    {{ \Carbon\Carbon::parse($activity->end_date)->format('d M Y') }}</td>
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
                                <td>
                                    @if (count($items))
                                        <ul class="mb-0">
                                            @foreach ($items as $item)
                                                <li>{{ $item['remarks'] ?? '-' }}</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        {{ $activity->remarks ?? '-' }}
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-{{ $statusColors[$activity->status] ?? 'secondary' }}">
                                        {{ $activity->status }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex gap-1 justify-content-center">
                                        <a href="{{ route('activities.edit', $activity->id) }}"
                                            class="btn btn-sm btn-primary">
                                            Edit
                                        </a>
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
            // Inisialisasi DataTable
            $('#activitiesTable').DataTable({
                responsive: true,
                autoWidth: false, // biar kolom menyesuaikan isi
                pageLength: 10,
                lengthMenu: [5, 10, 25, 50],
                columnDefs: [{
                    orderable: false,
                    targets: 10
                }]
            });

            // Event SweetAlert untuk tombol Delete
            $('#activitiesTable tbody').on('submit', '.delete-form', function(e) {
                e.preventDefault();
                var form = this;

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
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });

            // SweetAlert untuk session sukses
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
